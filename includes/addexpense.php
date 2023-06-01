<div>
    <h1>Add Expenses</h1>
</div>
<div class="container">
    <div class="w-full" style="max-width: 700px; margin-inline: auto">
        <form action="../processes/create.proc.php" method="post">
            <div class="row mb-3">
                <div class="col">
                    <label for="amount" class="form-label">Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">GHS</span>
                        <input type="number" class="form-control" id="amount" name="amount" required>
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
                <input type="text" class="form-control" id="description" name="description" required>
                <small id="descriptionHelp" class="form-text text-muted">A short description of the expense. eg. "New shoes"  <br>
                    <span class="text-danger">Max 15 characters</span>
                </small>
                <div class="text-muted" style="font-size: 12px;" >
                    <span id="description-count">0</span>/15
                </div>
            </div>
            <button type="submit" name="submit"  class="btn btn-primary">Submit</button>
        </form>

    </div>
</div>
<div id="modal"></div>
<script src="../src/js/addexpenses.js" type="module" ></script>