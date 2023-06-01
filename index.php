<?php
session_start();
require_once 'auxiliaries.php';

$view = $_GET['view'] ?? 'overview';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/styles/style.css">
    <title>Document</title>
</head>

<body>
    <div class="d-flex h-100 ">
        <?php require_once 'includes/sidebar.php' ?>
        <main class="w-100 h-100 p-4">
            <?php

            match ($view) {
                'overview' => require_once 'includes/overview.php',
                'expenses' => require_once 'includes/expenses.php',
                'addexpense' => require_once 'includes/addexpense.php',
                'edit' => require_once 'includes/edit.php',
                default => require_once 'includes/overview.php',
            };
            ?>
            <p class="text-center text-secondary mt-5" style="opacity: 0.5">Made by <a href="https://github.com/bensonOSei" target="_blank"  class="text-decoration-none text-secondary">Benson</a></p>
        </main>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script>
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl).show()
        })
    </script>

</body>

</html>