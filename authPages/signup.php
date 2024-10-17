<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up</title>
    <link rel="stylesheet" href="../style/auth.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="h-screen bg-[url('../img/grayBuildings.jpg')] backdrop-blur">
    <div class="w-full max-w-4xl mx-auto flex items-center justify-center h-full sm:flex-row flex-col">
    <h1 class="lobster-regular">Welcome to your dream dorm!</h1>
    <form action="signin.php" method="post" class="bg-transparent shadow-lg rounded-[50px] px-10 bg-white/20 w-10/12 sm:w-full">
            <div class="form-header">
                <img class="sm:max-w-64 max-w-40 mx-auto" src="../img/logo.png" alt="">
                <h1 class="text-xl mb-3 text-center">Sign-up to start journey!</h1>
            </div>
            <div class="max-w-sm mx-auto">
                <input class="shadow appearance-none border-b-2 border-r-2 rounded-full w-full py-3 px-4 text-zinc-950 mb-3 leading-tight focus:outline-none focus:shadow-outline bg-white/30 placeholder:text-zinc-700 text-lg" name="username" type="text" placeholder="Username">
                <input class="shadow appearance-none border-b-2 border-r-2 rounded-full w-full py-3 px-4 text-zinc-950 mb-3 leading-tight focus:outline-none focus:shadow-outline bg-white/30 placeholder:text-zinc-700 text-lg" name="name" type="text" placeholder="Name">
                <input class="shadow appearance-none border-b-2 border-r-2 rounded-full w-full py-3 px-4 text-zinc-950 mb-3 leading-tight focus:outline-none focus:shadow-outline bg-white/30 placeholder:text-zinc-700 text-lg" name="surname" type="text" placeholder="Surname">
                <input class="shadow appearance-none border-b-2 border-r-2 rounded-full w-full py-3 px-4 text-zinc-950 mb-3 leading-tight focus:outline-none focus:shadow-outline bg-white/30 placeholder:text-zinc-700 text-lg" name="email" type="email" placeholder="Email">
                <input class="shadow appearance-none border-b-2 border-r-2 rounded-full w-full py-3 px-4 text-zinc-950 mb-3 leading-tight focus:outline-none focus:shadow-outline bg-white/30 placeholder:text-zinc-700 text-lg" name="password" type="password" placeholder="Password">
                <input class="shadow appearance-none border-b-2 border-r-2 rounded-full w-full py-3 px-4 text-zinc-950 mb-3 leading-tight focus:outline-none focus:shadow-outline bg-white/30 placeholder:text-zinc-700 text-lg" name="confirm" type="password" placeholder="Confirm Password">
            </div>
            
            <div class="flex flex-col">
                <div class="flex mb-3 gap-1">
                    <button type="submit" class="w-3/4 bg-green-800 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">Sign-Up</button>
                    <button type="reset" class="w-1/4 bg-red-800 hover:bg-red-700 text-white font-bold pt-2 pb-1 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                        <span class="material-symbols-outlined">
                            delete
                        </span>
                    </button>
                </div>
                <p class="mb-4 font-semibold">Already have an account? <a href="login.php" class="font-bold text-amber-500 hover:underline text-lg">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>