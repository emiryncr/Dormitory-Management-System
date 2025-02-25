<?php
    include "../database/database_connection.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password= password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Username already exists!')</script>";
        } else {
            $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'Admin')";
            if (mysqli_query($connection, $sql)) {
                echo "<script>alert('Sign-up successful!')</script>";
                header("Location: login.php");
            } else {
                echo "<script>alert('Sign-up failed!')</script>";
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up Admin</title>
    <link rel="icon" type="image/x-icon" href="../img/lightLogo.png">
    <link rel="stylesheet" href="../style/auth.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="h-screen bg-[url('../img/grayBuildings.jpg')] backdrop-blur">
    <div class="w-full max-w-4xl mx-auto flex items-center justify-center h-full sm:flex-row flex-col">
    <h1 class="lobster-regular">To be part of us as an Admin!</h1>
    <form action="adminsign.php" method="post" class="bg-transparent shadow-lg rounded-[50px] px-10 bg-white/20 w-10/12 sm:w-full">
            <div class="form-header">
                <img class="sm:max-w-64 max-w-40 mx-auto" src="../img/logo.png" alt="">
                <h1 class="text-xl mb-3 text-center">Sign-up to start journey!</h1>
            </div>
            <div class="max-w-sm mx-auto">
                <input class="shadow appearance-none border-b-2 border-r-2 rounded-full w-full py-3 px-4 text-zinc-950 mb-3 leading-tight focus:outline-none focus:shadow-outline bg-white/30 placeholder:text-zinc-700 text-lg" name="username" type="text" placeholder="Username" minlength="3" maxlength="50" required>
                <input class="shadow appearance-none border-b-2 border-r-2 rounded-full w-full py-3 px-4 text-zinc-950 mb-3 leading-tight focus:outline-none focus:shadow-outline bg-white/30 placeholder:text-zinc-700 text-lg" name="password" type="password" placeholder="Password" minlength="5" required>
                <input class="shadow appearance-none border-b-2 border-r-2 rounded-full w-full py-3 px-4 text-zinc-950 mb-3 leading-tight focus:outline-none focus:shadow-outline bg-white/30 placeholder:text-zinc-700 text-lg" name="confirm" type="password" placeholder="Confirm Password" required>
            </div>
            
            <div class="flex flex-col">
                <div class="flex mb-3 gap-1">
                    <button type="submit" class="w-3/4 bg-green-800 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">Sign-Up</button>
                    <button type="reset" class="w-1/4 bg-red-800 hover:bg-red-700 text-white font-bold pt-2 pb-1 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                        <span class="material-symbols-outlined">
                            delete
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const password = document.querySelector('input[name="password"]');
        const confirm = document.querySelector('input[name="confirm"]');
        const submit = document.querySelector('button[type="submit"]');

        confirm.addEventListener('input', () => {
            if (password.value !== confirm.value) {
                confirm.setCustomValidity('Passwords do not match');
            } else {
                confirm.setCustomValidity('');
            }
        });

        submit.addEventListener('click', () => {
            if (password.value !== confirm.value) {
                confirm.setCustomValidity('Passwords do not match');
            } else {
                confirm.setCustomValidity('');
            }
        });
    </script>

</body>
</html>