<?php

require_once 'auxiliaries.php';
require_once 'config.php';

if(!isset($_GET['exp'])) {
    header('Location: ./');
    exit;
}

$expense = getExpense($conn, $_GET['exp']);
?>

<div class="mb-3 border-bottom d-flex align-items-center justify-content-between">
    <h1>Edit Expense</h1>
    <a href="?view=expenses" class="btn btn-primary"> Back</a>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 mx-auto">
            <form action="./processes/edit.proc.php" method="POST">
                <input type="hidden" name="id" value="<?= $_GET['exp'] ?>">
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="text" class="form-control" id="amount" name="amount" value="<?= $expense['amount'] ?>">
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="<?= $expense['date'] ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" id="description" name="description" value="<?= $expense['description'] ?>">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" class="form-control" id="category" name="category" value="<?= $expense['category'] ?>">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
