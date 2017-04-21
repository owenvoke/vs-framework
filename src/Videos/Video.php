<?php

namespace VS\Videos;

use VS\Config;
use VS\Routing\Router;
use VS\User\Account;

/**
 * Class Video
 */
class Video
{
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
                'INSERT INTO videos (hash, title, description, category, uploader)
                                VALUES (:hash, :title, :description, :category, :uploader)');
            $stmt->bindParam(':hash', $data->hash, \PDO::PARAM_STR);
            $stmt->bindParam(':title', $data->title, \PDO::PARAM_STR);
            $stmt->bindParam(':description', $data->description, \PDO::PARAM_STR);
            $stmt->bindParam(':category', $data->category, \PDO::PARAM_INT);
            $stmt->bindParam(':uploader', $data->uploader, \PDO::PARAM_INT);
            $stmt->execute();

            $data->id = (int)Config::connect()->lastInsertId();
            if ($data->id != 0) {
                Router::redirect('/v/' . $data->hash);
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

        // Generate file hash
        $data->hash = sha1_file($data->file['tmp_name']);

        // Generate destination path
        $destination = ROOT_PATH . 'uploads' . DS . $data->file['name'];

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
}