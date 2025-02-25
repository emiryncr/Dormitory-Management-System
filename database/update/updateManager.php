<?php
    include '../../database/database_connection.php';
    include '../../database/session_check.php';

    $id = $_GET["id"]; 
    $sql = "SELECT * FROM users where userid = '$id' AND role = 'manager'";

    $result = mysqli_query($connection, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row["userid"];
        $username = $row["username"];
        $name = $row["name"];
        $surname = $row["surname"];
        $email = $row["email"];
        $phone = $row["phone"];
        $dormid = $row["dormid"];
    }

    if(isset($_POST["submit"])){

        $up_id = $_POST["id"];
        $up_username = $_POST["username"];
        $up_name = $_POST["name"];
        $up_surname = $_POST["surname"];
        $up_email = $_POST["email"];
        $up_phone = $_POST["phone"];
        $up_dormid = $_POST["dormid"];

        $sql = "UPDATE users SET username = '$up_username', name = '$up_name', surname = '$up_surname', email = '$up_email', phone = '$up_phone', dormid = '$up_dormid' WHERE userid = '$up_id'";
        if(mysqli_query($connection, $sql)){
            header('Location: ../../mainPages/admin/admin.php?page=manage-managers');
        }
        else{
            echo "Error while updating the manager information".mysqli_error($connection);
        }

    }

    if(isset($_POST["cancel"])){
        header('Location: ../../mainPages/admin/admin.php?page=manage-managers');
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Manager</title>
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
        <h2 class="text-2xl font-bold mb-6 text-center">Update Manager</h2>
        <form action="updateManager.php" method="post" class="bg-neutral-700/75 p-6 sm:p-8 rounded-lg shadow-md space-y-6">
        <div>
            <label for="username" class="font-medium block mb-2">Username</label>
            <input type="text" id="username" name="username" class="p-3 border border-gray-400 rounded w-full text-gray-900" value="<?php echo $username; ?>" required>
        </div>
        <div>
            <label for="name" class="font-medium block mb-2">Name</label>
            <input type="text" id="name" name="name" class="p-3 border border-gray-400 rounded w-full text-gray-900" value="<?php echo $name; ?>" required>
        </div>
        <div>
            <label for="surname" class="font-medium block mb-2">Surname</label>
            <input type="text" id="surname" name="surname" class="p-3 border border-gray-400 rounded w-full text-gray-900" value="<?php echo $surname; ?>" required>
        </div>
        <div>
            <label for="email" class="font-medium block mb-2">Email</label>
            <input type="email" id="email" name="email" class="p-3 border border-gray-400 rounded w-full text-gray-900" value="<?php echo $email; ?>" required>
        </div>
        <div>
            <label for="phone" class="font-medium block mb-2">Phone</label>
            <input type="text" id="phone" name="phone" class="p-3 border border-gray-400 rounded w-full text-gray-900" value="<?php echo $phone; ?>" required>
        </div>
        <div>
            <label for="dormid" class="font-medium block mb-2">Dormitory ID</label>
            <select name="dormid" id="dormid" class="p-3 border border-gray-400 rounded w-full text-gray-900">
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

                    $currentManagersDormID = $dormid;
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $dormId = $row["dormid"];
                            //tips: here i have to keep my manager's dormid except for array
                            $checkIfDormAss = (in_array($dormId, $userAssignedToDorm) 
                            && $dormId != $currentManagersDormID) ? 'disabled' : '';

                            echo '<option ' . $checkIfDormAss . ' value="' . htmlspecialchars($row["dormid"]) . '" ' . 
                            ($row["dormid"] == $dormid ? 'selected' : '') . 
                            '>' . htmlspecialchars($row["dormname"]) . '</option>';
                        }
                    } else {
                        echo "0 results";
                    }
                    $connection->close();

                ?>
            </select>
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