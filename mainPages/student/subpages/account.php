<div>
    <h1 class="text-white text-4xl text-center">Your Accounting Details</h1>
    
    <div class="m-5 p-4 bg-neutral-800/75 rounded-lg shadow-lg">

        <div class="mt-5 text-white grid">
            <?php
                include '../../database/database_connection.php';
                

                $userid = $_SESSION['userid'];

                $sql = "SELECT reservation.*, users.*
                FROM reservation
                INNER JOIN users ON reservation.studentid = users.userid
                WHERE reservation.studentid = $userid";
        
                $result = $connection->query($sql);

                if(isset($_POST['pay'])) {
                    $sql = "UPDATE reservation SET status = 'Paid' WHERE studentid = $userid";
                    $connection->query($sql);
                    //tips: refreshes the page
                    echo "<meta http-equiv='refresh' content='0'>";
                }

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {

                        $roomDetails = 'SELECT * FROM rooms WHERE roomid = ' . $row["roomid"];
                        $roomResult = $connection->query($roomDetails);
                        $roomRow = $roomResult->fetch_assoc();

                        $dormDetails = 'SELECT dormname FROM dormitory WHERE dormid = ' . $roomRow["assigndorm"];
                        $dormResult = $connection->query($dormDetails);
                        $dormRow = $dormResult->fetch_assoc();

                        echo '<div class="content bg-neutral-700/75 text-white p-4 rounded-lg shadow-md sm:w-96 w-66 mx-auto">';
                                echo '<h3 class="text-2xl font-bold mb-2">Reservation Details</h3>';
                                echo '<hr class="my-1 border-neutral-600 border-2">';
                                echo '<p class="font-bold">Username: ' . htmlspecialchars($row["username"]) . '</p>';
                                echo '<hr class="my-1 border-neutral-600">';
                                echo '<p class="">Reservation ID: ' . htmlspecialchars($row["reservationid"]) . '</p>';
                                echo '<hr class="my-1 border-neutral-600">';
                                echo '<p class="">Student ID: ' . htmlspecialchars($row["studentid"]) . '</p>';
                                echo '<hr class="my-1 border-neutral-600">';
                                echo '<p class="">Room ID: ' . htmlspecialchars($row["roomid"]) . '</p>';
                                echo '<hr class="my-1 border-neutral-600">';
                                echo '<p class="">Dorm Name: ' . htmlspecialchars($dormRow["dormname"]) . '</p>';
                                echo '<hr class="my-1 border-neutral-600">';
                                echo '<p class="">Room Type: ' . htmlspecialchars($roomRow["roomtype"]) . '</p>';
                                echo '<hr class="my-1 border-neutral-600">';
                                echo '<p class="">Room Price: $' . htmlspecialchars($roomRow["price"]) . '</p>';
                                echo '<hr class="my-1 border-neutral-600">';
                                echo '<p class="">Reservation Date: ' . htmlspecialchars($row["reservationdate"]) . '</p>';
                                echo '<hr class="my-1 border-neutral-600">';
                                echo '<form action="student.php?page=account" method="post">';
                                    echo '<div class="mt-4 flex justify-around gap-1">';
                                        echo '<a href="../../database/delete/deleteReservationStd.php?id=' . urlencode($row["reservationid"]) . '" class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded">Cancel Reservation</a>';
                                        echo '<button type="submit" name="pay" class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded">' . ($row['status'] == 'Pending' ? 'Pay Now' : 'Paid') . '</button>';
                                    echo '</div>';
                                echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo "You have not reserved any room.";
                }

                $connection->close();
            ?>
        </div>
    </div>

</div>