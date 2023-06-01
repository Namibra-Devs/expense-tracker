<aside class=" bg-primary p-3 h-100" style="width: 300px" id="sidebar">
    <div class="d-flex flex-column gap-4">
        <a href="?view=overview" class="hover-primary text-decoration-none p-2 rounded-2 <?= activateLink($view, 'overview') ?>">Overview</a>
        <a href="?view=expenses" class=" text-decoration-none p-2 rounded-2 <?= activateLink($view, 'expenses') ?>">Expenses</a>
    </div>
</aside>