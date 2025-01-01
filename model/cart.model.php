<?php
class Cart {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($userId) {
        $sql = "INSERT INTO cart (user_id) VALUES ('{$this->db->escape_string($userId)}')";
        return $this->db->query($sql);
    }

    public function getByUserId($userId) {
        $sql = "SELECT * FROM cart WHERE user_id = {$userId}";
        return $this->db->query($sql)->fetch_assoc();
    }
}

