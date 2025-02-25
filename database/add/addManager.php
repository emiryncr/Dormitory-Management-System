<?php
    include '../database_connection.php';
    include '../session_check.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $username = $_POST['mngUsername'];
        $name = $_POST['mngName'];
        $surname = $_POST['mngSurname'];
        $email = $_POST['mngEmail'];
        $phone = $_POST['mngPhone'];
        $dormid = $_POST['mngDorm'];
        $password = $_POST['mngPassword'];
        $role = "manager"; 

        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, name, surname, email, phone, role, dormid, password) VALUES ('$username', '$name', '$surname', '$email', '$phone', '$role', '$dormid', '$password')";

        if(mysqli_query($connection, $query)){
            echo "<script>alert('Manager added successfully!')</script>";
           echo "<script>window.location.href='../../mainPages/admin/admin.php?page=manage-managers'</script>";
        } else {
            echo "<script>alert('Failed to add manager!')</script>";
            echo "<script>window.location.href='../../mainPages/admin/admin.php?page=manage-managers'</script>";
        }

    }


?>