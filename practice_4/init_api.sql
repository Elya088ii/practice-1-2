CREATE DATABASE IF NOT EXISTS appDB;
USE appDB;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

-- Таблица заказов (связана с users)
CREATE TABLE IF NOT EXISTS orders (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    product_name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Тестовые данные
INSERT IGNORE INTO users (id, name, email) VALUES (1, 'Ivan', 'ivan@example.com');
INSERT IGNORE INTO users (id, name, email) VALUES (2, 'Anna', 'anna@example.com');

INSERT IGNORE INTO orders (id, user_id, product_name, price) VALUES (1, 1, 'Laptop', 50000.00);
INSERT IGNORE INTO orders (id, user_id, product_name, price) VALUES (2, 1, 'Mouse', 1500.00);
INSERT IGNORE INTO orders (id, user_id, product_name, price) VALUES (3, 2, 'Keyboard', 3000.00);