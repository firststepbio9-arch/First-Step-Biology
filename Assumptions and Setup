CREATE DATABASE admin_panel;
USE admin_panel;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'user') DEFAULT 'user'
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255)
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    category_id INT,
    price DECIMAL(10,2),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    course_ids JSON,  -- e.g., ["1","2"] for purchased course IDs
    total_amount DECIMAL(10,2),
    payment_status ENUM('pending', 'delivered') DEFAULT 'pending',
    purchase_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert sample admin user (for role validation)
INSERT INTO users (username, email, password, role) VALUES ('Admin', 'fsbiology@83', MD5('Genomics@83'), 'admin');

-- Sample data
INSERT INTO categories (name) VALUES ('Biology'), ('Genomics');
INSERT INTO courses (title, description, category_id, price) VALUES ('Intro to Biology', 'Basic course', 1, 100.00);
INSERT INTO transactions (user_id, course_ids, total_amount, payment_status) VALUES (1, '["1"]', 100.00, 'pending');
