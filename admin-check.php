<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'employee') {
    header("Location: admin.php");
    exit();
}

?>