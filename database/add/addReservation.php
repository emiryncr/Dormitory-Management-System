<?php 
    include '../../database/database_connection.php';
    include '../../database/session_check.php';

    $userid = $_SESSION['userid'];

    $roomid = $_GET['roomid'];

    $sql = "INSERT INTO reservation (studentid, roomid, status) VALUES ($userid, $roomid, 'Pending')";

    if (mysqli_query($connection, $sql)) {
        header("Location: ../../mainPages/student/student.php?page=booking");
    } else {
        echo "<script>alert('Failed to reserve room!')</script>";
    }

?>