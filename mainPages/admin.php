<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="icon" type="image/x-icon" href="../img/lightLogo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=logout" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=menu" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    * {
        margin: 0;
        padding: 0;
    }
    .montserrat {
        font-family: "Montserrat", sans-serif;
        font-optical-sizing: auto;
        font-weight: 500;
        font-style: normal;
    }
</style>
<body class="bg-neutral-900">
    <?php
        $links = [
            'Dorms' => '',
            'Managers' => '',
            'Students' => ''
        ];
        include './components/navbar.php';
    ?>
    <main class="h-[55rem]">
        <!-- Content goes here after starting MySql Course ... -->
    </main>

    <?php include 'components/footer.php'; ?>


    <script>
        // Navbar toggle
        document.querySelector('[data-collapse-toggle]').addEventListener('click', function() {
            var target = document.getElementById(this.getAttribute('aria-controls'));
            if (target.classList.contains('hidden')) {
                target.classList.remove('hidden');
            } else {
                target.classList.add('hidden');
            }
        });
</script>
</body>
</html>