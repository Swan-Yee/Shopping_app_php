<?php 
session_start();

unset($_SESSION['card']);

header("location: index.php");
?>