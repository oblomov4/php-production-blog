<?php
require_once "../auth/functions.php";
requireAdmin();

if (isset($_POST["post_id"])) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=blog", "root", "");

        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");

        $stmt->execute([$_POST["post_id"]]);

        header("Location: posts.php");
        exit();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
