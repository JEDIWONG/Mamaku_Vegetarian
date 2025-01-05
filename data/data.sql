use mamaku_vegetarian; 

-- Insert values into product_category table
INSERT INTO product_category (category_id, name, description) VALUES
(1, 'Main Course', 'Delicious vegetarian main dishes.'),
(2, 'Snacks', 'Tasty vegetarian snacks.'),
(3, 'Desserts', 'Sweet vegetarian desserts.');

-- Insert values into product table
INSERT INTO product (product_id, category_id, name, description, price, availability, image) VALUES
(1, 1, 'Vegetarian Curry', 'Spicy and flavorful curry.', 12.99, TRUE, 'prod_1.jpg'),
(2, 1, 'Grilled Tofu Steak', 'Juicy tofu steak with herbs.', 15.99, TRUE, 'prod_2.jpg'),
(3, 1, 'Vegetable Stir Fry', 'Healthy stir-fried veggies.', 10.99, TRUE, 'prod_3.jpg'),
(4, 1, 'Mushroom Risotto', 'Creamy mushroom risotto.', 13.99, TRUE, 'prod_4.jpg'),
(5, 2, 'Spring Rolls', 'Crispy and delicious rolls.', 6.99, TRUE, 'prod_5.jpg'),
(6, 2, 'Vegetable Samosas', 'Spicy and crispy samosas.', 5.99, TRUE, 'prod_6.jpg'),
(7, 2, 'Sweet Potato Fries', 'Perfectly crispy fries.', 4.99, TRUE, 'prod_7.jpg'),
(8, 2, 'Garlic Bread', 'Crunchy garlic bread.', 3.99, TRUE, 'prod_8.jpg'),
(9, 3, 'Chocolate Cake', 'Rich and creamy cake.', 8.99, TRUE, 'prod_9.jpg'),
(10, 3, 'Fruit Salad', 'Fresh mixed fruits.', 6.99, TRUE, 'prod_10.jpg'),
(11, 3, 'Vegan Ice Cream', 'Creamy vegan delight.', 5.99, TRUE, 'prod_11.jpg'),
(12, 3, 'Banana Pancakes', 'Fluffy banana pancakes.', 7.99, TRUE, 'prod_12.jpg');

-- Insert values into product_option table
INSERT INTO product_option (option_id, product_id, option_name) VALUES
(1, 1, 'Mild, Medium, Spicy'),
(2, 2, 'Herb-Crusted, Garlic-Rubbed'),
(3, 3, 'Soy Sauce, Teriyaki'),
(4, 4, 'Creamy, Low-Fat'),
(5, 5, 'Small, Medium, Large'),
(6, 6, 'None'),
(7, 7, 'None'),
(8, 8, 'None'),
(9, 9, 'None'),
(10, 10, 'Honey-Drizzled, Plain'),
(11, 11, 'Vanilla, Chocolate, Strawberry'),
(12, 12, 'Syrup, Plain');

-- Insert values into product_addon table
INSERT INTO product_addon (addon_id, product_id, addon_name, addon_price) VALUES
(1, 1, 'Extra Curry Sauce', 2.50),
(2, 2, 'Extra Tofu', 3.00),
(3, 3, 'Extra Veggies', 2.00),
(4, 9, 'Extra Chocolate Syrup', 1.50),
(5, 10, 'Yogurt Dressing', 1.00);


-- Insert 10 carts (one per user)
INSERT INTO cart (user_id, created_at) VALUES
(1, '2025-01-05 10:00:00'),
(2, '2025-01-06 11:00:00'),
(3, '2025-01-07 12:00:00'),
(4, '2025-01-08 13:00:00'),
(5, '2025-01-09 14:00:00'),
(6, '2025-01-10 15:00:00'),
(7, '2025-01-11 16:00:00'),
(8, '2025-01-12 17:00:00'),
(9, '2025-02-01 09:00:00'),
(10, '2025-02-02 10:00:00');

