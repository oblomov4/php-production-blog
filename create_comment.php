<?php
require_once "auth/functions.php";

if (!isAuth()) {
    http_response_code(401);
    die("Forbidden: Authentication required");
}

if (isset($_POST["post_id"]) && isset($_POST["comment"])) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=blog", "root", "");
        $stmt = $conn->prepare(
            "INSERT INTO comments (text, user_id, post_id) VALUES (?, ?, ?)",
        );

        $stmt->execute([
            htmlentities($_POST["comment"]),
            $_SESSION["id"],
            $_POST["post_id"],
        ]);

        header("Location: single.php?id=" . $_POST["post_id"]);
    } catch (PDOException $e) {
        http_response_code(500);
        die("Server Error");
    }
} else {
    http_response_code(400);
    die("Bad Request");
}
