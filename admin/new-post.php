<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>АДМИН ПАНЕЛЬ PHP - СОЗДАТЬ ПОСТ</title>
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php
    require_once "../auth/functions.php";
    requireAdmin();

    function addPost() {}
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
                <h1 class="admin__title">Создать статью</h1>

                <form method="POST" class="form" enctype="multipart/form-data">
                    <div class="form__group">
                        <input type="text" name="title" placeholder="Заголовок статьи" class="form__input" required>
                    </div>

                    <div class="form__group">
                        <input type="file" name="image" accept="image/*" class="form__input" required>
                    </div>

                    <div class="form__group">
                        <textarea name="content" placeholder="Содержание статьи" class="form__textarea" rows="10" required></textarea>
                    </div>

                    <button type="submit" class="form__button">Опубликовать</button>
                </form>
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
