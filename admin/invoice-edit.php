<?php
include("config/database.php");
?>

<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Invoices</div>
                <h2 class="page-title">Show</h2>
            </div>
        </div>
    </div>
</div>

<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Period</th>
                                <th>Supply (€)</th>
                                <th>Total (€)</th>
                                <th>VAT (€)</th>
                                <th class="w-1">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $result = $db->query("SELECT * FROM invoices ORDER BY id DESC");
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                                    <td><?= htmlspecialchars($row['period']) ?></td>
                                    <td><?= number_format($row['supply_cost'], 2) ?></td>
                                    <td><?= number_format($row['total'], 2) ?></td>
                                    <td><?= number_format($row['vat'], 2) ?></td>
                                    <td>
                                        <a href="generate-invoice.php?id=<?= $row['id'] ?>" target="_blank" class="btn btn-sm btn-primary">View PDF</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if ($result->num_rows === 0): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No invoices found.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="./dist/libs/list.js/dist/list.min.js?1692870487" defer></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const list = new List('table-default', {
            sortClass: 'table-sort',
            listClass: 'table-tbody',
            valueNames: ['sort-name', 'sort-period', 'sort-total']
        });
    })
</script>

<?php include('footer.php'); ?>
