<?php
session_start();
/**
 * DB config
 *
 */

$host = 'localhost';
$user = "";
$password = "";
$base = "hakaton";

$connect = mysqli_connect($host,$user,$password,$base);
if(mysqli_connect_error() == null){
    //echo "clean";
} else{
    echo "ошибка в работе сайта, обратитесь к администратору";
}

?>
