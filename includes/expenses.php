<?php
require_once 'auxiliaries.php';
require_once 'config.php';

$expenses = getExpenses($conn); // GET ALL EXPENSES FROM DATABASE
?>


<div class="mb-3 border-bottom d-flex align-items-center justify-content-between" >
    <h1>Expenses</h1>
    <a href="#" class="btn btn-primary"> Add Expense</a>
</div>
<!-- <a href="../processes/delete.proc.php">Click</a> -->
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
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
                <th scope="col">Description</th>
                <th scope="col">Category</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($expenses) > 0) :
                foreach ($expenses as $expense) :
            ?>
                    <tr>
                        <td>GHS <?= $expense['amount'] ?></td>
                        <td> <?= $expense['date'] ?></td>
                        <td> <?= $expense['description'] ?></td>
                        <td> <?= $expense['category'] ?></td>
                        <td>
                            <a href="#" class="btn btn-primary">Edit</a>
                            <button class="btn btn-primary delBtn" data-expenseId="<?= $expense['id'] ?>">Delete</button>
                        </td>
                    </tr>
                <?php
                endforeach;
            else :
                ?>
                <tr>
                    <td colspan="5" class="text-center text-secondary p-3">No expenses found
                        <a href="#" > Add Expense</a>
                    </td>
                </tr>
            <?php
            endif;
            ?>
        </tbody>
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