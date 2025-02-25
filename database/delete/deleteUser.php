<?php
    include '../../database/database_connection.php';
    include '../../database/session_check.php';


    if (isset($_GET['id'])) {
        $userid = $_GET['id'];

        $sqlCheckReservation = "
            SELECT * FROM reservation
            WHERE studentid = $userid
        ";

        if (mysqli_query($connection, $sqlCheckReservation)->num_rows > 0) {
            $sqlDeleteReservation = "
                DELETE FROM reservation
                WHERE studentid = $userid
            ";

            mysqli_query($connection, $sqlDeleteReservation);
        }

        $sql = "DELETE FROM users WHERE userid = $userid";
        mysqli_query($connection, $sql);

        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    
?>