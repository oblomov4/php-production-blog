<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Блог PHP - Вход</title>
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
<?php
require_once "auth/functions.php";
generateCsrfToken();

function login($email, $password)
{
    if ($_SESSION["csrf_token"] !== $_POST["csrf_token"]) {
        die("CSRF атака заблокирована!");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Введите корректный email!";
    }

    $conn = new PDO("mysql:host=localhost;dbname=blog", "root", "");
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");

    $stmt->execute([$email]);

    $resultUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultUser) {
        if (password_verify($password, $resultUser["password"])) {
            $_SESSION["id"] = $resultUser["id"];
            $_SESSION["role"] = $resultUser["role"];
            header("Location: /blog/index.php");
        } else {
            return "Неверный логин или пароль!";
        }
    } else {
        return "Неверный логин или пароль!";
    }
}

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $error = login($_POST["email"], $_POST["password"]);
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
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        <section class="auth">
            <div class="container">
                <div class="auth__form">
                    <h1 class="auth__title">Вход в систему</h1>
                    <form method="POST" class="form">
                        <div class="form__group">
                            <input type="email" name="email" placeholder="Email" class="form__input" required>
                        </div>
                        <div class="form__group">
                            <input type="password" name="password" placeholder="Пароль" class="form__input" required>
                        </div>
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION[
                            "csrf_token"
                        ] ?>">
                        <button type="submit" class="form__button">Войти</button>
                    </form>
                    <p class="auth__link">
                        Нет аккаунта? <a href="register.php">Зарегистрироваться</a>
                    </p>

                    <?php echo $error ? "<b class='err'>{$error}</b>" : ""; ?>
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
