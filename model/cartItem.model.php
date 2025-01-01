<?php 

    class CartItem {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function addItem($cartId, $productId, $quantity, $optionId = null, $addonId = null, $remarks = null) {
            $sql = "INSERT INTO cart_item (cart_id, product_id, quantity, option_id, addon_id, remarks) 
                    VALUES (
                        '{$this->db->escape_string($cartId)}',
                        '{$this->db->escape_string($productId)}',
                        '{$this->db->escape_string($quantity)}',
                        '{$this->db->escape_string($optionId)}',
                        '{$this->db->escape_string($addonId)}',
                        '{$this->db->escape_string($remarks)}'
                    )";
            return $this->db->query($sql);
        }

        public function getByCartId($cartId) {
            $sql = "SELECT * FROM cart_item WHERE cart_id = {$cartId}";
            return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
        }
    }

?>