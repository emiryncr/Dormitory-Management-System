<?php
    include '../database_connection.php';
    include '../session_check.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $dormName = $_POST['dormName'];
        $dormPhone = $_POST['dormPhone'];
        $dormLocation = $_POST['dormLocation'];
        $dormRooms = $_POST['dormRooms'];
        if(empty($dormRooms)){
            echo "<script>alert('Please select at least one room type!')</script>";
            echo "<script>window.location.href='../mainPages/admin/admin.php?page=manage-dormitory'</script>";
        }
        //tips: converts array to string
        $dormRoomsStr = implode(',', $dormRooms);

        if ($_FILES["dormPhoto"]["error"] == 0){
            $image_path = "../../img/dorms/". basename($_FILES["dormPhoto"]["name"]);
            move_uploaded_file($_FILES["dormPhoto"]["tmp_name"], $image_path);
        }


        $query = "INSERT INTO dormitory (dormname, dormphone, location, typeofrooms, photo) VALUES ('$dormName', '$dormPhone', '$dormLocation', '$dormRoomsStr', '$image_path')";

        if(mysqli_query($connection, $query)){
            echo "<script>alert('Dormitory added successfully!')</script>";
            echo "<script>window.location.href='../../mainPages/admin/admin.php?page=manage-dormitory'</script>";
        } else {
            echo "<script>alert('Failed to add dormitory, try again!')</script>";
            echo "<script>window.location.href='../../mainPages/admin/admin.php?page=manage-dormitory'</script>";
        }

    }
    

?> 