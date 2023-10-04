<?php

session_start();

if(isset($_SESSION['user_id'])){
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['role']);
    header("Location: index.php");
    exit();
} else {
    header("Location: index.php");
    exit();

}

?>


