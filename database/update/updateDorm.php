<?php

    include '../../database/database_connection.php';
    include '../../database/session_check.php';
    
    
    $id = $_GET["id"]; 
    $sql = "SELECT * FROM dormitory where dormid = '$id'";

    $result = mysqli_query($connection, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $dormName = $row['dormname'];
        $dormPhone = $row['dormphone'];
        $dormLocation = $row['location'];
        $typeOfRooms = $row['typeofrooms'];
        $dormPhoto = $row['photo'];
    }

    if(isset($_POST["submit"])){
        $up_dormName = $_POST["dormName"];
        $up_dormPhone = $_POST["dormPhone"];
        $up_dormLocation = $_POST["dormLocation"];
        $up_dormRooms = $_POST['dormRooms'];

        $up_id = $_POST["id"];

        $up_photo = $_FILES["dormPhoto"]["name"];

        if ($_FILES["dormPhoto"]["error"] == 0) {
            $image_path = "../../img/dorms/" . basename($_FILES["dormPhoto"]["name"]);
            move_uploaded_file($_FILES["dormPhoto"]["tmp_name"], $image_path);
        }

        $sql = "UPDATE dormitory set dormname='$up_dormName', dormphone = '$up_dormPhone', location = '$up_dormLocation', typeofrooms = '$up_dormRooms', photo = '$image_path' WHERE dormid = '$up_id'";
        if(mysqli_query($connection, $sql)){
            header('Location: ../../mainPages/admin/admin.php?page=manage-dormitory');
        }
        else{
            echo "Error while updating the dormitory information".mysqli_error($connection);
        }

    }

    if(isset($_POST["cancel"])){
        header('Location: ../../mainPages/admin/admin.php?page=manage-dormitory');
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Dormitory</title>
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
        <h2 class="text-2xl font-bold mb-6 text-center">Update Dormitory</h2>
        <form action="updateDorm.php" method="post" class="bg-neutral-700/75 p-6 sm:p-8 rounded-lg shadow-md space-y-6" enctype="multipart/form-data">
            <div>
                <label for="dormName" class="font-medium block mb-2">Dormitory Name</label>
                <input type="text" id="dormName" name="dormName" class="p-3 border border-gray-400 rounded w-full text-gray-900" value="<?php echo $dormName; ?>" required>
            </div>
            <div>
                <label for="dormPhone" class="font-medium block mb-2">Phone</label>
                <input type="text" id="dormPhone" name="dormPhone" class="p-3 border border-gray-400 rounded w-full text-gray-900" value="<?php echo $dormPhone; ?>" required>
            </div>
            <div>
                <label for="dormLocation" class="font-medium block mb-2">Location</label>
                <input type="text" id="dormLocation" name="dormLocation" class="p-3 border border-gray-400 rounded w-full text-gray-900" value="<?php echo $dormLocation; ?>" required>
            </div>
            <!-- I cant make it dynamically checked using checkbox, i prefered traditional method-->
            <div>
                <!-- actually types of rooms -->
                <label for="dormRooms" class="font-medium block mb-0">Type of Rooms</label>
                <small class="">Hint: single, double, triple, quad and apartment avaible in DB. DON'T USE SPACE</small>
                <input type="text" id="dormRooms" name="dormRooms" class="p-3 border border-gray-400 rounded w-full text-gray-900" value="<?php echo $typeOfRooms; ?>" required>
            </div>
            <div>
                <label for="dormPhoto" class="font-medium block mb-2">Photo</label>
                <input type="file" id="dormPhoto" name="dormPhoto" class="p-3 border border-gray-400 rounded w-full bg-white text-gray-900">
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="text-center">
                <button type="submit" name="submit" class="bg-orange-700 text-white px-6 py-3 rounded hover:bg-orange-500 transition duration-300 w-full sm:w-auto">Update</button>
                <button type="submit" name="cancel" class="bg-red-700 text-white px-6 py-3 rounded hover:bg-red-500 transition duration-300 w-full sm:w-auto">Cancel</button>
            </div>
        </form>
    </div>
</body>




</html>