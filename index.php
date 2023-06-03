<!-- APPLICATION BEGINS -->

<?php

/**
 * THIS FILE IS THE ENTRY POINT OF THE APPLICATION
 * IT IS USED TO RENDER THE VIEWS
 */


require_once 'includes/header.php'; // INCLUDE THE HEADER FILE
?>

<main class="w-100 h-100 p-4 overflow-auto">
    <?php

    // CHECK IF THE VIEW QUERY PARAMETER IS SET
    // IF IT IS SET, RENDER THE VIEW BASED ON THE VALUE OF THE VIEW PARAMETER
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

<!-- APPLICATION ENDS -->