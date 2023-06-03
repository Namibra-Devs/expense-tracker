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

    $_SESSION['error'] = $message;

    if (['redirect'] !== false) {
        header("Location: ../{$options['redirect']}");
    }

    if ($options = ['exit']) {
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
    if ($options['exit']) {
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
function getExpenses(PDO $conn, array $options = [
    'sort' => 'date', 
    'order' => 'DESC',
    'filter_year_month' => null
])
{
    // SORT BY DATE 
    if(isset($options['filter_year_month'])) {
        $getAllExpenses = "SELECT * FROM expenses WHERE DATE_FORMAT(date, '%Y-%m') = ? ORDER BY {$options['sort']} {$options['order']}"; 
    } else {
        $getAllExpenses = "SELECT * FROM expenses ORDER BY {$options['sort']} {$options['order']}";
    }
    $stmt = $conn->prepare($getAllExpenses);
    if(isset($options['filter_year_month'])) {
        $stmt->execute([$options['filter_year_month']]);
    } else {
        $stmt->execute();
    }
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    return $result;
}



// GET ONE EXPENSE
function getExpense(PDO $conn, int $id): array | false
{

    $getExpense = "SELECT * FROM expenses WHERE id = ?";
    $stmt = $conn->prepare($getExpense);
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

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

    // PREPARE QUERY TO GET TOTAL EXPENSES FOR CURRENT MONTH
    $getTotalExpForMonth = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE DATE_FORMAT(date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')";
    $stmt = $conn->prepare($getTotalExpForMonth);
    $stmt->execute();

    // FETCH THE RESULT
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // GET THE TOTAL EXPENSES FROM THE RESULT
    $totalExpenses = $result['total_expenses'];

    return $totalExpenses;
}

function calculateAllExpenses(PDO $conn): float
{

    $totalAmount = 0;

    $expenses = getExpenses($conn);
    foreach ($expenses as $expense) {
        $totalAmount += $expense['amount'];
    }


    return $totalAmount;
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


function calculateTotalExpensesByMonth(PDO $conn, int $year): array
{
    $totalExpensesByMonth = array_fill(1, 12, 0);
    $expenses = getExpenses($conn);

    foreach ($expenses as $expense) {
        $expenseDate = date('n', strtotime($expense['date']));
        $expenseYear = date('Y', strtotime($expense['date']));

        if ($expenseYear == $year) {
            $totalExpensesByMonth[$expenseDate] += $expense['amount'];
        }
    }

    return $totalExpensesByMonth;
}

function getTotalExpensesForCurrentYear(PDO $conn): float
{
    static $memoizedResult = null;

    if ($memoizedResult !== null) {
        return $memoizedResult;
    }

    $totalAmount = 0;
    $totalCount = 0;
    $avgExpenses = 0;

    $currentYear = date('Y');

    $expenses = getExpenses($conn);
    foreach ($expenses as $expense) {
        $expenseDate = date('Y', strtotime($expense['date']));

        if ($expenseDate === $currentYear) {
            $totalAmount += $expense['amount'];
            $totalCount++;
        }
    }


    $memoizedResult = $totalAmount;

    return $totalAmount;
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


// GET ALL MONTHS OF THE YEAR
function getAllMonths()
{
    static $months = null;

    if ($months !== null) {
        return $months;
    }

    $months = [];

    for ($i = 1; $i <= 12; $i++) {
        $months[$i] = date('F', mktime(0, 0, 0, $i, 10));
    }

    return $months;
}