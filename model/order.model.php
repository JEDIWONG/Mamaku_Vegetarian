<?php
    class Order {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function create($userId, $totalAmount) {
            $sql = "INSERT INTO `order` (user_id, total_amount) 
                    VALUES (
                        '{$this->db->escape_string($userId)}',
                        '{$this->db->escape_string($totalAmount)}'
                    )";
            return $this->db->query($sql);
        }

        public function getById($orderId) {
            $sql = "SELECT * FROM `order` WHERE order_id = {$orderId}";
            return $this->db->query($sql)->fetch_assoc();
        }
    }

?>
