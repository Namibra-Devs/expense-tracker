<?php
require_once 'auxiliaries.php';
require_once 'config.php';

$expenses = getExpenses($conn); // GET ALL EXPENSES FROM DATABASE

?>


<div class="mb-3 border-bottom d-flex align-items-center justify-content-between">
    <h1 class="text-bold" >Expenses</h1>
    <a href="?view=addexpense" class="btn btn-primary"> Add Expense</a>
</div>
<div class="container">
    <div class="row mb-3">
        <div class="col-12">
            <form class="row gy-2 gx-3 align-items-center justify-content-between w-100 mb-4">
                <div class="col-auto d-flex gap-4">
                    <div class="col-auto">
                        <label class="visually-hidden" for="min-amount">Minimum Amount</label>
                        <input type="text" class="form-control" id="min-amount" placeholder="Minimum Amount">
                    </div>
                    <div class="col-auto">
                        <label class="visually-hidden" for="max-amount">Max Amount</label>
                        <input type="text" class="form-control" id="max-amount" placeholder="Maximum Amount">
                    </div>
                    <div class="col-auto">
                        <label class="visually-hidden" for="category">Category</label>
                        <input type="text" class="form-control" id="category" placeholder="Category">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </div>
                <div class="col-auto d-flex align-items-center gap-3 mx-4 ">
                    <label class="form-label" for="sort-order">
                        Sort
                    </label>
                    <select name="sort-order" class=" form-select " id="sort-order">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-light table-borderless table-responsive border rounded">
        <thead class="table-dark">
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
                        <td class="p-3"> <?= $expense['date'] ?></td>
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
                        <a href="?view=addexpense"> Add Expense</a>
                    </td>
                </tr>
            <?php
            endif;
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">

                    <!-- Total expense -->
                    <div>
                        <?php
                        // CALCULATE ALL EXPENSES
                        $total = 0;
                        foreach ($expenses as $expense) {
                            $total += $expense['amount'];
                        }
                        ?>
                        <div class="alert alert-success" role="alert">
                            Total Expenses: <span class="text-bold"> GHS <?= $total ?></span>
                        </div>
                    </div>
                </td>
                <td colspan="2" >
                        <div class="alert alert-success" role="Alert">
                        Total Expenses for <?= getCurrentMonthName();  ?> : GHS <span class="text-bold"> <?= getTotalExpensesForCurrentMonth($conn) ?></span>

                        </div>
                </td>
                <td colspan="1">
                    <div class="alert alert-success" role="alert">
                        Average Expenses for <?= getCurrentMonthName();  ?> : GHS <span class="text-bold"> <?= calculateMonthAverageExpenses($conn) ?></span>
                    </div>
                </td>

            </tr>

        </tfoot>
    </table>


    <div id="modal"></div>
    <script type="module" src="../src/js/expenses.js"></script>

</div>

<?php
// SHOW  SUCCESS MESSAGE
if (isset($_SESSION['success'])) :
?>
    <div class="toast align-items-center text-white bg-success border-0 position-fixed top-0 mt-4 end-0 mx-4 " role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <?= $_SESSION['success'] ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
<?php
    unset($_SESSION['success']);
endif;
?>