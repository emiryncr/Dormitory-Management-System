<?php
    session_start();

    if ($_SESSION["loggedin"] !== true) {
        header("Location: ../../authPages/login.php");
        exit();
    }
?>