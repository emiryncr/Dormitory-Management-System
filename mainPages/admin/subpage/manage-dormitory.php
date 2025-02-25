<div class="">
    <h1 class="text-white text-4xl text-center">Manage Dormitories</h1>
    
    <div class="m-5 p-4 bg-neutral-800/75 rounded-lg shadow-lg">
        
        <div class="flex justify-center sm:flex-row flex-col gap-2">
            <button id="addBtn" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300 min-w-max">Add Dormitory</button>
            <div class="relative">
                <!-- <input type="text" class="input bg-gray-200 text-gray-800 pl-4 pr-10 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 w-full" placeholder="Search Dormitory"/>
                <button class="absolute right-0 top-0 mt-2 mr-3 text-gray-600 hover:text-gray-800 transition duration-300">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button> -->
            </div>
        </div>

        <div>
            <p class="mt-2 text-red-500">If manager assigned to dorm which you delete, manger will be deleted</p>
            <p class="mt-2 text-red-500">If room assigned to dorm which you delete, room will be deleted</p>
        </div>

        <div class="mt-5 text-white grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php
                include '../../database/database_connection.php';

                $sql = "SELECT dormitory.*, users.username, users.userid
                        FROM dormitory
                        LEFT JOIN users 
                        ON dormitory.dormid = users.dormid 
                        AND users.role = 'Manager'";


                $result = $connection->query($sql);

                if ($result->num_rows > 0){
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="content bg-neutral-700/75 text-white p-4 rounded-lg shadow-md">';
                        echo '<img src="' . htmlspecialchars($row["photo"]) . '" alt="Dorm Photo" class="w-full h-40 object-cover rounded-lg mb-4">';
                        echo '<p class="text-lg font-bold mb-2">' . htmlspecialchars($row["dormname"]) . '</p>';
                        echo '<hr class="my-1 border-neutral-600 border-2">';
                        echo '<h2 class="">Dorm ID: ' . htmlspecialchars($row["dormid"]) . '</h2>';
                        echo '<hr class="my-1 border-neutral-600">';
                        echo '<p class="">Phone: ' . htmlspecialchars($row["dormphone"]) . '</p>';
                        echo '<hr class="my-1 border-neutral-600">';
                        echo '<p class="">Location: ' . htmlspecialchars($row["location"]) . '</p>';
                        echo '<hr class="my-1 border-neutral-600">';
                        echo '<p class="">Type of Rooms: ' . htmlspecialchars($row["typeofrooms"]) . '</p>';
                        echo '<hr class="my-1 border-neutral-600">';
                        if($row["username"] != null){
                            echo '<p class="">Manager Username: ' . htmlspecialchars($row["username"]) . '</p>';
                            echo '<hr class="my-1 border-neutral-600">';
                            echo '<p class="">Manager ID: ' . htmlspecialchars($row["userid"]) . '</p>';
                        }else{
                            echo '<p class="">No Manager Assigned</p>';
                        }
                        echo '<div class="mt-4 flex justify-around">';
                            echo '<a href="../../database/update/updateDorm.php?id=' . urlencode($row["dormid"]) . '" class="bg-orange-600 hover:bg-orange-500 text-white px-4 py-2 rounded">Update</a>';
                            echo '<a href="../../database/delete/deleteDorm.php?id=' . urlencode($row["dormid"]) . '" class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded">Delete</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                }else {
                    echo "0 dormitories";
            }
                
                $connection->close();
            ?>
        </div>
    </div>

 <div id="addModal" class="hidden fixed z-10 inset-0 overflow-y-auto backdrop-blur-md">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-neutral-300 rounded-lg sm:p-6 p-4 shadow-lg sm:min-w-96 max-w-64">
            <div class="flex justify-between items-center border-b pb-2">
                <h2 class="sm:text-xl  font-semibold">Add Dormitory Pop-Up</h2>
                <button id="closeModalBtn" class="text-red-700 hover:text-red-500 text-2xl font-bold">&times;</button>
            </div>
            <form action="../../database/add/addDorm.php" method="POST" enctype="multipart/form-data">
                <div class="sm:mt-4 mt-2">
                    <label for="dormName" class="block text-sm font-medium text-gray-700">Dormitory Name</label>
                    <input type="text" id="dormName" name="dormName" class="mt-1 sm:p-2 p-1 border rounded w-full" required>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="dormPhone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" id="dormPhone" name="dormPhone" class="mt-1 sm:p-2 p-1 border rounded w-full" required>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="dormLocation" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" id="dormLocation" name="dormLocation" class="mt-1 sm:p-2 p-1 border rounded w-full" required>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="dormRooms" class="block text-sm font-medium text-gray-700">Type of Rooms</label>
                    <div class="flex flex-wrap gap-4 mt-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="singleRoom" name="dormRooms[]" value="single" class="sm:p-2 p-1 border rounded">
                            <label for="singleRoom" class="ml-2 text-sm">Single Room</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="doubleRoom" name="dormRooms[]" value="double" class="sm:p-2 p-1 border rounded">
                            <label for="doubleRoom" class="ml-2 text-sm">Double Room</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="tripleRoom" name="dormRooms[]" value="triple" class="sm:p-2 p-1 border rounded">
                            <label for="tripleRoom" class="ml-2 text-sm">Triple Room</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="quadRoom" name="dormRooms[]" value="quad" class="sm:p-2 p-1 border rounded">
                            <label for="quadRoom" class="ml-2 text-sm">Quad Room</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="apartmentRoom" name="dormRooms[]" value="apartment" class="sm:p-2 p-1 border rounded">
                            <label for="apartmentRoom" class="ml-2 text-sm">Apartment Room</label>
                        </div>
                    </div>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="dormPhoto" class="block text-sm font-medium text-gray-700">Photo</label>
                    <input type="file" id="dormPhoto" name="dormPhoto" class="mt-1 sm:p-2 p-1 border rounded w-full bg-white text-gray-700" accept="jpg, jpeg, png">
                </div>
                <div class="sm:mt-4 mt-2">
                    <button type="submit" class="bg-orange-700 text-white sm:px-4 sm:py-2 px-2 py-1 rounded hover:bg-orange-500 transition duration-300">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>