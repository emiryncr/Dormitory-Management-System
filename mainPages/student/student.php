<?php
    include '../../database/database_connection.php';
    include '../../database/session_check.php';

    if ($_SESSION['role'] !== 'Student') {
         header("Location: ../../authPages/login.php");
         exit();
    }
    

    $username = $_SESSION['username'];

    $sql = "
        SELECT users.*, reservation.*, rooms.*, dormitory.*
        FROM users 
        LEFT JOIN reservation 
        ON users.userid = reservation.studentid 
        LEFT JOIN rooms
        ON reservation.roomid = rooms.roomid
        LEFT JOIN dormitory
        ON rooms.assigndorm = dormitory.dormid
        WHERE users.username = '$username'
    ";
    
    $result = mysqli_query($connection, $sql);  


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <link rel="icon" type="image/x-icon" href="../../img/lightLogo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=logout" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=menu" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }
    .montserrat {
        font-family: "Montserrat", sans-serif;
        font-optical-sizing: auto;
        font-weight: 500;
        font-style: normal;
    }
    .full-screen {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
        background-color: #1a1a1a;
    }
    main {
        flex: 1;
        padding: 2rem;
    }
</style>
<body class="bg-neutral-900">
    <div class="full-screen">
        <?php
            $links = [
                "Dashboard"=> "student.php",
                'Booking' => 'student.php?page=booking',
                'Accounting' => 'student.php?page=account',
            ];
            include '../components/navbar.php';
        ?>

        <main class="">
            <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'default';
                    switch($page) {
                        case 'booking':
                            include './subpages/booking.php';
                            break;
                        case 'account':
                            include './subpages/account.php';
                            break;
                        default:
                            echo '<h1 class="text-white text-4xl text-center">Welcome to the student dashboard!</h1>';
                            
                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                echo <<<HTML
                                    <div class="min-h-[500px] flex items-center justify-center">
                                        <div class="bg-gray-800 rounded-lg shadow-lg p-6 max-w-sm text-left">
                                            <p class="text-white text-xl font-semibold mb-2">Hello, {$row['username']}!</p>
                                            <p class="text-gray-300 text-lg">Your name is: <span class="font-bold text-white">{$row['name']}</span></p>
                                            <p class="text-gray-300 text-lg">Your surname is: <span class="font-bold text-white">{$row['surname']}</span></p>
                                            <p class="text-gray-300 text-lg">Your student ID is: <span class="font-bold text-white">{$row['userid']}</span></p>
                                            <p class="text-gray-300 text-lg">Your email is: <span class="font-bold text-white">{$row['email']}</span></p>
                                            <p class="text-gray-300 text-lg">Your phone is: <span class="font-bold text-white">{$row['phone']}</span></p>
                                            <p class="text-gray-300 text-lg">Your reserved room's ID is: <span class="font-bold text-white">{$row['roomid'] }</span></p>
                                            <p class="text-gray-300 text-lg">Your reserved dorm's ID is: <span class="font-bold text-white">{$row['assigndorm']}</span></p>
                                            <p class="text-gray-300 text-lg">Your reserved dorm name is: <span class="font-bold text-white">{$row['dormname']}</span></p>
                                        </div>
                                    </div>
                                HTML;
                            } else {
                                echo '<script>window.location.href="../../authPages/login.php";</script>';
                            }

                            break;
                    }
                    ?>
        </main>
    </div>

    <?php include '../components/footer.php'; ?>


    <script>
        //tips: aria-controls is in nav.php to toggle the dropdown menu
        document.querySelector('[data-collapse-toggle]').addEventListener('click', function() {
            var target = document.getElementById(this.getAttribute('aria-controls'));
            if (target.classList.contains('hidden')) {
                target.classList.remove('hidden');
            } else {
                target.classList.add('hidden');
            }
        });

        document.querySelectorAll('.browse-rooms-btn').forEach(button => {
        button.addEventListener('click', function() {
            const dormid = this.getAttribute('data-dormid');
            document.getElementById('roomsContent').innerHTML = '';
            fetchRooms(dormid);
            document.getElementById('roomsModal').classList.remove('hidden');
        });
    });

        document.getElementById('closeModalBtn').addEventListener('click', function() {
            document.getElementById('roomsModal').classList.add('hidden');
        });
            // To fetch php content, I GOT HELP from AI
            function fetchRooms(dormid) {
            fetch(`subpages/browse-rooms.php?dormid=${dormid}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('roomsContent').innerHTML = data;
                });
        }
    </script>
</body>
</html>