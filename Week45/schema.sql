drop database shops_db;
CREATE DATABASE shops_db;
USE shops_db;
CREATE TABLE shops
(
    shop_id INT AUTO_INCREMENT PRIMARY KEY,
    name    VARCHAR(40) UNIQUE NOT NULL,
    domain  VARCHAR(60)
);

CREATE TABLE users
(
    user_id    INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(40),
    last_name  VARCHAR(40),
    email      VARCHAR(255) UNIQUE NOT NULL
);
CREATE TABLE orders
(
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    sum      INT  NOT NULL,
    date     DATE NOT NULL,
    user_id  INT  NOT NULL,
    shop_id  INT  NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (user_id),
    FOREIGN KEY (shop_id) REFERENCES shops (shop_id)
);
CREATE TABLE products
(
    product_id         INT AUTO_INCREMENT PRIMARY KEY,
    name               VARCHAR(255) NOT NULL
);
CREATE TABLE categories
(
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name  VARCHAR(40) UNIQUE NOT NULL
);
CREATE TABLE order_product
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    order_id   INT NOT NULL,
    product_id INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders (order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products (product_id) ON DELETE CASCADE
);
CREATE TABLE product_category
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories (category_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products (product_id) ON DELETE CASCADE
);
CREATE TABLE order_category
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories (category_id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders (order_id) ON DELETE CASCADE
);
