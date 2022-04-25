<?php
require_once ("core/databases/dbconfig.php");
?>

<head>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>





<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.min.css">
</head>
<body>
    <header class="header">
        <div class="header__menu">
        <div class="container">
            <img src="icons/Logo.svg" alt="логотип" class="col-md-1 mt-2 header__logo">
            <button class="offset-md-7 col-md-2 button" onclick="window.location.href='#reg'">
                Регистрация
            </button>
            <button class="col-md-2 button" onclick="window.location.href='#authing'">
                Вход
            </button>
        </div>
    </div>
    </header>
    <section class="promo">
        <div class="container">
            <div class="promo__wrapper">
                <div class="promo__title">Улучши свои навыки<br> 
                    программирования!</div>
                <div class="promo__subtitle">
                    Решай<br> 
                    с тысячами людьми<br>
                    со всего мира <br>
                    задачи разного <br>
                    уровня сложности
                </div>
                <button class="button button_big">
                    Начать решать
                </button>
            </div>
        </div>
    </section>
    <section class="advantages">
        <div class="container">
            <h2 class="title">Почему выбирают нас?</h2>
        <div class="row">
            <div class="col-md-4 advantages__item">
                <img src="icons/advantages/1.svg" alt="Качество" class="advantages__img">
                    <div class="advantages__subtitle">Качество</div>
                    <div class="advantages__text">
                        Автоматическая и ручная<br> 
                        проверка ответов на тесты от<br>
                        наших участников. Все тесты<br> 
                        проверяются модерацией на<br> 
                        предмет неточностей и ошибок
                    </div>
            </div>
            <div class="col-md-4 advantages__item">
                <img src="icons/advantages/2.svg" alt="Простота" class="advantages__img" style="width: 70%;">
                    <div class="advantages__subtitle">Простота</div>
                    <div class="advantages__text">
                        Решать тесты легко - читаешь<br> 
                        задание, делаешь код и<br> 
                        отправляешь на тест. Наш сайт<br> 
                        сразу же отобразить<br> 
                        работоспособность кода
                    </div>
            </div>
            <div class="col-md-4 advantages__item">
                <img src="icons/advantages/3.svg" alt="Удобство" class="advantages__img">
                    <div class="advantages__subtitle">Удобство</div>
                    <div class="advantages__text">
                        Можете решать тесты везде -<br> 
                        дома, в дороге, на учебе.
                    </div>

            </div>
        </div>
        </div>
    </section>
    <section style="min-height: 535px;">

    </section>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <a class="col-md-1 footer__text">Главная</a>
            <a class="col-md-1 footer__text">Тесты</a>
            <a class="col-md-1 footer__text">Теория</a>
            <a class="offset-7 col-md-2 footer__text">Made by Свет</a>
            </div>
        </div>
    </footer>

    <?php
//Registration
    if($_SESSION['user'] == null) {
        if ($_POST['reg'] == 'Зарегистрироваться') {
            //echo 'aa';
            $username = $_POST['username'];
            $email = $_POST['email'];
            $country = "russia";
            $password = $_POST['password'];
            $password_check = $_POST['password_check'];


            //$query = "INSERT INTO `users` (`username`,`password`,`country`,`status`,`exp`) VALUES ('$username','$password','$country',0,0)";

            //password
            if ($password == $password_check) {
                $pass = password_hash($password, PASSWORD_BCRYPT);
                $query = "INSERT INTO `users` (`username`,`email`,`password`,`country`,`status`,`exp`) VALUES ('$username','$email','$pass','$country',0,0)";
                $result = mysqli_query($connect, $query);
                $stat = "a";
                $msg = "Регистрация прошла успешно!";
            }
            //$result = mysqli_query($connect,$query);
            //echo $query;
            //aa
        }


//registration form
?>
    <section id='reg' class="register">
        <div class="container">
            <h2 class="title title_forms">Регистрация</h2>
            <form action="index.php" method="post" id="reg" class="forms">
                <input type="text" name="username" placeholder="Ник">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" id="pass" placeholder="Пароль">
                <input type="password" name="password_check" id="pass_2" placeholder="Повторите пароль">
                <input type="submit" name="reg" value="Зарегистрироваться" id="reg_btn"  class="button button_big">
                <span id="msgbox"><?php echo $msg; ?></span>
            </form>
            <a href="#authing" style="margin-top: 20px; text-align: center;">Войти</a>
            <a href="#" style="margin-top: 5px; text-align: center;">Закрыть</a>
        </div>
    </section>
    <?php

}?>

    <?php
//Auth
    if($_SESSION['user'] == null) {
        if ($_POST['auth'] == "Войти" && $state == null) {
            if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
                $secret = '6Lfg5JofAAAAAAhpJt0-fVIoYZEVOLTBrMbHeWJt';
                $ip = $_SERVER['REMOTE_ADDR'];
                $response = $_POST['g-recaptcha-response'];
                $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
                $arr = json_decode($rsp, TRUE);
                if ($arr['success']) {

                        $username = $_POST['username'];
                        $password_check = $_POST['password'];
                        $query = "SELECT * FROM `users` WHERE `username` = '$username'";
                        $result = mysqli_query($connect, $query);

                        $row = mysqli_fetch_row($result);

                        $user_db = $row[1];
                        $pass_db = $row[2];
                        $country = $row[3];
                        $status = $row[4];
                        $exp = $row[5];
                        $user_mail = $row[6];


                        $pass = password_verify($password_check, $pass_db);
                        $_SESSION['user'] = $user_db;
                        $_SESSION['email'] = $user_mail;
                        $_SESSION['country'] = $country;
                        $_SESSION['status'] = $status;
                        $_SESSION['exp'] = $exp;

                ?>
                    <meta http-equiv="refresh" content="5">
                        <?php
                    }
                }
            }


//Auth form
?>
    <section id='authing' class="auth">
        <div class="container">
            <h2 class="title title_forms">Авторизация</h2>
            <form action="index.php" method="post" id="auth" class="forms">
                <input type="text" name="username" placeholder="Email/Логин">
                <input type="password" name="password" placeholder="Пароль">
                <input type="submit" value="Войти" name="auth" class="button button_big">
                <a href="#" style="margin-top: 20px;">Закрыть</a>
                <div class="g-recaptcha" data-sitekey="6Lfg5JofAAAAANECO5ufRR2vDKcfMkJ31fOFuhbG" style="margin-bottom: 1em"></div>
            </form>
        </div>
    </section>

    
</body>
</html>
<?php
    }
        ?>