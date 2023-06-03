<?php
// THIS IS THE EXPENSES VIEW
// IT DISPLAYS ALL THE EXPENSES IN A TABLE
// IT ALSO HAS A FORM FOR FILTERING THE EXPENSES


if (isset($_GET['sort_by']) && isset($_GET['sort-order'])) {
    $sort_by = $_GET['sort_by']; // STORE THE SORT BY VALUE 
    $sort_order = $_GET['sort-order']; // STORE THE SORT ORDER VALUE

    // CHECK IF THE FILTER YEAR MONTH IS SET
    if (!empty($_GET['filter_year_month'])) {


        $filter_year_month = $_GET['filter_year_month']; // STORE THE FILTER YEAR MONTH VALUE

        // GET THE EXPENSES WITH THE FILTER YEAR MONTH
        $expenses = getExpenses($conn, [
            'sort' => $sort_by,
            'order' => $sort_order,
            'filter_year_month' => $filter_year_month
        ]);
    } else {

        // GET THE EXPENSES WITHOUT THE FILTER YEAR MONTH
        $expenses = getExpenses($conn, [
            'sort' => $sort_by,
            'order' => $sort_order
        ]);
    }
} else {

    // GET THE EXPENSES WITHOUT THE SORT BY AND SORT ORDER AND FILTER YEAR & MONTH
    $expenses = getExpenses($conn);
}

?>

<!-- EXPENSES VIEW BEGINS -->
<div class="mb-3 border-bottom d-flex align-items-center justify-content-between">
    <h1 class="text-bold">Expenses</h1>
    <a href="?view=addexpense" class="btn btn-primary"><i class="fas fa-plus"></i> Add Expense</a>
</div>
<div class="container">
    <div class="row mb-3">
        <div class="col-12">

            <!-- FILTER FORM BEGINS -->
            <form class="row gy-2 gx-3 align-items-center justify-content-between w-100 mb-4">
                <input type="hidden" name="view" value="expenses">
                <div class="col-auto d-flex align-items-center gap-3">
                    <div class="input-group">
                        <span class="input-group-text">Order</span>
                        <select name="sort-order" class=" form-select " id="sort-order">
                            <option value="ASC" <?= isset($_GET['sort-order']) && $_GET['sort-order'] == 'ASC' ? 'selected' : '' ?>>Ascending</option>
                            <option value="DESC" <?= isset($_GET['sort-order']) && $_GET['sort-order'] == 'DESC' ? 'selected' : ''; ?>>Descending</option>
                        </select>

                    </div>
                    <div class="input-group">
                        <span class="input-group-text">By</span>
                        <select class="form-select" aria-label="Default select example" id="sort_by" name="sort_by" required>
                            <option value="amount" <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'amount' ? 'selected' : '' ?>>
                                Amount</option>

                            <option value="date" <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'date' ? 'selected' : '' ?>>
                                Date</option>

                            <option value="category" <?= isset($_GET['sort_by']) && $_GET['sort_by'] == 'category' ? 'selected' : '' ?>>
                                Category</option>

                        </select>
                    </div>

                    <div class="input-group">
                        <span class="input-group-text">Filter</span>
                        <input type="month" class="form-control" name="filter_year_month" id="filter_year_month" value="<?= isset($_GET['filter_year_month']) ? $_GET['filter_year_month'] : '' ?>">
                    </div>

                    <button type="submit" class="btn btn-secondary">Submit</button>
                </div>
            </form>
            <!-- FILTER FORM ENDS -->

        </div>
    </div>
    <div>
    </div>

    <!-- EXPENSES TABLE BEGINS -->
    <table class="table table-light table-borderless table-responsive border rounded">
        <caption class="caption-top">List of all Expenses </caption>
        <thead class="table-primary">
            <tr>
                <th class="p-3" scope="col">Amount</th>
                <th class="p-3" scope="col">Date</th>
                <th class="p-3" scope="col">Description</th>
                <th class="p-3" scope="col">Category</th>
                <th class="p-3" scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($expenses) > 0) :
                foreach ($expenses as $expense) :
            ?>
                    <tr>
                        <td class="p-3">GHS <?= $expense['amount'] ?></td>
                        <td class="p-3"> <?= date('d M Y', strtotime($expense['date'])) ?></td> 
                        <td class="p-3"> <?= $expense['description'] ?></td>
                        <td class="p-3"> <?= $expense['category'] ?></td>
                        <td class="p-3">
                            <a href="?view=edit&exp=<?= $expense['id'] ?>" class="btn btn-primary">Edit</a>
                            <button class="btn btn-primary delBtn" data-expenseId="<?= $expense['id'] ?>">Delete</button>
                        </td>
                    </tr>
                <?php
                endforeach;
            else :
                ?>
                <tr>
                    <td colspan="5" class="text-center text-secondary p-3">No expenses found
                        <?= isset($_GET['filter_year_month']) ? 'for ' .
                            date('F Y', strtotime($_GET['filter_year_month']))
                            : '' ?>
                        <a href="?view=addexpense"> Add Expense</a>
                    </td>
                </tr>
            <?php
            endif;
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">

                    <!-- Total expense -->
                    <div>
                        <small class="text-muted">
                            Total Expenses: <span class="text-bold"> GHS
                                <?php
                                $totalExpenses = 0;
                                foreach ($expenses as $expense) {
                                    $totalExpenses += $expense['amount'];
                                }
                                echo number_format($totalExpenses, 2, '.', '');
                                ?>
                            </span>
                        </small>
                    </div>
                </td>

            </tr>

        </tfoot>
    </table>
    <!-- EXPENSES TABLE ENDS -->

    <!-- MODAL FOR ALERTS. CALLED BY src/js/Alert.js -->
    <div id="modal"></div>

    <!-- SCRIPT FOR EXPENSES VIEW -->
    <script type="module" src="../src/js/expenses.js"></script>

</div>

<?php
// SHOW  SUCCESS MESSAGE
if (isset($_SESSION['success'])) :
?>
    <!-- 
    PLAY SUCCESS SOUND WHEN SUCCESS MESSAGE IS SET
    just a little fun 😁🤣
     -->
    <script>
        const audio = new Audio('../success.mp3');
        audio.play();
    </script>
    <div class="toast align-items-center text-white bg-success border-0 position-fixed top-0 mt-4 end-0 mx-4 " role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <?= $_SESSION['success'] ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
<?php
    unset($_SESSION['success']); // UNSET THE SUCCESS MESSAGE AFTER DISPLAYING IT
endif;
?>