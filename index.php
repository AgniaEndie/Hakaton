<?php
require_once ("core/databases/dbconfig.php");

if($_POST['reg'] == 'Зарегистрироваться'){
    //echo 'aa';
    $username = $_POST['username'];
    $email = $_POST['email'];
    $country = "russia";
    $password = $_POST['password'];
    $password_check = $_POST['password_check'];



    //$query = "INSERT INTO `users` (`username`,`password`,`country`,`status`,`exp`) VALUES ('$username','$password','$country',0,0)";

    //password
    if($password == $password_check){
        $pass = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO `users` (`username`,`email`,`password`,`country`,`status`,`exp`) VALUES ('$username','$email','$pass','$country',0,0)";
        $result = mysqli_query($connect,$query);
        $msg = "Регистрация прошла успешно!";
    }
    //$result = mysqli_query($connect,$query);
    //echo $query;
}



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



?>

<form action="index.php" method="post" id="auth">
    <input type="text" name="username">
    <input type="password" name="password">
    <input type="submit" value="Войти">
</form>