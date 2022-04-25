<?php
session_start();
/**
 *
 *
 */

$host = 'localhost';
$user = "endienasg";
$password = "Quantum228";
$base = "hakaton";

$connect = mysqli_connect($host,$user,$password,$base);
if(mysqli_connect_error() == null){
    echo "clean";
}

?>
