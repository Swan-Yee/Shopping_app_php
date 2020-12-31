<?php
session_start();
require 'config/config.php';

if($_POST){
    $id=$_POST['id'];
    $qty=$_POST['qty'];

    $stmt=$pdo->prepare("SELECT * FROM products WHERE id=".$id);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);

    if($qty > $result['quantity']){
        echo "<script>alert('not enough stock');window.location.href='product_detail.php?id=$id'</script>";
        die();
    }
    else{
        if(isset($_SESSION['card'][$id])){
            $_SESSION['card']['id'.$id] = $qty;
        }
        else{
            $_SESSION['card']['id'.$id] +=$qty;
        }
    }

    header("location: card.php?id=".$id);
}
?>