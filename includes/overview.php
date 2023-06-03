<?php
require_once 'config.php';

?>
<div class="mb-3 border-bottom d-flex align-items-center justify-content-between">
    <h1 class="text-bold">Overview</h1>
    <!-- <a href="?view=addexpense" class="btn btn-primary"> Add Expense</a> -->
</div>
<section class="container">
    <div class="row mb-4 w-full bg-light border p-3 mt-4" style=" border-radius: 10px">
        <div class="d-flex align-items-center border-bottom pb-3">
            <div>
                <h2 class="fs-4 m-0">Total Expenses</h2>
                <h3 class="m-0 fs-1 text-bold">GHS <?= number_format(calculateAllExpenses($conn), 2, '.', '') ?></h3>
                <small><?= date('M d, Y') ?></small>
            </div>
            <div class="ms-auto">
                <a href="?view=addexpense" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Expense"><i class="fas fa-plus"></i></a>
                <a href="?view=expenses" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View All">View Expenses</a>
            </div>
        </div>
        <div class="col-12 w-full" style="height: 500px;">
            <canvas id="chart"></canvas>
        </div>
    </div>

    <div class="row mb-3 gap-3 justify-content-between">
        <div class="col-3 bg-light p-3 rounded-3 border">
            <div>
                <h2 class="fs-5 m-0">Average Expenses </h2>
                <small><?= date('F') ?></small>
                <h3 class="m-0 fs-2 text-bold">GHS <?= number_format(calculateMonthAverageExpenses($conn), 2, '.', '') ?></h3>
            </div>
        </div>
        <div class="col-3 bg-light rounded-3 p-3 border">
            <div>
                <h2 class="fs-5 m-0">Total Expenses </h2>
                <small><?= date('F') ?></small>
                <h3 class="m-0 fs-2 text-bold">GHS <?= number_format(getTotalExpensesForCurrentMonth($conn), 2, '.', '') ?></h3>
            </div>
        </div>
        <div class="col-3 p-3 rounded-3 bg-white border">
            <div>
                <h2 class="fs-5 m-0">Total Expenses </h2>
                <small><?= date('Y') ?></small>
                <h3 class="m-0 fs-2 text-bold">GHS <?= number_format(getTotalExpensesForCurrentYear($conn), 2, '.', '') ?></h3>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../src/js/chart.js"></script>