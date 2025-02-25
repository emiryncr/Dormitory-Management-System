<div>
    <h1 class="text-white text-4xl text-center">Manage Managers</h1>
    
    <div class="m-5 p-4 bg-neutral-800/75 rounded-lg shadow-lg">
        
        <div class="flex justify-center sm:flex-row flex-col gap-2">
            <button id="addBtn" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300 min-w-max">Add Manager</button>
            <div class="relative">
                <!-- <input type="text" class="input bg-gray-200 text-gray-800 pl-4 pr-10 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 w-full" placeholder="Search Manager"/>
                <button class="absolute right-0 top-0 mt-2 mr-3 text-gray-600 hover:text-gray-800 transition duration-300">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button> -->
            </div>
        </div>

        <div class="mt-5 text-white grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php
                include '../../database/database_connection.php';

                $sql = "SELECT users.*, dormitory.dormname
                 FROM users 
                 LEFT JOIN dormitory ON users.dormid = dormitory.dormid
                 WHERE role = 'manager'
                 ";
                $result = $connection->query($sql);

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
                        echo '<p class="text-md">Role: ' . htmlspecialchars($row["role"]) . '</p>';
                        echo '<hr class="my-1 border-neutral-600">';
                        echo '<p class="text-md">Dorm Name: ' . htmlspecialchars($row["dormname"]) . '</p>';
                        echo '<hr class="my-1 border-neutral-600">';
                        echo '<p class="text-md">Dorm ID: ' . htmlspecialchars($row["dormid"]) . '</p>';
                        echo '<div class="mt-4 flex justify-around">';
                        echo '<a href="../../database/update/updateManager.php?id=' . urlencode($row["userid"]) . '" class="bg-orange-600 hover:bg-orange-500 text-white px-4 py-2 rounded">Update</a>';
                        echo '<a href="../../database/delete/deleteUser.php?id=' . urlencode($row["userid"]) . '" class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded">Delete</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "0 managers";
                }

                $connection->close();
            ?>
        </div>

    </div>

 <div id="addModal" class="hidden fixed z-10 inset-0 overflow-y-auto backdrop-blur-md">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-neutral-300 rounded-lg sm:p-6 p-4 shadow-lg sm:min-w-96 max-w-64 mt-20 sm:mt-0">
            <div class="flex justify-between items-center border-b pb-2">
                <h2 class="sm:text-xl text-md font-semibold">Add Manager Pop-Up</h2>
                <button id="closeModalBtn" class="text-red-700 hover:text-red-500 text-2xl font-bold">&times;</button>
            </div>
            <form action="../../database/add/addManager.php" method="POST">
                <div class="sm:mt-4 mt-2">
                    <label for="mngUsername" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="mngUsername" name="mngUsername" class="mt-1 sm:p-2 p-1 border rounded w-full" minlength="3" required>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="mngName" class="block text-sm font-medium text-gray-700">Manager Name</label>
                    <input type="text" id="mngName" name="mngName" class="mt-1 sm:p-2 p-1 border rounded w-full" minlength="2" required>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="mngSurname" class="block text-sm font-medium text-gray-700">Manager Surname</label>
                    <input type="text" id="mngSurname" name="mngSurname" class="mt-1 sm:p-2 p-1 border rounded w-full" minlength="2" required>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="mngEmail" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="mngEmail" name="mngEmail" class="mt-1 sm:p-2 p-1 border rounded w-full" required>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="mngPhone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" id="mngPhone" name="mngPhone" class="mt-1 sm:p-2 p-1 border rounded w-full" maxlength="12" required>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="mngDorm" class="block text-sm font-medium text-gray-700">Dormitory</label>
                    <select name="mngDorm" id="mngDorm" class="mt-1 sm:p-2 p-1 border rounded w-full">
                        <?php
                            include '../../database/database_connection.php';
                            $sql = "SELECT dormid, dormname FROM dormitory";
                            $result = $connection->query($sql);

                            
                            $sqlAssignedToDorm = "SELECT dormid FROM users WHERE role = 'Manager'";
                            $userAssignedToDorm = [];
                            $resultOfdormids = $connection->query($sqlAssignedToDorm);
                            while($userRow = $resultOfdormids->fetch_assoc()) {
                                $userAssignedToDorm[] = $userRow["dormid"];
                            }

                            //tips: in_array func according to my reserch, it search for the value in the array and return true if it is found
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $dormId = $row["dormid"];
                                    $checkIfDormAss = in_array($dormId, $userAssignedToDorm) ? 'disabled' : '';
                                    echo '<option ' . $checkIfDormAss . ' value="' . htmlspecialchars($row["dormid"]) . '">' . 
                                    htmlspecialchars($row["dormname"]) . '</option>';
                                }
                            } else {
                                echo "0 managers";
                            }
                            $connection->close();
                        ?>
                    </select>
                </div>
                <div class="sm:mt-4 mt-2">
                    <label for="mngPassword" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="mngPassword" name="mngPassword" class="mt-1 sm:p-2 p-1 border rounded w-full" minlength="8" required>
                </div>
                <hr class="mt-2">
                <div class="sm:mt-4 mt-2">
                    <button type="submit" class="bg-orange-700 text-white sm:px-4 sm:py-2 px-2 py-1 rounded hover:bg-orange-500 transition duration-300 sm:text-md text-sm">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>