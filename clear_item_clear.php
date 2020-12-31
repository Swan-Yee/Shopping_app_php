<?php 
session_start();

unset($_SESSION['card']['id'.$_GET['id']]);

header("location: card.php");
?>