<?php
    include '../database_connection.php';
    include '../session_check.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $roomname = $_POST['roomName'];
        $roomtype = $_POST['roomType'];
        $roomcapacity = $_POST['roomCapacity'];
        $avaibleCapacity = $_POST['roomCapacity'];
        $roomprice = $_POST['roomPrice'];
        $dormid = $_POST['assignDorm'];

        if ($_FILES["roomPhoto"]["error"] == 0){
            $image_path = "../../img/rooms/". basename($_FILES["roomPhoto"]["name"]);
            move_uploaded_file($_FILES["roomPhoto"]["tmp_name"], $image_path);
        }

        $query = "INSERT INTO rooms (assigndorm, roomname, price, roomtype, capacity, available_capacity, photo) VALUES ( '$dormid', '$roomname', '$roomprice', '$roomtype', '$roomcapacity', '$avaibleCapacity', '$image_path')";

        if(mysqli_query($connection, $query)){
            echo "<script>alert('Room added successfully!')</script>";
            echo "<script>window.location.href='../../mainPages/manager/manager.php?page=manage-rooms'</script>";
        } else {
            echo "<script>alert('Failed to add Room, try again!')</script>";
            echo "<script>window.location.href='../../mainPages/manager/manager.php?page=manage-rooms'</script>";
        }

    }
    
?> 