<div>
    <h1 class="text-white text-4xl text-center">Manage Financials</h1>
    
    <div class="m-5 p-4 bg-neutral-800/75 rounded-lg shadow-lg">

        <div class="mt-5 text-white grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php
                include '../../database/database_connection.php';

                
                $userid = $_SESSION['userid'];

                $dormSql = "SELECT dormid FROM users WHERE userid = $userid";
                $dormResult = $connection->query($dormSql);
                $dormRow = $dormResult->fetch_assoc();
                $dormid = $dormRow["dormid"];

                $sql = "SELECT reservation.*, users.*, rooms.assigndorm, dormitory.dormname
                FROM reservation
                LEFT JOIN users ON reservation.studentid = users.userid
                LEFT JOIN rooms ON rooms.assigndorm = $dormid 
                LEFT JOIN dormitory ON rooms.assigndorm = dormitory.dormid
                WHERE rooms.roomid = reservation.roomid
                ";
                $result = $connection->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="content bg-neutral-700/75 text-white p-4 rounded-lg shadow-md">';
                            echo '<p class=" font-bold">Username: ' . htmlspecialchars($row["username"]) . '</p>';
                            echo '<hr class="my-1 border-neutral-600 border-2">';
                            echo '<p class="">Reservation ID: ' . htmlspecialchars($row["reservationid"]) . '</p>';
                            echo '<hr class="my-1 border-neutral-600">';
                            echo '<p class="">Student ID: ' . htmlspecialchars($row["studentid"]) . '</p>';
                            echo '<hr class="my-1 border-neutral-600">';
                            echo '<p class="">Room ID: ' . htmlspecialchars($row["roomid"]) . '</p>';
                            echo '<hr class="my-1 border-neutral-600">';
                            echo '<p class="">Dorm Name: ' . htmlspecialchars($row["dormname"]) . '</p>';
                            echo '<hr class="my-1 border-neutral-600">';
                            echo '<p class="">Reservation Date: ' . htmlspecialchars($row["reservationdate"]) . '</p>';
                            echo '<hr class="my-1 border-neutral-600">';
                            echo '<p class="">Status: ' . htmlspecialchars($row["status"]) . '</p>';
                            echo '<div class="mt-4 flex justify-around">';
                            echo '<a href="../../database/delete/deleteReservation.php?id=' . urlencode($row["reservationid"]) . '" class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded">Cancel Reservation</a>';
                            echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "0 reservations";
                }

                $connection->close();
            ?>
        </div>
    </div>

</div>