<?php
    class Product {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        // Create a new product
        public function create($categoryId, $name, $description, $price, $availability = true, $image = null) {
            $sql = "INSERT INTO product (category_id, name, description, price, availability, image) 
                    VALUES (
                        {$categoryId},
                        '{$this->db->escape_string($name)}',
                        '{$this->db->escape_string($description)}',
                        {$price},
                        " . ($availability ? "TRUE" : "FALSE") . ",
                        " . ($image ? "'{$this->db->escape_string($image)}'" : "NULL") . "
                    )";
            return $this->db->query($sql);
        }

        // Fetch all products
        public function getAll() {
            $sql = "SELECT p.*, pc.name AS category_name 
                    FROM product p 
                    LEFT JOIN product_category pc ON p.category_id = pc.category_id";
            $result = $this->db->query($sql);
            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        }

        // Fetch a single product by ID
        public function getById($productId) {
            $sql = "SELECT p.*, pc.name AS category_name 
                    FROM product p 
                    LEFT JOIN product_category pc ON p.category_id = pc.category_id
                    WHERE p.product_id = {$productId}";
            $result = $this->db->query($sql);
            return $result ? $result->fetch_assoc() : null;
        }

        // Update a product
        public function update($productId, $categoryId, $name, $description, $price, $availability, $image = null) {
            $sql = "UPDATE product 
                    SET 
                        category_id = {$categoryId},
                        name = '{$this->db->escape_string($name)}',
                        description = '{$this->db->escape_string($description)}',
                        price = {$price},
                        availability = " . ($availability ? "TRUE" : "FALSE") . ",
                        image = " . ($image ? "'{$this->db->escape_string($image)}'" : "NULL") . "
                    WHERE product_id = {$productId}";
            return $this->db->query($sql);
        }

        // Delete a product
        public function delete($productId) {
            $sql = "DELETE FROM product WHERE product_id = {$productId}";
            return $this->db->query($sql);
        }

        // Add product options
        public function addOption($productId, $optionName, $optionValues) {
            $sql = "INSERT INTO product_option (product_id, option_name, option_values) 
                    VALUES (
                        {$productId},
                        '{$this->db->escape_string($optionName)}',
                        '{$this->db->escape_string($optionValues)}'
                    )";
            return $this->db->query($sql);
        }

        // Add product add-ons
        public function addAddon($productId, $addonName, $addonPrice) {
            $sql = "INSERT INTO product_addon (product_id, addon_name, addon_price) 
                    VALUES (
                        {$productId},
                        '{$this->db->escape_string($addonName)}',
                        {$addonPrice}
                    )";
            return $this->db->query($sql);
        }

        // Fetch options for a product
        public function getOptions($productId) {
            $sql = "SELECT * FROM product_option WHERE product_id = {$productId}";
            $result = $this->db->query($sql);
            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        }

        // Fetch add-ons for a product
        public function getAddons($productId) {
            $sql = "SELECT * FROM product_addon WHERE product_id = {$productId}";
            $result = $this->db->query($sql);
            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        }
    }

?>