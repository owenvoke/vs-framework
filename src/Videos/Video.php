<?php

namespace VS\Framework\Videos;

use VS\Framework\Config;
use VS\Framework\Routing\Router;
use VS\Framework\User\Account;

/**
 * Class Video
 */
class Video
{
    public $id;
    public $hash;
    public $title;
    public $description;
    public $date;
    public $uploader;
    public $category;
    public $tags;
    public $file_type;

    public function __construct($hash)
    {
        $stmt = Config::connect()->prepare('SELECT * FROM videos WHERE hash = :hash');
        $stmt->bindParam(':hash', $hash, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        if ($result) {

            foreach ($result as $key => $value) {
                if (is_numeric($value)) {
                    $value = (int)$value;
                }
                $this->$key = $value;
            }

            $stmt = Config::connect()->prepare('SELECT id, username FROM users WHERE id = :id');
            $stmt->bindParam(':id', $this->uploader, \PDO::PARAM_STR);
            $stmt->execute();
            $this->uploader = $stmt->fetch(\PDO::FETCH_OBJ);

            $stmt = Config::connect()->prepare('SELECT * FROM video_tags WHERE id = :id');
            $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
            $stmt->execute();
            $this->tags = $stmt->fetchAll(\PDO::FETCH_OBJ);

            $stmt = Config::connect()->prepare('SELECT * FROM categories WHERE id = :id');
            $stmt->bindParam(':id', $this->category, \PDO::PARAM_INT);
            $stmt->execute();
            $this->category = $stmt->fetch(\PDO::FETCH_OBJ);
        }
    }

    /**
     * @param object $data
     * @return bool
     */
    public static function upload($data)
    {
        $data = self::validate($data);

        if (!$data->error) {
            $data->uploader = (int)Account::user('id');
            $stmt = Config::connect()->prepare(
                'INSERT INTO videos (hash, title, description, category, uploader, date, file_type)
                                VALUES (:hash, :title, :description, :category, :uploader, :date, :file_type)');
            $stmt->bindParam(':hash', $data->hash, \PDO::PARAM_STR);
            $stmt->bindParam(':title', $data->title, \PDO::PARAM_STR);
            $stmt->bindParam(':description', $data->description, \PDO::PARAM_STR);
            $stmt->bindParam(':category', $data->category, \PDO::PARAM_INT);
            $stmt->bindParam(':uploader', $data->uploader, \PDO::PARAM_INT);
            $stmt->bindParam(':date', $data->date, \PDO::PARAM_INT);
            $stmt->bindParam(':file_type', $data->file_type, \PDO::PARAM_STR);
            $stmt->execute();

            $data->id = (int)Config::connect()->lastInsertId();
            if ($data->id != 0) {
                Router::redirect('/v/' . $data->hash);
            } else {
                $data->error = 'Failed to upload video.';
            }
        }

        return $data->error;
    }

    /**
     * @return array
     */
    public static function categories()
    {
        $stmt = Config::connect()->prepare('SELECT * FROM categories');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param null|object $data
     * @return bool|object
     */
    public static function validate($data = null)
    {
        if (!$data) {
            return false;
        }

        // Set the upload date (UNIX timestamp)
        $data->date = time();

        // Check if user can upload
        if (!$data->can_upload) {
            $data->error = 'User is not allowed to upload.';
            return $data;
        }

        // Check for set file errors...
        if ($data->file['error']) {
            switch ($data->file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $data->error = 'Upload limit exceeded.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $data->error = 'File partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $data->error = 'No file selected.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $data->error = 'No temp directory.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $data->error = 'Unable to write file.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $data->error = 'Upload stopped by extension.';
                    break;
                default:
                    $data->error = 'An unknown file error occurred.';
                    break;
            }
            return $data;
        }

        // Check if the file is too large
        if ($data->file['size'] > Config::MAX_UPLOAD_SIZE) {
            $data->error = 'File is too large.';
            return $data;
        }

        // Check if it's a valid category
        if (!$data->category || !is_int($data->category) || !Categories::byId($data->category)) {
            $data->error = 'Invalid category.';
            return $data;
        }

        // Check it's a valid mime type
        if (!in_array($data->file['type'], Config::VALID_MIME_TYPES)) {
            $data->error = 'Invalid mime type.';
            return $data;
        }

        // Check for date change (this is unlikely)
        if ($data->time > time()) {
            $data->error = 'Invalid upload date.';
            return $data;
        }

        // Check for invalid file type
        $data->file_type = pathinfo($data->file['name'], PATHINFO_EXTENSION);
        if (!$data->file_type) {
            $data->error = 'Invalid file type.';
            return $data;
        }

        // Generate file hash
        $data->hash = sha1_file($data->file['tmp_name']);

        // Generate destination path
        $destination = ROOT_PATH . 'uploads' . DS . $data->hash . '.' . $data->file_type;

        // Check if able to create thumbnail
        if (!self::create_thumbnail($data)) {
            $data->error = 'Unable to create thumbnail.';
            return $data;
        }

        // Check for duplicate (if config is set to disallow duplicates)
        if (!Config::ALLOW_DUPLICATE_FILES) {
            $stmt = Config::connect()->prepare('SELECT * FROM videos WHERE hash = :hash');
            $stmt->bindParam(':hash', $data->hash, \PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0 || file_exists($destination)) {
                $data->error = 'File is already uploaded.';
                return $data;
            }
        }

        // Attempt to upload file
        if (!@copy($data->file['tmp_name'], $destination)) {
            if (!@move_uploaded_file($data->file['tmp_name'], $destination)) {
                $data->error = 'Unable to save file.';
                return $data;
            }
        }

        return $data;
    }

    public static function create_thumbnail($data)
    {
        if (!$data) {
            return false;
        }

        $data->thumbnail_path = ROOT_PATH . 'uploads' . DS . $data->hash . '.jpg';

        $cmd = "ffmpeg -i {$data->file['tmp_name']} -deinterlace -an -ss 1 -t 00:00:01 -s 250x130 -r 1 -y -vcodec mjpeg -f mjpeg {$data->thumbnail_path} 2>&1";

        exec($cmd, $output, $return_value);

        if (!$return_value) {
            return true;
        }

        return false;
    }
}