<?php
require_once 'auxiliaries.php';
require_once 'config.php';

$expenses = getExpenses($conn);

?>


<div class="mb-3 border-bottom">
    <h1>Expenses</h1>
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
    <table class="table">
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
                        <td>GHS <?= $expense['date'] ?></td>
                        <td>GHS <?= $expense['description'] ?></td>
                        <td>GHS <?= $expense['category'] ?></td>
                        <td>
                            <a href="#" class="btn btn-primary">Edit</a>
                            <button class="btn btn-danger delBtn" data-expId="<?= $expense['id'] ?>" >Delete</button>
                        </td>
                    </tr>
                <?php
                endforeach;
            else :
                ?>
                <tr>
                    <td colspan="5">No expenses found</td>
                </tr>
            <?php
            endif;
            ?>
        </tbody>
    </table>


    <script type="module" >
        import Alert from '/src/js/Alert.js';

        const delBtns = document.querySelectorAll('.delBtn');
        delBtns.forEach(btn => {
            btn.addEventListener('click', (e)=>{
                console.log(e.target.dataset.expId);
            })
        })


    </script>
</div>
