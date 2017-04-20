<?php

namespace VS\Videos;

use VS\Config;

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
        if (self::validate($data)) {

        }

        return false;
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
     * @return bool
     */
    public static function validate($data = null)
    {
        if (!$data) {
            return false;
        }

        // Check if user can upload
        if (!$data->can_upload) {
            return false;
        }

        // Check if the file is too large
        if (!$data->file['size'] < Config::MAX_UPLOAD_SIZE) {
            return false;
        }

        // Check if it's a valid category
        if (!$data->category || !is_int($data->category) || !Categories::byId($data->category)) {
            return false;
        }

        // Check it's a valid mime type
        if (!in_array($data->file->type, Config::VALID_MIME_TYPES)) {
            return false;
        }

        return true;
    }
}