<?php

namespace VS\Videos;

use VS\Config;

/**
 * Class Categories
 */
class Categories
{
    public static function byId($id)
    {
        if (!$id) {
            return false;
        }

        $stmt = Config::connect()->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
}