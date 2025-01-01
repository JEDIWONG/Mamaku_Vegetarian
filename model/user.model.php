<?php
    class User {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function create($firstName, $lastName, $username, $email, $phoneNumber, $address, $passwordHash, $role = 'Member') {
            $sql = "INSERT INTO user (first_name, last_name, username, email, phone_number, address, password_hash, role) 
                    VALUES (
                        '{$this->db->escape_string($firstName)}',
                        '{$this->db->escape_string($lastName)}',
                        '{$this->db->escape_string($username)}',
                        '{$this->db->escape_string($email)}',
                        '{$this->db->escape_string($phoneNumber)}',
                        '{$this->db->escape_string($address)}',
                        '{$this->db->escape_string($passwordHash)}',
                        '{$this->db->escape_string($role)}'
                    )";
            return $this->db->query($sql);
        }

        public function getById($userId) {
            $sql = "SELECT * FROM user WHERE user_id = {$userId}";
            return $this->db->query($sql)->fetch_assoc();
        }
    }

?>