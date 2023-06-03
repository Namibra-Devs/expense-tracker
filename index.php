<?php
require_once 'includes/header.php';


?>
<main class="w-100 h-100 p-4 overflow-auto">
    <?php

    match ($view) {
        'overview' => require_once 'includes/overview.php',
        'expenses' => require_once 'includes/expenses.php',
        'addexpense' => require_once 'includes/addexpense.php',
        'edit' => require_once 'includes/edit.php',
        default => require_once 'includes/overview.php',
    };
    ?>
    <p class="text-center text-secondary mt-5" style="opacity: 0.5">Made by <a href="https://github.com/bensonOSei" target="_blank" class="text-decoration-none text-secondary">Benson</a></p>
</main>

<?php require_once 'includes/footer.php' ?>