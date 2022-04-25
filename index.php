<?php
require_once ("core/databases/dbconfig.php");
?>

<head>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.min.css">
</head>
<body>
    <?php
    require_once ('header.php');
    ?>
    <?php
    require_once("content/main/main_page.html");
    ?>
    <?php
    require_once ("footer.php");
    ?>

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
<?php
    }
        ?>
    
</body>
</html>
