<?php
    include '../../database/database_connection.php';
    include '../../database/session_check.php';

    $id = $_GET["id"]; 
    $sql = "SELECT * FROM rooms where roomid = '$id'";

    $result = mysqli_query($connection, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $roomName = $row["roomname"];
        $roomType = $row["roomtype"];
        $roomCapacity = $row["capacity"];
        $roomPrice = $row["price"];
        $assignDorm = $row["assigndorm"];
        $roomPhoto = $row["photo"];
    }

    if(isset($_POST["submit"])){
        $up_id = $_POST["id"];
        $up_roomName = $_POST["roomName"];
        $up_roomType = $_POST["roomType"];
        $up_roomCapacity = $_POST["roomCapacity"];
        $up_roomPrice = $_POST["roomPrice"];
        $up_assignDorm = $_POST["assigndorm"];

        $up_photo = $_FILES["roomPhoto"]["name"];

        if ($_FILES["roomPhoto"]["error"] == 0){
            $image_path = "../../img/rooms/". basename($_FILES["roomPhoto"]["name"]);
            move_uploaded_file($_FILES["roomPhoto"]["tmp_name"], $image_path);
        }

        $sql = "UPDATE rooms SET roomname = '$up_roomName', roomtype = '$up_roomType', capacity = '$up_roomCapacity', price = '$up_roomPrice', assigndorm = '$up_assignDorm', photo = '$image_path' WHERE roomid = '$up_id'";
        if(mysqli_query($connection, $sql)){
            header('Location: ../../mainPages/manager/manager.php?page=manage-rooms');
        }
        else{
            echo "Error while updating the room information".mysqli_error($connection);
        }

    }

    if(isset($_POST["cancel"])){
        header('Location: ../../mainPages/manager/manager.php?page=manage-rooms');
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Room</title>
    <link rel="icon" type="image/x-icon" href="../../img/lightLogo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=logout" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=menu" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="min-h-screen bg-neutral-900 flex items-center justify-center">
    <div class="bg-neutral-800/75 w-full max-w-md sm:max-w-lg lg:max-w-xl p-6 sm:p-8 text-white rounded-lg shadow-lg mx-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Update Rooom</h2>
        <form action="updateRoom.php" method="post" class="bg-neutral-700/75 p-6 sm:p-8 rounded-lg shadow-md space-y-6" enctype="multipart/form-data">
            <div>
                <label for="roomName" class="font-medium block mb-2">Room Name</label>
                <input type="text" id="roomName" name="roomName" class="p-3 border border-gray-400 rounded w-full text-gray-900" value="<?php echo $roomName; ?>" required>
            </div>
            <div>
                <label for="roomType" class="font-medium block mb-2">Type of Room</label>
                <select name="roomType" id="roomType" class="p-3 border border-gray-400 rounded w-full text-gray-900" required>
                    <option value="single" <?php if($roomType == "single") echo "selected"; ?>>Single Room</option>
                    <option value="double" <?php if($roomType == "double") echo "selected"; ?>>Double Room</option>
                    <option value="triple" <?php if($roomType == "triple") echo "selected"; ?>>Triple Room</option>
                    <option value="quad" <?php if($roomType == "quad") echo "selected"; ?>>Quad Room</option>
                    <option value="dormitory" <?php if($roomType == "dormitory") echo "selected"; ?>>Dormitory Room</option>
                </select>
            <div>
            <div>
                <label for="roomCapacity" class="font-medium block mb-2">Capacity</label>
                <input type="number" id="roomCapacity" name="roomCapacity" class="p-3 border border-gray-400 rounded w-full text-gray-900" value="<?php echo $roomCapacity; ?>" required>
            </div>
            <div>
                <label for="roomPrice" class="font-medium block mb-2">Price</label>
                <input type="number" id="roomPrice" name="roomPrice" class="p-3 border border-gray-400 rounded w-full text-gray-900" value="<?php echo $roomPrice; ?>" required>
            </div>
            <div>
            <label for="assigndorm" class="font-medium block mb-2">Dormitory ID</label>
            <select name="assigndorm" id="assigndorm" class="p-3 border border-gray-400 rounded w-full text-gray-900">
                <?php
                    include '../../database/database_connection.php';
                    $sql = "SELECT dormid, dormname FROM dormitory";
                    $result = $connection->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row["dormid"]) . '" ' . 
                            ($row["dormid"] == $assignDorm ? 'selected' : '') . 
                            '>' . htmlspecialchars($row["dormname"]) . '</option>';
                        }
                    } else {
                        echo "<option value='' disabled selected>No dormitories available</option>";
                    }
                    $connection->close();
                ?>
            </select>
        </div>
        <div>
            <label for="roomPhoto" class="font-medium block mb-2">Photo</label>
            <input type="file" id="roomPhoto" name="roomPhoto" class="p-3 border border-gray-400 rounded w-full bg-white text-gray-900">
        </div>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="text-center mt-5">
            <button type="submit" name="submit" class="bg-orange-700 text-white px-6 py-3 rounded hover:bg-orange-500 transition duration-300 w-full sm:w-auto">Update</button>
            <button type="submit" name="cancel" class="bg-red-700 text-white px-6 py-3 rounded hover:bg-red-500 transition duration-300 w-full sm:w-auto">Cancel</button>
        </div>
        </form>
    </div>
</body>




</html>