-- Create database mamaku_vegetarian
CREATE DATABASE mamaku_vegetarian;

-- Use the created database
USE mamaku_vegetarian;

-- Create user table (combines admin and registered members)
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    username VARCHAR(50) UNIQUE,            -- Used for admins
    email VARCHAR(100) UNIQUE,              -- Used for members
    phone_number VARCHAR(15),
    address TEXT,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('Member', 'Admin', 'SuperAdmin') DEFAULT 'Member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create product categories table
CREATE TABLE product_category (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

-- Create product (food items) table
CREATE TABLE product (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    availability BOOLEAN DEFAULT TRUE,
    image VARCHAR(255),              
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES product_category(category_id)
);

-- Create product options table (e.g., size, type)
CREATE TABLE product_option (
    option_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    option_name TEXT NOT NULL,       
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

-- Create product add-ons table
CREATE TABLE product_addon (
    addon_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    addon_name VARCHAR(50) NOT NULL,
    addon_price DECIMAL(10, 2) NOT NULL, 
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

-- Create cart table (each user has one cart)
CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,  -- One cart per user
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);

CREATE TABLE cart_item (
    cart_item_id INT AUTO_INCREMENT PRIMARY KEY,  
    cart_id INT, 
    product_id INT,                                
    option_name TEXT,                            
    addon_name TEXT,                             
    remarks TEXT,                                 
    quantity INT DEFAULT 1,                       
    price DECIMAL(10, 2) NOT NULL,               
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    FOREIGN KEY (cart_id) REFERENCES cart(cart_id),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

-- Create orders table
CREATE TABLE `order` (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('Pending', 'Processing', 'Completed', 'Cancelled') DEFAULT 'Pending',
    daily_order_no INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);

CREATE TABLE order_item (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,  
    order_id INT,                                  
    item_name TEXT,                                
    option_name TEXT,                              
    addon_name TEXT,                               
    remarks TEXT,                                  
    quantity INT DEFAULT 1,                        
    price DECIMAL(10, 2) NOT NULL,                 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    FOREIGN KEY (order_id) REFERENCES `order`(order_id) 
);

-- Create transaction table
CREATE TABLE transaction (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    payment_method ENUM('CreditCard', 'DebitCard', 'Cash', 'E-Wallet') DEFAULT 'CreditCard',
    payment_status ENUM('Pending', 'Completed', 'Failed') DEFAULT 'Pending',
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES `order`(order_id)
);
