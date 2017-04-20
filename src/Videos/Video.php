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
            $destination = ROOT_PATH . 'resources' . DS . 'videos' . DS . $data->file['name'];
            if (
                file_exists($destination) ||
                move_uploaded_file(
                    $data->file['tmp_name'],
                    $destination
                )
            ) {
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
                if ($data->id > 0) {
                    Router::redirect('/v/' . $data->hash);
                }
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

        $data->hash = sha1_file($data->file['tmp_name']);
        if (!Config::ALLOW_DUPLICATE_FILES) {
            $stmt = Config::connect()->prepare('SELECT * FROM videos WHERE hash = :hash');
            $stmt->bindParam(':hash', $data->hash, \PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $data->error = 'File is already uploaded.';
                return $data;
            }
        }

        return $data;
    }
}