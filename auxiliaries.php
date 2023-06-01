<?php

// FUNCTION TO REDIRECT TO ERROR PAGE ON SYSTEM ERROR
function systemError(string $message): void
{
    $_SESSION['error'] = $message;
    http_response_code(500);
    header('Location: error.php');
}

// SET ERROR MESSAGE IN SESSION
function setError($message, $exit = false)
{
    $_SESSION['error'] = $message ;
    header('Location: ../error.php');

    if ($exit) {
        exit;
    }
}

// SET SUCCESS MESSAGE IN SESSION
function setSuccess($message, $options = [
    'redirect' => null,
    'exit' => false
])
{
    $_SESSION['success'] = $message;
    if ($options['redirect'] !== null) {
        header("Location: ../{$options['redirect']}");
    }
    if($options['exit']) {
        exit;
    }
}

// FUNCTION TO READ ERROR MESSAGE FROM SESSION
function readError(): string
{
    $error = $_SESSION['error'] ?? 'Something went wrong';
    unset($_SESSION['error']);

    return $error;
}

/**
* FUNCTION TO GET USER'S EXPENSES FROM DATABASE
* 
* @param PDO $conn DATABASE CONNECTION
* @param int $id USER ID
* @return array ARRAY OF EXPENSES
*/
function getExpenses(PDO $conn, bool $refresh = false): array
{
    static $cachedExpenses = null;

    if ($cachedExpenses === null || $refresh) {
        $getAllExpenses = "SELECT * FROM expenses";
        $stmt = $conn->prepare($getAllExpenses);
        $stmt->execute(/*[$id] */);
        $cachedExpenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $cachedExpenses;
}

/**
 * FUNCTION TO GET USER'S EXPENSES FROM DATABASE
 * 
 * @param PDO $conn DATABASE CONNECTION
 * @param int $id USER ID
 * @return bool `TRUE` IF SUCCESSFUL OR `FALSE` IF NOT
 */
function deleteExpense(PDO $conn, int $id): bool
{
    $deleteExpense = "DELETE FROM expenses WHERE id = ?";
    $stmt = $conn->prepare($deleteExpense);
    return $stmt->execute([$id]);

}


// ACTIVATE LINK IN SIDEBAR
function activateLink($view, $link)
{
    if ($view === $link) {
        echo 'bg-white text-primary';
    } else {
        echo 'text-white';
    }
}
