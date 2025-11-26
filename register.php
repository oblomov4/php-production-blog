<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Блог PHP - Регистрация</title>
        <link rel="stylesheet" href="assets/css/reset.css" />
        <link rel="stylesheet" href="assets/css/style.css" />
    </head>

    <body>
        <?php
        $error = "";
        function register($email, $password, $confirmPassoword)
        {
            global $error;
            if ($password !== $confirmPassoword) {
                $error = "Введенные пароли не совпадают!";
                return;
            }

            if (strpos($email, "@") === false) {
                $error = "Введите корректный email";
                return;
            }

            try {
                $conn = new PDO("mysql:host=localhost;dbname=blog", "root", "");

                $stmt = $conn->prepare(
                    "SELECT email FROM users WHERE email = ?",
                );

                $stmt->execute([$email]);

                $resultUser = $stmt->fetch(PDO::FETCH_ASSOC);

                $userExist = $resultUser["email"];

                if ($userExist === $email) {
                    $error = "Данный пользователь уже зарегистрирован";
                    return;
                }

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare(
                    "INSERT INTO users (email, password) VALUES (?, ?)",
                );

                $stmt->execute([$email, $passwordHash]);

                header("Location: /blog/login.php");
            } catch (PDOException $e) {
                $error = $e->getMessage();
            }
        }

        if (
            isset($_POST["email"]) &&
            isset($_POST["password"]) &&
            isset($_POST["confirm_password"])
        ) {
            register(
                $_POST["email"],
                $_POST["password"],
                $_POST["confirm_password"],
            );
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
                            <a href="contact.php" class="nav__list-link"
                                >Контакты</a
                            >
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="main">
            <section class="auth">
                <div class="container">
                    <div class="auth__form">
                        <h1 class="auth__title">Регистрация</h1>
                        <form method="POST" class="form">
                            <div class="form__group">
                                <input
                                    type="email"
                                    name="email"
                                    placeholder="Email"
                                    class="form__input"
                                    required
                                />
                            </div>
                            <div class="form__group">
                                <input
                                    type="password"
                                    name="password"
                                    placeholder="Пароль"
                                    class="form__input"
                                    required
                                />
                            </div>
                            <div class="form__group">
                                <input
                                    type="password"
                                    name="confirm_password"
                                    placeholder="Подтвердите пароль"
                                    class="form__input"
                                    required
                                />
                            </div>
                            <button type="submit" class="form__button">
                                Зарегистрироваться
                            </button>
                        </form>
                        <p class="auth__link">
                            Есть аккаунт? <a href="login.php">Войти</a>
                        </p>

                        <?php echo $error
                            ? "<b class='err'>{$error}</b>"
                            : ""; ?>
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
