<?php 
    class Transaction {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function create($orderId, $paymentMethod, $paymentStatus = 'Pending') {
            $sql = "INSERT INTO transaction (order_id, payment_method, payment_status) 
                    VALUES (
                        '{$this->db->escape_string($orderId)}',
                        '{$this->db->escape_string($paymentMethod)}',
                        '{$this->db->escape_string($paymentStatus)}'
                    )";
            return $this->db->query($sql);
        }

        public function getByOrderId($orderId) {
            $sql = "SELECT * FROM transaction WHERE order_id = {$orderId}";
            return $this->db->query($sql)->fetch_assoc();
        }
    }
?>