<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Блог PHP</title>
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php
    require_once "auth/functions.php";

    $error = "";

    if (isset($_GET["id"])) {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=blog", "root", "");

            $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");

            $stmt->execute([$_GET["id"]]);

            $post = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$post) {
                http_response_code(404);
                die("Страница не найдена");
            }
        } catch (PDOException $e) {
            $error = "Что-то пошло не так!";
        }
    } else {
        http_response_code(404);
        die("Страница не найдена");
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
        <div class="container">

            <?php if ($error): ?>
                <p class="err">
                    <?php echo $error; ?>
                </p>
            <?php endif; ?>

            <h1 class="article__title"><?php echo $post["title"]; ?></h1>

            <div class="article__meta">
                <span class="article__date"><?php echo $post[
                    "created_at"
                ]; ?></span>
            </div>

            <img
                class="article__img"
                src="<?= mb_substr($post["image_url"], 3) ?>"
                alt="<?= $post["title"] ?>"
            />

            <div class="article__content">
                <?php echo $post["text"]; ?>
            </div>
        </div>
    </main>



    <footer class="footer">
        <div class="container">
            <p class="footer__text">&copy; 2025 PHP Blog</p>
        </div>
    </footer>


    <script src="assets/js/main.js"></script>
</body>

</html>
