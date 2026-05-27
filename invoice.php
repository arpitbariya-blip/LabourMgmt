<?php
include('api/connect.php');
include('includes/navbar.php');

// Fetch all invoices with customer and order info
$sql = "WITH repeated_ids AS (
    SELECT i.Customer_id, c.Customer_name, c.Date, i.Invoice_NO, i.Order_ID,
    ROW_NUMBER() OVER (PARTITION BY i.Invoice_NO ORDER BY i.Order_ID) AS row_num
    FROM invoice i
    JOIN customer c ON i.Customer_id = c.Customer_id
)
SELECT ri.Customer_id, ri.Customer_name, ri.Invoice_NO, ri.Order_ID, ri.Date, o.Order_Date
FROM repeated_ids ri
JOIN (
    SELECT Order_NO, Order_Date,
    ROW_NUMBER() OVER (PARTITION BY Order_NO ORDER BY Order_Date) AS order_row_num
    FROM orders
) o ON ri.Order_ID = o.Order_NO
WHERE ri.row_num = 1 AND o.order_row_num = 1
ORDER BY ri.Invoice_NO DESC;";

$result = $conn->query($sql);

// Count stats
$totalInvoices = 0;
$invoiceRows = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $invoiceRows[] = $row;
        $totalInvoices++;
    }
}

// Get total revenue
$revSql = "SELECT COALESCE(SUM(it.Item_qty * it.Item_Per_rate), 0) AS total_revenue
FROM invoice i
JOIN item it ON i.Item_id = it.Item_id";
$revResult = $conn->query($revSql);
$totalRevenue = 0;
if ($revResult && $revRow = $revResult->fetch_assoc()) {
    $totalRevenue = $revRow['total_revenue'];
}

// Get total customers
$custSql = "SELECT COUNT(DISTINCT Customer_id) AS total_customers FROM invoice";
$custResult = $conn->query($custSql);
$totalCustomers = 0;
if ($custResult && $custRow = $custResult->fetch_assoc()) {
    $totalCustomers = $custRow['total_customers'];
}
?>

