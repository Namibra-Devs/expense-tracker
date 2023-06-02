<?php


// START SESSION IF NOT STARTED
function startSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}


// FUNCTION TO REDIRECT TO ERROR PAGE ON SYSTEM ERROR
function systemError(string $message): void
{
    $_SESSION['error'] = $message;
    http_response_code(500);
    header('Location: error.php');
}

// SET ERROR MESSAGE IN SESSION
function setError($message, $options = [
    'redirect' => false,
    'exit' => false
])
{
    startSession(); 

    $_SESSION['error'] = $message ;
    
    if(['redirect'] !== false) {
        header("Location: ../{$options['redirect']}");
    }

    if ($options =['exit']) {
        exit;
    }
}

// SET SUCCESS MESSAGE IN SESSION
function setSuccess($message, $options = [
    'redirect' => null,
    'exit' => false
])
{
    startSession();
    
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



// GET ONE EXPENSE
function getExpense(PDO $conn, int $id): array | false
{
    static $cachedExpense = null;

    if ($cachedExpense !== null) {
        return $cachedExpense;
    }

    $getExpense = "SELECT * FROM expenses WHERE id = ?";
    $stmt = $conn->prepare($getExpense);
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $cachedExpense = $result;
    return $result;
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

// CREATE EXPENSE
function createExpense(PDO $conn, array $expense): bool
{
    $createExpense = "INSERT INTO expenses (amount, date, description, category) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($createExpense);
    return $stmt->execute($expense);
}

// UPDATE EXPENSE
function updateExpense(PDO $conn, array $expense): bool
{
    $updateExpense = "UPDATE expenses SET amount = ?, date = ?, description = ?, category = ? WHERE id = ?";
    $stmt = $conn->prepare($updateExpense);
    return $stmt->execute($expense);
}

// GET TOTAL EXPENSES FOR CURRENT MONTH
function getTotalExpensesForCurrentMonth($conn)
{
    static $memoizedResult = null;

    if ($memoizedResult !== null) {
        // RETURN THE RESULT IF IT HAS ALREADY BEEN CALCULATED
        return $memoizedResult;
    }

    // PREPARE QUERY TO GET TOTAL EXPENSES FOR CURRENT MONTH
    $getTotalExpForMonth = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')";
    $stmt = $conn->prepare($getTotalExpForMonth);
    $stmt->execute();

    // FETCH THE RESULT
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // GET THE TOTAL EXPENSES FROM THE RESULT
    $totalExpenses = $result['total_expenses'];

    // STORE THE RESULT IN THE STATIC VARIABLE
    $memoizedResult = $totalExpenses;

    return $totalExpenses;
}


function calculateMonthAverageExpenses($conn): float
{
    static $memoizedResult = null;

    if ($memoizedResult !== null) {
        return $memoizedResult;
    }

    $totalAmount = 0;
    $totalCount = 0;
    $avgExpenses = 0;

    $currentMonth = date('Y-m');
    
    $expenses = getExpenses($conn);
    foreach ($expenses as $expense) {
        $expenseDate = date('Y-m', strtotime($expense['date']));

        if ($expenseDate === $currentMonth) {
            $totalAmount += $expense['amount'];
            $totalCount++;
        }
    }

    if ($totalCount > 0) {
        $avgExpenses = $totalAmount / $totalCount;
    }

    $memoizedResult = $avgExpenses;

    return $avgExpenses;
}

function calculateTotalExpensesByMonth(PDO $conn): array
{
    $totalExpensesByMonth = array_fill(1, 12, 0);
    $expenses = getExpenses($conn);
    foreach ($expenses as $expense) {
        $expenseDate = date('n', strtotime($expense['date']));
        $totalExpensesByMonth[$expenseDate] += $expense['amount'];
    }

    return $totalExpensesByMonth;
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

// SANITIZE INPUT
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// GET CURRENT MONTH NAME
function getCurrentMonthName()
{
    static $monthName = null;

    if ($monthName !== null) {
        return $monthName;
    }

    $month = date('m');
    $monthName = date('F', mktime(0, 0, 0, $month, 10));

    return $monthName;
}