-- Insert 10 cart items
INSERT INTO cart_item (cart_id, product_id, option_name, addon_name, remarks, quantity, price, added_at) VALUES
(1, 1, 'Mild', 'Extra Curry Sauce', 'No spicy food', 2, 12.99, '2025-01-05 10:05:00'),
(2, 2, 'Herb-Crusted', 'Extra Tofu', '', 1, 15.99, '2025-01-06 11:10:00'),
(3, 3, 'Soy Sauce', '', 'Extra sauce please', 3, 10.99, '2025-01-07 12:15:00'),
(4, 4, 'Creamy', '', '', 1, 13.99, '2025-01-08 13:20:00'),
(5, 5, 'Medium', '', 'Crunchy', 1, 6.99, '2025-01-09 14:25:00'),
(6, 6, 'None', '', '', 2, 5.99, '2025-01-10 15:30:00'),
(7, 7, 'None', '', 'For kids', 1, 4.99, '2025-01-11 16:35:00'),
(8, 8, 'None', '', 'Simple taste', 1, 3.99, '2025-01-12 17:40:00'),
(9, 9, 'None', '', '', 1, 8.99, '2025-02-01 09:45:00'),
(10, 10, 'Honey-Drizzled', 'Yogurt Dressing', 'Fresh fruit', 2, 6.99, '2025-02-02 10:50:00');

-- Insert 10 orders
INSERT INTO `order` (user_id, total_amount, daily_order_no, status, created_at) VALUES
(1, 50.99, 101, 'Pending', '2025-01-05 11:00:00'),
(2, 55.99, 102, 'Pending', '2025-01-06 12:00:00'),
(3, 35.99, 103, 'Pending', '2025-01-07 13:00:00'),
(4, 30.99, 104, 'Pending', '2025-01-08 14:00:00'),
(5, 25.99, 105, 'Pending', '2025-01-09 15:00:00'),
(6, 50.99, 106, 'Pending', '2025-01-10 16:00:00'),
(7, 40.99, 107, 'Pending', '2025-01-11 17:00:00'),
(8, 35.99, 108, 'Pending', '2025-01-12 18:00:00'),
(9, 45.99, 109, 'Pending', '2025-02-01 10:00:00'),
(10, 39.99, 110, 'Pending', '2025-02-02 11:00:00');

-- Insert 10 order items
INSERT INTO order_item (order_id, item_name, option_name, addon_name, remarks, quantity, price, created_at) VALUES
(1, 'Vegetarian Curry', 'Mild', 'Extra Curry Sauce', 'No spicy food', 2, 12.99, '2025-01-05 11:05:00'),
(2, 'Grilled Tofu Steak', 'Herb-Crusted', 'Extra Tofu', '', 1, 15.99, '2025-01-06 12:10:00'),
(3, 'Vegetable Stir Fry', 'Soy Sauce', '', 'Extra sauce please', 3, 10.99, '2025-01-07 13:15:00'),
(4, 'Mushroom Risotto', 'Creamy', '', '', 1, 13.99, '2025-01-08 14:20:00'),
(5, 'Spring Rolls', 'Medium', '', 'Crunchy', 1, 6.99, '2025-01-09 15:25:00'),
(6, 'Vegetable Samosas', 'None', '', '', 2, 5.99, '2025-01-10 16:30:00'),
(7, 'Sweet Potato Fries', 'None', '', 'For kids', 1, 4.99, '2025-01-11 17:35:00'),
(8, 'Garlic Bread', 'None', '', 'Simple taste', 1, 3.99, '2025-01-12 18:40:00'),
(9, 'Chocolate Cake', 'None', '', '', 1, 8.99, '2025-02-01 10:45:00'),
(10, 'Fruit Salad', 'Honey-Drizzled', 'Yogurt Dressing', 'Fresh fruit', 2, 6.99, '2025-02-02 11:50:00');

-- Insert 10 transactions
INSERT INTO transaction (order_id, payment_method, payment_status, transaction_date) VALUES
(1, 'CreditCard', 'Completed', '2025-01-05 11:15:00'),
(2, 'DebitCard', 'Completed', '2025-01-06 12:20:00'),
(3, 'Cash', 'Completed', '2025-01-07 13:25:00'),
(4, 'E-Wallet', 'Pending', '2025-01-08 14:30:00'),
(5, 'CreditCard', 'Completed', '2025-01-09 15:35:00'),
(6, 'DebitCard', 'Failed', '2025-01-10 16:40:00'),
(7, 'Cash', 'Completed', '2025-01-11 17:45:00'),
(8, 'E-Wallet', 'Pending', '2025-01-12 18:50:00'),
(9, 'CreditCard', 'Completed', '2025-02-01 10:55:00'),
(10, 'DebitCard', 'Completed', '2025-02-02 11:00:00');