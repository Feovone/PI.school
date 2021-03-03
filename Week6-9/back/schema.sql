drop database users_db;
CREATE DATABASE users_db;
USE users_db;
CREATE TABLE users
(
    user_id    INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(40),
    last_name  VARCHAR(40),
    email      VARCHAR(255) UNIQUE NOT NULL,
    password      VARCHAR(255) NOT NULL,
    number          VARCHAR(40)
);