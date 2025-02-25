<div>
    <h1 class="text-white text-4xl text-center">Manage Students</h1>
    
    <div class="m-5 p-4 bg-neutral-800/75 rounded-lg shadow-lg">

        <div class="flex justify-center sm:flex-row flex-col gap-2">
            <div class="relative">
                <!-- <input type="text" class="input bg-gray-200 text-gray-800 pl-4 pr-10 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 w-full" placeholder="Search Student"/>
                <button class="absolute right-0 top-0 mt-2 mr-3 text-gray-600 hover:text-gray-800 transition duration-300">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button> -->
            </div>
        </div>

        <div>
            <p class="mt-2 text-red-500">If you delete student which already reserved a room, reservation will be deleted</p>
        </div>

        <div class="mt-5 text-white grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php
                    include '../../database/database_connection.php';

                    $sql = "
                    SELECT users.*, reservation.*, rooms.*, dormitory.*
                    FROM users 
                    LEFT JOIN reservation 
                    ON users.userid = reservation.studentid 
                    LEFT JOIN rooms
                    ON reservation.roomid = rooms.roomid
                    LEFT JOIN dormitory
                    ON rooms.assigndorm = dormitory.dormid
                    WHERE users.role = 'Student'
                ";

                    $result = $connection->query($sql);

                    $notResMsg = "No room reserved";
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="content bg-neutral-700/75 text-white p-4 rounded-lg shadow-md">';
                            echo '<h2 class="text-lg font-bold mb-2">' . htmlspecialchars($row["username"]) . '</h2>';
                            echo '<hr class="my-1 border-neutral-600 border-2">';
                            echo '<p class="text-md">Full Name: ' . htmlspecialchars($row["name"]) . ' ' . htmlspecialchars($row["surname"]) . '</p>';
                            echo '<hr class="my-1 border-neutral-600">';
                            echo '<p class="text-md">Email: ' . htmlspecialchars($row["email"]) . '</p>';
                            echo '<hr class="my-1 border-neutral-600">';
                            echo '<p class="text-md">Phone: ' . htmlspecialchars($row["phone"]) . '</p>';
                            echo '<hr class="my-1 border-neutral-600">';
                            echo '<p class="text-md">Dorm ID: ' . ($row["dormid"] ? htmlspecialchars($row["dormid"]) : $notResMsg) . '</p>';
                            echo '<hr class="my-1 border-neutral-600">';
                            echo '<p class="text-md">Dorm Name: ' . ($row["dormname"] ? htmlspecialchars($row["dormname"]) : $notResMsg) . '</p>';
                            echo '<div class="mt-4 flex justify-around">';
                            echo '<a href="../../database/update/updateStudent.php?id=' . urlencode($row["userid"]) . '" class="bg-orange-600 hover:bg-orange-500 text-white px-4 py-2 rounded">Update</a>';
                            echo '<a href="../../database/delete/deleteUser.php?id=' . urlencode($row["userid"]) . '" class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded">Delete</a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "0 students";
                    }

                    $connection->close();
                ?>
            </div>
    </div>

</div>