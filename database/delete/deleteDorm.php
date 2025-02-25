<?php
    include '../../database/database_connection.php';
    include '../../database/session_check.php';

    if (isset($_GET['id'])) {
        $dormid = $_GET['id'];

        $sqlCheckManager = "
            SELECT * FROM users
            WHERE role = 'Manager' AND dormid = $dormid
        ";

        $sqlCheckRoom = "
            SELECT * FROM rooms
            WHERE assigndorm = $dormid
        ";

        if (mysqli_query($connection, $sqlCheckManager)->num_rows > 0) {
            $sqlDeleteManager = "
                DELETE FROM users
                WHERE role = 'Manager' AND dormid = $dormid
            ";

            mysqli_query($connection, $sqlDeleteManager);
        }

        //tips: i prefer to use store datas in array than make them string
        //so finally i can delete all rows if exist roomid in reservation table
        $resultRooms = mysqli_query($connection, $sqlCheckRoom);
        if ($resultRooms->num_rows > 0) {
            $roomIds = [];
            while ($row = $resultRooms->fetch_assoc()) {
                $roomIds[] = $row['roomid'];
            }
            
            $roomIdsList = implode(',', $roomIds);
            $sqlDeleteReservation = "
                DELETE FROM reservation
                WHERE roomid IN ($roomIdsList)
            ";
        
            mysqli_query($connection, $sqlDeleteReservation);
        }

        if (mysqli_query($connection, $sqlCheckRoom)->num_rows > 0) {
            $sqlDeleteRoom = "
                DELETE FROM rooms
                WHERE assigndorm = $dormid
            ";

            mysqli_query($connection, $sqlDeleteRoom);
        }

        $sql = "DELETE FROM dormitory WHERE dormid = $dormid";
        mysqli_query($connection, $sql);

        header('Location: ../../mainPages/admin/admin.php?page=manage-dormitory');

    }
    
?>