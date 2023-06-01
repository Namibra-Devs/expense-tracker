<?php

// FUNCTION TO REDIRECT TO ERROR PAGE ON SYSTEM ERROR
function systemError(string $message): void
{
    $_SESSION['error'] = $message;
    http_response_code(500);
    header('Location: error.php');
}

// FUNCTION TO READ ERROR MESSAGE FROM SESSION
function readError(): string
{
    $error = $_SESSION['error'];
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
 * @return PDOStatement|bool PDO STATEMENT OR FALSE
 */
function deleteExpense(PDO $conn, int $id): PDOStatement | bool
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
