<?php

namespace VS\Framework\User;

use VS\Framework\Config;

class User
{
    public $id;
    public $username;
    public $email;
    public $acl;
    public $info;
    public $videos;

    public function __construct($username, $limit = null)
    {
        $db = Config::connect();
        $stmt = $db->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_OBJ);
        if ($result) {

            foreach ($result as $key => $value) {
                if (is_numeric($value)) {
                    $value = (int)$value;
                }
                $this->$key = $value;
            }

            // Get user ACL
            $stmt = $db->prepare('SELECT * FROM acls WHERE id = :id');
            $stmt->bindParam(':id', $this->acl, \PDO::PARAM_STR);
            $stmt->execute();
            $this->acl = $stmt->fetch(\PDO::FETCH_OBJ);

            // Get user videos
            if ($limit) {
                $stmt = $db->prepare('SELECT * FROM videos WHERE uploader = :id LIMIT :limit');
                $stmt->bindParam(':id', $this->id, \PDO::PARAM_STR);
                $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            } else {
                $stmt = $db->prepare('SELECT * FROM videos WHERE uploader = :id');
                $stmt->bindParam(':id', $this->id, \PDO::PARAM_STR);
            }
            $stmt->execute();
            $this->videos = $stmt->fetchAll(\PDO::FETCH_OBJ);

            // Get user additional info
            $stmt = $db->prepare('SELECT * FROM users_info WHERE id = :id');
            $stmt->bindParam(':id', $this->id, \PDO::PARAM_INT);
            $stmt->execute();
            $this->info = $stmt->fetch(\PDO::FETCH_OBJ);
        }
    }
}