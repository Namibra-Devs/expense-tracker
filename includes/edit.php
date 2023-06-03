<?php

// THIS IS THE EDIT EXPENSE VIEW
// IT IS SIMILAR TO THE ADD EXPENSE VIEW
// THE ONLY DIFFERENCE IS THAT IT HAS A FORM WITH THE CURRENT VALUES OF THE EXPENSE
// AND A HIDDEN INPUT FIELD WITH THE ID OF THE EXPENSE TO BE EDITED

// CHECK IF THE EXPENSE ID IS SET
if (!isset($_GET['exp'])) {

    // IF NOT SET, REDIRECT TO THE EXPENSES VIEW
    header('Location: ./');
    exit; // STOP SCRIPT
}

// GET THE EXPENSE TO BE EDITED
$expense = getExpense($conn, $_GET['exp']);

// CHECK IF THE EXPENSE EXISTS
if (!$expense || count($expense) === 0) {

    // IF NOT, REDIRECT TO THE EXPENSES VIEW
    header('Location: ./');
    exit;
}
?>

<!-- EDIT EXPENSE VIEW BEGINS -->
<div class="mb-3 border-bottom d-flex align-items-center justify-content-between">
    <h1>Edit Expense</h1>
    <a href="./?view=expenses" class="btn btn-primary d-flex gap-2 align-items-center">
        <i class="fa-solid fa-arrow-left"></i> <span>Back</span>
    </a>

</div>

<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 mx-auto">
            <!-- 
                THE FORM HAS THE CURRENT VALUES OF THE EXPENSE AS THE VALUE OF THE INPUTS
                THIS IS DONE BY CHECKING IF THE CURRENT VALUE IS EQUAL TO THE VALUE OF THE INPUT
                IF IT IS, THEN THE SELECTED ATTRIBUTE IS ADDED TO THE OPTION
             -->

             <!-- FORM BEGINS -->
            <form action="./processes/edit.proc.php" method="POST">
                <input type="hidden" name="id" value="<?= $_GET['exp'] ?>">
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="text" class="form-control" id="amount" name="amount" value="<?= $expense['amount'] ?>">
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control mb-2" id="date" name="date" value="<?= $expense['date'] ?>">
                    <button class="btn btn-outline-secondary" type="button" style="font-size: 13px;" id="pick-today">Today</button>
                    <button class="btn btn-outline-secondary" type="button" style="font-size: 13px;" id="pick-yesterday">Yesterday</button>

                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" id="description" name="description" value="<?= $expense['description'] ?>">
                    <small id="descriptionHelp" class="form-text text-muted">A short description of the expense. eg. "New shoes" <br>
                        <span class="text-danger">Max 15 characters</span>
                    </small>
                    <div class="text-muted" style="font-size: 12px;">
                        <span id="description-count">0</span>/15
                    </div>

                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" aria-label="Default select example" id="category" name="category">
                        <option selected disabled value="">Select Category</option>
                        <option value="Food" <?= $expense['category'] === 'Food' ? 'selected' : '' ?>>Food</option>
                        <option value="Transportation" <?= $expense['category'] === 'Transportation' ? 'selected' : '' ?>>Transportation</option>
                        <option value="Clothing" <?= $expense['category'] === 'Clothing' ? 'selected' : '' ?>>Clothing</option>
                        <option value="Rent" <?= $expense['category'] === 'Rent' ? 'selected' : '' ?>>Rent</option>
                        <option value="Utilities" <?= $expense['category'] === 'Utilities' ? 'selected' : '' ?>>Utilities</option>
                        <option value="Entertainment" <?= $expense['category'] === 'Entertainment' ? 'selected' : '' ?>>Entertainment</option>
                        <option value="Miscellaneous" <?= $expense['category'] === 'Miscellaneous' ? 'selected' : '' ?>>Miscellaneous</option>
                    </select>
                </div>
                <button type="submit" name="edit" class="btn btn-primary w-100">Edit</button>
            </form>
            
            <!-- FORM ENDS -->

        </div>
    </div>
</div>

<!-- MODAL FOR ALERTS. CALLED BY src/js/Alert.js -->
<div id="modal"></div>

<!-- SCRIPT FOR EDIT EXPENSE VIEW -->
<script src="../src/js/addexpenses.js" type="module"></script>

<!-- EDIT EXPENSE VIEW ENDS -->