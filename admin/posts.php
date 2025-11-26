<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>АДМИН ПАНЕЛЬ PHP - ПОСТЫ</title>
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<?php
require_once "../auth/functions.php";
requireAdmin();

try {
    $conn = new PDO("mysql:host=localhost;dbname=blog", "root", "");

    $sqlPost = "SELECT id, title, created_at FROM posts";

    $rowPosts = $conn->query($sqlPost);

    $posts = $rowPosts->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Произошла ошибка при загрузки постов";
}
?>

    <header class="header">
        <div class="container">
            <nav class="nav">
                <h2 class="nav__logo">
                    php blog
                </h2>

                <ul class="nav__list">
                    <li class="nav__list-item">
                        <a href="../index.php" class="nav__list-link">Блог</a>
                    </li>
                    <li class="nav__list-item">
                        <a href="../contact.php" class="nav__list-link">Контакты</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        <section class="admin">
            <div class="container">
                <h1 class="admin__title">Управление статьями</h1>

                <div class="posts-list">
                    <?php foreach ($posts as $post): ?>
                    <div class="post-item">
                        <h3 class="post-item__title">
                            <?php echo $post["title"]; ?>
                        </h3>
                        <p class="post-item__date">
                            Создано: <?php echo $post["created_at"]; ?>
                        </p>

                        <form method="POST" action="delete_post.php">
                            <div class="post-item__actions">
                                <input type="hidden" name="post_id" value="<?= $post[
                                    "id"
                                ] ?>">
                                <button class="post-item__delete">Удалить</button>
                            </div>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <p class="footer__text">&copy; 2025 PHP Blog</p>
        </div>
    </footer>
</body>

</html>
