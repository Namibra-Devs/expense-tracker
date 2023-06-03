<?php
session_start(); 
require_once 'auxiliaries.php';
require_once 'config.php';


$view = $_GET['view'] ?? 'overview';  // GET THE VIEW FROM THE URL PARAMETER

?>
<!-- HEADER BEGINS -->
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
    <script src="https://kit.fontawesome.com/6db44154cb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="src/styles/style.css">
    <title>Expense Tracker</title>
</head>

<body>
    <div class="d-flex h-100 position-fixed top-0 end-0 w-100">
        <!-- INCLUDE SIDEBAR ON ALL VIEWS  -->
        <?php require_once 'includes/sidebar.php' ?> 

<!-- HEADER ENDS -->