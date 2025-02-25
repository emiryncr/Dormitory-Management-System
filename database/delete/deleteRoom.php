<?php 
    include '../../database/database_connection.php';
    include '../../database/session_check.php';


    if (isset($_GET['id'])) {
        $roomid = $_GET['id'];

        $sql = "DELETE FROM rooms WHERE roomid = $roomid";
        
        $checkReservation = "
            SELECT * FROM reservation
            WHERE roomid = $roomid
        ";

        if (mysqli_query($connection, $checkReservation)->num_rows > 0) {
            $sqlDeleteReservation = "
                DELETE FROM reservation
                WHERE roomid = $roomid
            ";

            mysqli_query($connection, $sqlDeleteReservation);
        }

        mysqli_query($connection, $sql);

        header('Location: ../../mainPages/manager/manager.php?page=manage-rooms');

    }
?>