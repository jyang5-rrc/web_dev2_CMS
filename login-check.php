<?php

session_start();

//var_dump($_SESSION['user_name']);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");

    exit();
}

?>