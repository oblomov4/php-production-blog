<?php
try {
    // подключаемся к серверу
    // $conn = new PDO("mysql:host=localhost", "root", "");
    $conn = new PDO("mysql:host=localhost;dbname=blog", "root", "");
    $sqlUser = "CREATE TABLE users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        email varchar(255) NOT NULL UNIQUE,
        password varchar(255) NOT NULL,
        role ENUM('ADMIN', 'USER') NOT NULL DEFAULT 'USER'
    )";

    $conn->exec($sqlUser);
    echo "Таблица users создана, ";

    $sqlPost = 'CREATE TABLE posts (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        image_url varchar(255),
        text TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )';

    $conn->exec($sqlPost);

    echo "Таблица posts создана, ";

    $sqlComments = 'CREATE TABLE comments (
        id INT PRIMARY KEY AUTO_INCREMENT,
        text TEXT NOT NULL,
        user_id INT,
        post_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
    )';

    $conn->exec($sqlComments);
    echo "Таблица coments создана. ";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
