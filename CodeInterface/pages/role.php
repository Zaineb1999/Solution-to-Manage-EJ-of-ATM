<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('location:login.php');
    exit();
} else {
    if ($_SESSION['user'][3] != "ADMIN") {
        header('location:seDeconnecter.php');
        exit();
    }
}

?>