<!-- Content Canvas -->
<div class="p-10 max-w-7xl mx-auto space-y-10">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <p class="text-secondary font-bold text-xs uppercase tracking-[0.2em]">Billing Center</p>
            <h1 class="text-4xl font-extrabold tracking-tighter text-primary mb-2">Invoice Management</h1>
            <p class="text-on-surface-variant">Create, manage, and track all project invoices.</p>
        </div>
        <div class="flex gap-3">
            <button onclick="document.getElementById('add-invoice-modal').style.display = 'flex'"
                class="px-5 py-2.5 rounded-lg font-semibold text-on-primary bg-primary flex items-center gap-2 shadow-lg shadow-primary/20 hover:opacity-90 transition-opacity active:scale-95">
                <span class="material-symbols-outlined" data-icon="add">add</span>
                New Invoice
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-surface-container-low p-6 rounded-xl space-y-3">
            <span class="text-secondary material-symbols-outlined text-3xl" data-icon="receipt_long">receipt_long</span>
            <div>
                <p class="text-on-surface-variant text-xs font-bold uppercase tracking-wider">Total Invoices</p>
                <p class="text-3xl font-black text-on-surface"><?php echo str_pad($totalInvoices, 2, '0', STR_PAD_LEFT); ?></p>
            </div>
        </div>
        <div class="bg-surface-container-low p-6 rounded-xl space-y-3">
            <span class="text-on-tertiary-container material-symbols-outlined text-3xl" data-icon="groups">groups</span>
            <div>
                <p class="text-on-surface-variant text-xs font-bold uppercase tracking-wider">Customers</p>
                <p class="text-3xl font-black text-on-surface"><?php echo str_pad($totalCustomers, 2, '0', STR_PAD_LEFT); ?></p>
            </div>
        </div>
        <div class="bg-surface-container-low p-6 rounded-xl space-y-3">
            <span class="text-secondary material-symbols-outlined text-3xl" data-icon="payments">payments</span>
            <div>
                <p class="text-on-surface-variant text-xs font-bold uppercase tracking-wider">Total Revenue</p>
                <p class="text-3xl font-black text-on-surface">₹<?php echo number_format($totalRevenue, 0); ?></p>
            </div>
        </div>
        <div class="bg-surface-container-low p-6 rounded-xl space-y-3">
            <span class="text-secondary material-symbols-outlined text-3xl" data-icon="trending_up">trending_up</span>
            <div>
                <p class="text-on-surface-variant text-xs font-bold uppercase tracking-wider">This Month</p>
                <p class="text-3xl font-black text-on-surface"><?php
                    $monthSql = "SELECT COUNT(DISTINCT i.Invoice_NO) AS cnt FROM invoice i JOIN customer c ON i.Customer_id = c.Customer_id WHERE DATE_FORMAT(c.Date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')";
                    $monthResult = $conn->query($monthSql);
                    $monthCount = 0;
                    if ($monthResult && $mRow = $monthResult->fetch_assoc()) { $monthCount = $mRow['cnt']; }
                    echo str_pad($monthCount, 2, '0', STR_PAD_LEFT);
                ?></p>
            </div>
        </div>
    </div>

    <!-- Invoice Table -->
    <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden border border-outline-variant/10">
        <div class="px-6 py-4 border-b border-outline-variant/10 flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
            <div class="flex items-center gap-4">
                <span class="font-headline font-bold text-on-surface text-lg">All Invoices</span>
                <div class="flex items-center gap-2 bg-surface-container-low px-3 py-1 rounded-full text-[10px] font-bold text-on-surface-variant uppercase">
                    <span class="w-1.5 h-1.5 bg-secondary rounded-full"></span>
                    <?php echo $totalInvoices; ?> Records
                </div>
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <div class="relative flex-1 md:w-64">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg" data-icon="search">search</span>
                    <input id="invoice-search"
                        class="w-full pl-10 pr-4 py-2 bg-surface-container-lowest border-outline-variant/30 rounded-lg text-sm focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all"
                        placeholder="Search invoices..." type="text" onkeyup="filterInvoices()" />
                </div>
                <button class="bg-surface-container-low p-2 rounded-lg text-on-surface hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined" data-icon="filter_list">filter_list</span>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="invoice-table">
                <thead>
                    <tr class="bg-surface-container-low/50">
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">SR No</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Invoice No</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Customer</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Invoice Date</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Order No</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">Order Date</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/5">
                    <?php
                    if (count($invoiceRows) > 0) {
                        $i = 1;
                        foreach ($invoiceRows as $row) {
                            echo "<tr class='group hover:bg-surface-container-low/30 transition-colors invoice-row'>";
                            echo "<td class='px-6 py-5'>
                                    <span class='font-mono text-xs font-medium text-on-surface-variant'>" . $i++ . "</span>
                                  </td>";
                            echo "<td class='px-6 py-5'>
                                    <div class='flex items-center gap-3'>
                                        <div class='w-10 h-10 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary'>
                                            <span class='material-symbols-outlined' data-icon='receipt'>receipt</span>
                                        </div>
                                        <span class='font-headline font-bold text-primary'>#INV-" . str_pad($row["Invoice_NO"], 4, '0', STR_PAD_LEFT) . "</span>
                                    </div>
                                  </td>";
                            echo "<td class='px-6 py-5'>
                                    <div class='flex items-center gap-3'>
                                        <div class='w-8 h-8 rounded-full bg-primary-container text-[10px] flex items-center justify-center text-white font-bold'>"
                                        . strtoupper(substr($row["Customer_name"], 0, 2)) .
                                        "</div>
                                        <span class='text-sm font-semibold text-on-surface'>" . htmlspecialchars($row["Customer_name"]) . "</span>
                                    </div>
                                  </td>";
                            echo "<td class='px-6 py-5 text-sm text-on-surface-variant font-medium'>" . $row["Date"] . "</td>";
                            echo "<td class='px-6 py-5'>
                                    <span class='inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-secondary-fixed text-on-secondary-fixed-variant'>
                                        ORD-" . $row["Order_ID"] . "
                                    </span>
                                  </td>";
                            echo "<td class='px-6 py-5 text-sm text-on-surface-variant font-medium'>" . $row["Order_Date"] . "</td>";
                            echo "<td class='px-6 py-5 text-right'>
                                    <div class='flex justify-end gap-2'>
                                        <a href='invoice_main?invoice_no=" . $row["Invoice_NO"] . "&OD=" . $row["Order_Date"] . "'
                                           class='p-2 text-secondary hover:bg-secondary/10 rounded-lg transition-colors inline-flex items-center gap-1 text-xs font-bold'>
                                            <span class='material-symbols-outlined text-lg' data-icon='visibility'>visibility</span>
                                            View
                                        </a>
                                        <a href='api/delete_invoice?Invoice_NO=" . $row["Invoice_NO"] . "&Order_NO=" . $row["Order_ID"] . "&customer_id=" . $row["Customer_id"] . "'
                                           class='p-2 text-error hover:bg-error/10 rounded-lg transition-colors inline-flex items-center gap-1 text-xs font-bold'
                                           onclick=\"return confirm('Are you sure you want to delete this invoice?');\">
                                            <span class='material-symbols-outlined text-lg' data-icon='delete'>delete</span>
                                            Delete
                                        </a>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='px-6 py-12 text-center text-on-surface-variant'>
                                <div class='flex flex-col items-center gap-3'>
                                    <span class='material-symbols-outlined text-4xl opacity-30' data-icon='receipt_long'>receipt_long</span>
                                    <p class='font-semibold'>No invoices found</p>
                                    <p class='text-sm'>Create your first invoice to get started.</p>
                                </div>
                              </td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="px-6 py-4 bg-surface-container-low/30 border-t border-outline-variant/10 flex justify-between items-center">
            <p class="text-[11px] font-medium text-on-surface-variant">Showing <?php echo $totalInvoices; ?> of <?php echo $totalInvoices; ?> invoices</p>
            <div class="flex gap-2">
                <button class="px-3 py-1.5 border border-outline-variant/20 rounded text-xs font-bold text-on-surface hover:bg-surface-container transition-colors disabled:opacity-30" disabled>Previous</button>
                <button class="px-3 py-1.5 border border-outline-variant/20 rounded text-xs font-bold text-on-surface hover:bg-surface-container transition-colors">Next</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Invoice Modal -->
<div class="fixed inset-0 z-[100] flex items-center justify-center bg-primary/40 backdrop-blur-sm px-4"
    id="add-invoice-modal" style="display:none;">
    <div class="bg-surface-container-lowest w-full max-w-lg rounded-xl shadow-2xl ring-1 ring-on-surface/5 overflow-hidden">
        <div class="px-8 py-6 border-b border-outline-variant/10 flex justify-between items-center">
            <h3 class="text-xl font-bold font-headline text-on-surface">Create New Invoice</h3>
            <button class="p-1 hover:bg-surface-container rounded-full transition-colors text-on-surface-variant"
                onclick="document.getElementById('add-invoice-modal').style.display = 'none'">
                <span class="material-symbols-outlined" data-icon="close">close</span>
            </button>
        </div>
        <form class="p-8 space-y-6" action="api/create_invoice" method="POST">
            <!-- Customer Selection -->
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-[0.1em] text-on-surface-variant ml-1">Select Customer</label>
                <select name="customer_id" required
                    class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/40 transition-all outline-none">
                    <option value="">-- Select Customer --</option>
                    <?php
                    $custListSql = "SELECT Customer_id, Customer_name FROM customer ORDER BY Customer_name";
                    $custListResult = $conn->query($custListSql);
                    if ($custListResult) {
                        while ($c = $custListResult->fetch_assoc()) {
                            echo "<option value='" . $c['Customer_id'] . "'>" . htmlspecialchars($c['Customer_name']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <!-- Item Selection -->
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-[0.1em] text-on-surface-variant ml-1">Select Item</label>
                <select name="item_id" required
                    class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/40 transition-all outline-none">
                    <option value="">-- Select Item --</option>
                    <?php
                    $itemListSql = "SELECT Item_id, Item_name, Item_Per_rate FROM item ORDER BY Item_name";
                    $itemListResult = $conn->query($itemListSql);
                    if ($itemListResult) {
                        while ($it = $itemListResult->fetch_assoc()) {
                            echo "<option value='" . $it['Item_id'] . "'>" . htmlspecialchars($it['Item_name']) . " (₹" . $it['Item_Per_rate'] . ")</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <!-- Order ID -->
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-[0.1em] text-on-surface-variant ml-1">Order Number</label>
                <select name="order_id" required
                    class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/40 transition-all outline-none">
                    <option value="">-- Select Order --</option>
                    <?php
                    $orderListSql = "SELECT Order_NO, Order_Date FROM orders ORDER BY Order_Date DESC";
                    $orderListResult = $conn->query($orderListSql);
                    if ($orderListResult) {
                        while ($o = $orderListResult->fetch_assoc()) {
                            echo "<option value='" . $o['Order_NO'] . "'>ORD-" . $o['Order_NO'] . " (" . $o['Order_Date'] . ")</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <!-- Invoice Number -->
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase tracking-[0.1em] text-on-surface-variant ml-1">Invoice Number</label>
                <input name="invoice_no" type="number" required
                    class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-secondary/40 transition-all outline-none"
                    placeholder="e.g. 101" />
            </div>
            <!-- Buttons -->
            <div class="flex gap-3 pt-2">
                <button type="button"
                    class="flex-1 py-4 px-6 rounded-lg bg-surface-container-low text-primary font-bold hover:bg-surface-container-high transition-colors"
                    onclick="document.getElementById('add-invoice-modal').style.display = 'none'">Cancel</button>
                <button type="submit"
                    class="flex-1 py-4 px-6 rounded-lg bg-gradient-to-br from-primary to-primary-container text-on-primary font-bold shadow-lg shadow-primary/20 active:scale-95 transition-all">
                    Create Invoice
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Search Filter Script -->
<script>
function filterInvoices() {
    var input = document.getElementById('invoice-search').value.toLowerCase();
    var rows = document.querySelectorAll('.invoice-row');
    rows.forEach(function(row) {
        var text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
}
</script>

</main>
</body>
</html>
