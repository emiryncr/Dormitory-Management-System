<?php
    include '../database_connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $username = $_POST['username'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $role = "student"; 

        $password = password_hash($password, PASSWORD_DEFAULT);

        $checkUserUniques = "SELECT * FROM users WHERE username = '$username' OR email = '$email' OR phone = '$phone'";

        if(mysqli_query($connection, $checkUserUniques)->num_rows > 0){
            echo "<script>alert('Username, email or phone number already exists!')</script>";
            echo "<script>window.location.href='../../authPages/signup.php'</script>";
            exit();
        }else{
            $query = "INSERT INTO users (username, name, surname, email, phone, role, password) VALUES ('$username', '$name', '$surname', '$email', '$phone' , '$role', '$password')";

            if(mysqli_query($connection, $query)){
                echo "<script>alert('Student added successfully, you are being redirected to the login page!')</script>";
                echo "<script>window.location.href='../../authPages/login.php'</script>";
            } else {
                echo "<script>alert('Failed to signup, try again!')</script>";
                echo "<script>window.location.href='../../authPages/signup.php'</script>";
            }
            
        }

    }
    
?> 