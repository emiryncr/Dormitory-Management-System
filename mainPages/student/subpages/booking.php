<div class="m-5 p-4 bg-neutral-800/75 rounded-lg shadow-lg">

    <div class="mt-5 text-white grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php
                include '../../database/database_connection.php';

                $sql = "SELECT dormid, dormname, dormphone, typeofrooms, photo FROM dormitory";
                $result = $connection->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="content bg-neutral-700/75 text-white p-4 rounded-lg shadow-md">';
                        echo '<img src="' . htmlspecialchars($row["photo"]) . '" alt="Dorm Image" class="w-full h-40 object-cover rounded-lg mb-4">';
                        echo '<p class="font-bold text-xl">'.$row["dormname"].'</p>';
                        echo '<hr class="my-1 border-neutral-600 border-2">';
                        echo '<p>Phone: +'.$row["dormphone"].'</p>';
                        echo '<hr class="my-1 border-neutral-600">';
                        echo '<p>Room Types: ' . htmlspecialchars($row["typeofrooms"]) . '</p>';
                        echo '<hr class="my-1 border-neutral-600">';
                        echo '<p> Dorm id '.$row["dormid"].'</p>';
                        echo '<hr class="my-1 border-neutral-600">';
                        echo "<button class='browse-rooms-btn my-1 bg-orange-600 hover:bg-orange-500 text-white px-4 py-2 rounded' data-dormid='{$row['dormid']}'>Browse Rooms</button>";
                        echo '</div>';
                    }
                } else {
                    echo "<li>0 dormitories</li>";
                }

                $connection->close();
            ?>
        </div>
</div>

<div id="roomsModal" class="hidden fixed z-10 inset-0 overflow-y-auto backdrop-blur-md">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-neutral-300 rounded-lg sm:p-6 p-4 sm:ml-0 sm:mr-0 mr-5 ml-5 mt-24 shadow-lg sm:w-1/2 w-full">
            <div class="flex justify-between items-center border-b pb-2">
                <h2 class="sm:text-xl text-md font-semibold">
                    Rooms
                </h2>
                <button id="closeModalBtn" class="text-red-700 hover:text-red-500 text-2xl font-bold">&times;</button>
            </div>
            <div id="roomsContent" class="sm:mt-4 mt-2 grid md:grid-cols-2 grid-cols-1 gap-4">
                
            </div>
        </div>
    </div>
</div>
