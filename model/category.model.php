<?php
    class ProductCategory {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        // Create a new product category
        public function create($name, $description = null) {
            $sql = "INSERT INTO product_category (name, description) 
                    VALUES (
                        '{$this->db->escape_string($name)}',
                        '{$this->db->escape_string($description)}'
                    )";
            return $this->db->query($sql);
        }

        // Get all product categories
        public function getAll() {
            $sql = "SELECT * FROM product_category";
            $result = $this->db->query($sql);
            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        }

        // Get a product category by ID
        public function getById($categoryId) {
            $sql = "SELECT * FROM product_category WHERE category_id = {$categoryId}";
            $result = $this->db->query($sql);
            return $result ? $result->fetch_assoc() : null;
        }

        // Update a product category
        public function update($categoryId, $name, $description = null) {
            $sql = "UPDATE product_category 
                    SET 
                        name = '{$this->db->escape_string($name)}',
                        description = '{$this->db->escape_string($description)}'
                    WHERE 
                        category_id = {$categoryId}";
            return $this->db->query($sql);
        }

        // Delete a product category
        public function delete($categoryId) {
            $sql = "DELETE FROM product_category WHERE category_id = {$categoryId}";
            return $this->db->query($sql);
        }
    }

?> 