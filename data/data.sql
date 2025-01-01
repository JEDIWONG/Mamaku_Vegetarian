use mamaku_vegetarian; 

-- Insert values into product_category table
INSERT INTO product_category (category_id, name, description) VALUES
(1, 'Main Course', 'Delicious vegetarian main dishes.'),
(2, 'Snacks', 'Tasty vegetarian snacks.'),
(3, 'Desserts', 'Sweet vegetarian desserts.');

-- Insert values into product table
INSERT INTO product (product_id, category_id, name, description, price, availability, image) VALUES
(1, 1, 'Vegetarian Curry', 'Spicy and flavorful curry.', 12.99, TRUE, 'placeholder.png'),
(2, 1, 'Grilled Tofu Steak', 'Juicy tofu steak with herbs.', 15.99, TRUE, 'placeholder.png'),
(3, 1, 'Vegetable Stir Fry', 'Healthy stir-fried veggies.', 10.99, TRUE, 'placeholder.png'),
(4, 1, 'Mushroom Risotto', 'Creamy mushroom risotto.', 13.99, TRUE, 'placeholder.png'),
(5, 2, 'Spring Rolls', 'Crispy and delicious rolls.', 6.99, TRUE, 'placeholder.png'),
(6, 2, 'Vegetable Samosas', 'Spicy and crispy samosas.', 5.99, TRUE, 'placeholder.png'),
(7, 2, 'Sweet Potato Fries', 'Perfectly crispy fries.', 4.99, TRUE, 'placeholder.png'),
(8, 2, 'Garlic Bread', 'Crunchy garlic bread.', 3.99, TRUE, 'placeholder.png'),
(9, 3, 'Chocolate Cake', 'Rich and creamy cake.', 8.99, TRUE, 'placeholder.png'),
(10, 3, 'Fruit Salad', 'Fresh mixed fruits.', 6.99, TRUE, 'placeholder.png'),
(11, 3, 'Vegan Ice Cream', 'Creamy vegan delight.', 5.99, TRUE, 'placeholder.png'),
(12, 3, 'Banana Pancakes', 'Fluffy banana pancakes.', 7.99, TRUE, 'placeholder.png');

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
