<?php
    include '../../../database/database_connection.php';
    include '../../../database/session_check.php';

    $userid = $_SESSION['userid'];

    $dormid = $_GET['dormid'];

        $sql = "SELECT * FROM rooms WHERE rooms.assigndorm = $dormid
    ";
    $result = $connection->query($sql);


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="content bg-neutral-700/75 text-white p-4 rounded-lg shadow-md">';
            echo '<img src="' . htmlspecialchars($row["photo"]) . '" alt="Room Image" class="w-full h-40 object-cover rounded-lg mb-4">';
            echo '<h2 class="text-lg font-bold mb-2">' . htmlspecialchars($row["roomname"]) . '</h2>';
            echo '<hr class="my-1 border-neutral-600 border-2">';
            echo '<p class="text-md">Room ID: ' . htmlspecialchars($row["roomid"]) . '</p>';
            echo '<hr class="my-1 border-neutral-600">';
            echo '<p class="text-md">Room Type: ' . htmlspecialchars($row["roomtype"]) . '</p>';
            echo '<hr class="my-1 border-neutral-600">';
            echo '<p class="text-md">Assigned Dorm: ' . htmlspecialchars($row["assigndorm"]) . '</p>';
            echo '<hr class="my-1 border-neutral-600">';
            echo '<p class="text-md">Capacity: ' . htmlspecialchars($row["capacity"]) . '</p>';
            echo '<hr class="my-1 border-neutral-600">';
            echo '<p class="text-md">Available Capacity: ' . htmlspecialchars($row["available_capacity"]) . '</p>';
            echo '<hr class="my-1 border-neutral-600">';
            echo '<p class="text-md mb-5">Price: $' . htmlspecialchars($row["price"]) . '</p>';
            if ($row["available_capacity"] > 0) {

                $sqlRes = "SELECT * FROM reservation WHERE studentid =  $userid"; 
                $resultRes = $connection->query($sqlRes);

                if ($resultRes->num_rows > 0) {
                    echo '<p class="text-md text-green-500 font-bold">You have already reserved room.</p>';
                } else {
                    echo '<a href="../../database/add/addReservation.php?roomid=' . htmlspecialchars($row["roomid"]) . '" class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded">Reserve</a>';
                }
            } else {
                echo '<p class="font-bold text-red-500">Room is full.</p>';
            }
            echo '</div>';
        }
    } else {
        echo "No rooms.";
    }

    $connection->close();
?>