<?php
require_once ("core/databases/dbconfig.php");
?>

<head>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>

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
    <form action="index.php" method="post" id="reg">
        <input type="text" name="username">
        <input type="email" name="email">
        <input type="password" name="password" id="pass">
        <input type="password" name="password_check" id="pass_2">
        <input type="submit" name="reg" value="Зарегистрироваться" id="reg_btn" >
        <span id="msgbox"><?php echo $msg; ?></span>
    </form>
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

<form action="index.php" method="post" id="auth">
    <input type="text" name="username">
    <input type="password" name="password">
    <input type="submit" value="Войти" name="auth">
    <div class="g-recaptcha" data-sitekey="6Lfg5JofAAAAANECO5ufRR2vDKcfMkJ31fOFuhbG" style="margin-bottom: 1em"></div>
</form>
<?php
    }
        ?>