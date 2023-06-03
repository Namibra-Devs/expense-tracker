<!-- SIDEBAR BEGINS -->
<aside class=" bg-primary p-3 h-100" style="width: 300px" id="sidebar">
    <h3 class="text-white text-bold mb-4 border-bottom pb-3">Expense Tracker</h3>
    <div class="d-flex flex-column gap-4">
        <a href="?view=overview" class="hover-primary text-decoration-none p-2 rounded-3 <?= activateLink($view, 'overview') ?>">Overview</a>
        <a href="?view=expenses" class=" text-decoration-none p-2 rounded-3 <?= activateLink($view, 'expenses') ?>">Expenses</a>
    </div>
</aside>
<!-- SIDEBAR ENDS -->