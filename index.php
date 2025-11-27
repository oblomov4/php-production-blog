<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Блог PHP</title>
        <link rel="stylesheet" href="assets/css/reset.css" />
        <link rel="stylesheet" href="assets/css/style.css" />
    </head>

    <body>

    <?php
    require_once "auth/functions.php";

    $error = "";

    try {
        $conn = new PDO("mysql:host=localhost;dbname=blog", "root", "");

        $sqlPost = "SELECT * FROM posts";

        $rowPosts = $conn->query($sqlPost);

        $posts = $rowPosts->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = "Произошла ошибка при загрузки постов";
    }
    ?>

        <header class="header">
            <div class="container">
                <nav class="nav">
                    <h2 class="nav__logo">php blog</h2>

                    <ul class="nav__list">
                        <li class="nav__list-item">
                            <a href="index.php" class="nav__list-link">Блог</a>
                        </li>
                        <li class="nav__list-item">
                            <a href="contact.php" class="nav__list-link">Контакты</a>
                        </li>
                        <?php if (!isAuth()): ?>
                        <li class="nav__list-item">
                            <a href="login.php" class="nav__list-link">Вход</a>
                        </li>
                        <?php endif; ?>

                        <?php if (isAdmin()): ?>
                        <li class="nav__list-item">
                            <a href="/blog/admin" class="nav__list-link">Админка</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="main">
            <section class="promo">
                <div class="container">
                    <h1 class="title">Мой Блог PHP</h1>
                    <p class="subtitle">
                        Этот блог — практическая демонстрация моих навыков в
                        чистром PHP, созданный для портфолио и собеседований.
                    </p>
                </div>
            </section>

            <section class="blog">
                <div class="container">
                    <?php if ($error): ?>
                        <p class="err">
                            <?php echo $error; ?>
                        </p>
                    <?php endif; ?>
                    <div class="blog__items">
                        <?php foreach ($posts as $post): ?>
                        <a class="blog__item" href="<?= "single.php?id=" .
                            $post["id"] ?>">
                            <img
                                class="blog__item-img"
                                src="<?= mb_substr($post["image_url"], 3) ?>"
                                alt="<?= $post["title"] ?>"
                            />
                            <div class="blog__item-box">
                                <h3 class="blog__item-title">
                                    <?php echo $post["title"]; ?>
                                </h3>
                                <p class="blog__item-date">
                                    <?php echo $post["created_at"]; ?>
                                </p>
                                <p class="blog__item-content">
                                    <?php echo mb_substr(
                                        $post["text"],
                                        0,
                                        150,
                                    ) . "..."; ?>
                                </p>
                            </div>
                        </a>

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
