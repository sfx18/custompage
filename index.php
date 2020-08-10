<?php
session_start();
// if ($_SESSION['user']) {
//     header('Location: profile.php');
// }

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>


<!-- Форма авторизации -->
<div class="logo">
<img src="assets/css/images/logo_full.png" >
<h1>Учет кандидатов</h1>
</div>

    <div class="container">
        <form action="vendor/signin.php" method="post">
            <label>Логин</label>
            <input type="text" name="login" placeholder="Введите свой логин">
            <label>Пароль</label>
            <input type="password" name="password" placeholder="Введите пароль">
            <input type="hidden" name="groupid">
            <button type="submit">Войти</button>

            <?php
            
                if ($_SESSION['message']) {
                    echo '<p class="msg"> ' . $_SESSION['message'] . ' </p>';
                }
                unset($_SESSION['message']);
            ?>
        </form>
    </div>
    

</body>
</html>
