<div class="">
    <h1 class="text-white text-4xl text-center">Manage Rooms</h1>
    
    <div class="m-5 p-4 bg-neutral-800/75 rounded-lg shadow-lg">
        
        <div class="flex justify-center sm:flex-row flex-col gap-2">
            <button id="addBtn" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300 min-w-max">Add Room</button>
            <div class="relative">
                <!-- <input type="text" class="input bg-gray-200 text-gray-800 pl-4 pr-10 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 w-full" placeholder="Search Rooms"/>
                <button class="absolute right-0 top-0 mt-2 mr-3 text-gray-600 hover:text-gray-800 transition duration-300">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button> -->
            </div>
        </div>

        <div class="mt-5 text-white grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php
                include '../../database/database_connection.php';

                $userid = $_SESSION['userid'];
                $mngDormId = $_SESSION['dormid'];


                $sql = "
                    SELECT rooms.*, dormitory.dormname
                    FROM rooms
                    LEFT JOIN dormitory
                    ON rooms.assigndorm = dormitory.dormid
                    WHERE dormitory.dormid = $mngDormId
                ";
                
                $result = $connection->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="content bg-neutral-700/75 text-white p-4 rounded-lg shadow-md">';
                            echo '<img src="' . htmlspecialchars($row["photo"]) . '" alt="Room Image" class="w-full h-40 object-cover rounded-lg mb-4">';
                            echo '<h2 class="text-xl font-bold mb-2">' . htmlspecialchars($row["roomname"]) . '</h2>';
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
                            echo '<p class="text-md">Price: $' . htmlspecialchars($row["price"]) . '</p>';
                            echo '<div class="mt-4 flex justify-around">';
                            echo '<a href="../../database/update/updateRoom.php?id=' . urlencode($row["roomid"]) . '" class="bg-orange-600 hover:bg-orange-500 text-white px-4 py-2 rounded">Update</a>';
                            echo '<a href="../../database/delete/deleteRoom.php?id=' . urlencode($row["roomid"]) . '" class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded">Delete</a>';
                            echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "0 rooms";
                }

                $connection->close();
            ?>
        </div>
    </div>

 <div id="addModal" class="hidden fixed z-10 inset-0 overflow-y-auto backdrop-blur-md">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-neutral-300 rounded-lg sm:p-6 p-4 shadow-lg sm:min-w-96 max-w-64 mt-20">
            <div class="flex justify-between items-center border-b pb-2">
                <h2 class="sm:text-xl text-md font-semibold">Add Room Pop-Up</h2>
                <button id="closeModalBtn" class="text-red-700 hover:text-red-500 text-2xl font-bold">&times;</button>
            </div>
            <form action="../../database/add/addRoom.php" method="POST" enctype="multipart/form-data">
                <div class="sm:mt-4 mt-2">
                    <label for="roomName" class="block text-sm font-medium text-gray-700">Room Name</label>
                    <input type="text" id="roomName" name="roomName" class="mt-1 sm:p-2 p-1 border rounded w-full" required>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="roomType" class="block text-sm font-medium text-gray-700">Type of room</label>
                    <select id="roomType" name="roomType" class="mt-1 sm:p-2 p-1 border rounded w-full" required>
                        <option value="" disabled selected>Select a room type</option>
                        <option value="single">Single Room</option>
                        <option value="double">Double Room</option>
                        <option value="triple">Triple Room</option>
                        <option value="quad">Quad Room</option>
                        <option value="dormitory">Dormitory Room</option>
                    </select>
                </div>
                <!-- capacity will depend roomType (capacity.js handles)-->
                <div class="sm:mt-4 mt-2">
                    <label for="roomCapacity" class="block text-sm font-medium text-gray-700">Capacity</label>
                    <input type="number" id="roomCapacity" name="roomCapacity" class="mt-1 sm:p-2 p-1 border rounded w-full" required>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="roomPrice" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" id="roomPrice" name="roomPrice" class="mt-1 sm:p-2 p-1 border rounded w-full" required placeholder="$">
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="assignDorm" class="block text-sm font-medium text-gray-700">Connect to dorm</label>
                    <select name="assignDorm" id="assignDorm" class="mt-1 sm:p-2 p-1 border rounded w-full" required>
                        <?php
                            include '../../database/database_connection.php';
                            $sql = "SELECT dormid, dormname FROM dormitory WHERE dormid = $mngDormId";
                            $result = $connection->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo '<option value="' . htmlspecialchars($row["dormid"]) . '">' . htmlspecialchars($row["dormname"]) . '</option>';
                                }
                            } else {
                                echo "<options value='' disabled selected>No dormitories</option>";
                            }
                            $connection->close();
                        ?>
                    </select>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="roomPhoto" class="block text-sm font-medium text-gray-700">Photo</label>
                    <input type="file" id="roomPhoto" name="roomPhoto" class="mt-1 sm:p-2 p-1 border rounded w-full bg-white text-gray-700" accept=".jpg, .jpeg, .png">
                </div>
                <div class="sm:mt-4 mt-2">
                    <button type="submit" class="bg-orange-700 text-white sm:px-4 sm:py-2 px-2 py-1 rounded hover:bg-orange-500 transition duration-300">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>



</div>
