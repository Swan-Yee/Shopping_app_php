<?php
session_start();
require '../config/config.php';
require '../config/common.php';

$stmt=$pdo->prepare("DELETE FROM users WHERE id=".$_GET['id']);
$result=$stmt->execute();

if($result){
    echo "<script>alert('Successlly Delete!');window.location.href='user.php';</script>";
}