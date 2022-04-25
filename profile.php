<?php
require_once("core/databases/dbconfig.php");
if($_SESSION['user'] != null){


?>

<?php
    //exit
    if($_POST['exit'] == "Выйти из аккаунта"){
        session_unset();    }


?>


<?php
   echo     $_SESSION['user'];
   echo     $_SESSION['email'] ;
   echo     $_SESSION['country'];
   echo     $_SESSION['status'];
   echo     $_SESSION['exp'];
?>
<form method="post" action="profile.php">
    <input type="submit" value="Выйти из аккаунта" name="exit">
</form>
<?php
}
else{
    header("Location:index.php");
}
?>
