<?php
    require_once 'config.php';

?>
<div class="mb-3 border-bottom d-flex align-items-center justify-content-between">
    <h1 class="text-bold" >Overview</h1>
    <!-- <a href="?view=addexpense" class="btn btn-primary"> Add Expense</a> -->
</div>
<section class="container">
    <div class="row mb-3 w-full bg-light shadow-lg p-3 mt-4" style=" border-radius: 10px">
        <div class="border-bottom pb-3" >
            <h2 class="fs-4 m-0" >Total Expenses</h2>
            <h3 class="m-0 fs-1 text-bold" >GHS <?= number_format(calculateAllExpenses($conn), 2, '.','') ?></h3>
            <small><?= date('M d, Y') ?></small>
        </div>
        <div class="col-12 w-full" style="height: 500px;">
            <canvas id="chart"></canvas>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../src/js/chart.js"></script>
