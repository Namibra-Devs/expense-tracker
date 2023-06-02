<!-- Expense view begins -->

<div class="mb-3 border-bottom d-flex align-items-center justify-content-between">
    <h1>Add Expenses</h1>
    <a href="./?view=expenses" class="btn btn-primary d-flex gap-2 align-items-center">
    <i class="fa-solid fa-arrow-left"></i> <span>Back</span></a>
</div>
<div class="container">
    <div class="w-full" style="max-width: 700px; margin-inline: auto">
        <form action="../processes/create.proc.php" method="post">
            <div class="row mb-3">
                <div class="col">
                    <label for="amount" class="form-label">Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">GHS</span>
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="200.00" required>
                    </div>
                </div>
                <div class="col">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" aria-label="Default select example" id="category" name="category" required>
                        <option selected disabled value="" >Select Category</option>
                        <option value="Food">Food</option>
                        <option value="Transportation">Transportation</option>
                        <option value="Clothing">Clothing</option>
                        <option value="Rent">Rent</option>
                        <option value="Utilities">Utilities</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Miscellaneous">Miscellaneous</option>
                    </select>
                </div>

            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control mb-2" id="date" name="date" required>
                <button class="btn btn-outline-secondary" type="button" style="font-size: 13px;" id="pick-today" >Today</button>
                <button class="btn btn-outline-secondary" type="button" style="font-size: 13px;" id="pick-yesterday" >Yesterday</button>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="A short description of the expense. eg. 'New shoes' " required>
                <small id="descriptionHelp" class="form-text text-muted"> 
                    <span class="text-danger">Max 15 characters</span>
                </small>
                <div class="text-muted" style="font-size: 12px;" >
                    <span id="description-count">0</span>/15
                </div>
            </div>
            <button type="submit" name="submit"  class="btn btn-primary w-100">Submit</button>
        </form>

    </div>
</div>
<!-- Expense view ends -->

<!-- Modal for alerts -->
<div id="modal"></div>

<!-- Script for addexpenses -->
<script src="../src/js/addexpenses.js" type="module" ></script>