<?php
    include '../../database/database_connection.php';
    include '../../database/session_check.php';

    if (isset($_GET['id'])) {
        $reservationid = $_GET['id'];

        $sql = "DELETE FROM reservation WHERE reservationid = $reservationid";
        mysqli_query($connection, $sql);

        header('Location: ../../mainPages/manager/manager.php?page=manage-financials');
        
    }

?>