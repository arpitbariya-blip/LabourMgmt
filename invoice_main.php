<?php
include('api/connect.php');

if (!isset($_GET['invoice_no'])) {
    header("location:invoice");
    exit;
}

$invoiceID = intval($_GET['invoice_no']);
$OD = isset($_GET['OD']) ? $_GET['OD'] : '';

// Fetch customer & order info for this invoice
$stmt = $conn->prepare("SELECT DISTINCT c.Customer_id, c.Customer_name, c.Date, c.Customer_address, c.Customer_mobile_no, i.Order_ID
    FROM invoice i
    JOIN customer c ON i.Customer_id = c.Customer_id
    WHERE i.Invoice_NO = ?");
$stmt->bind_param("i", $invoiceID);
$stmt->execute();
$res = $stmt->get_result();

$CID = 0;
$customerDate = '';
$customerName = '';
$customerAddress = '';
$customerMobile = '';
$orderID = '';

if ($row = $res->fetch_assoc()) {
    $CID = $row['Customer_id'];
    $customerDate = $row['Date'];
    $customerName = $row['Customer_name'];
    $customerAddress = $row['Customer_address'];
    $customerMobile = isset($row['Customer_mobile_no']) ? $row['Customer_mobile_no'] : '';
    $orderID = $row['Order_ID'];
}
$stmt->close();

// Fetch line items
$itemStmt = $conn->prepare("SELECT it.Item_name, it.Item_qty, it.Item_Per_rate, (it.Item_qty * it.Item_Per_rate) AS item_total
    FROM invoice i
    JOIN item it ON i.Item_id = it.Item_id
    WHERE i.Invoice_NO = ? AND i.Customer_id = ?
    ORDER BY it.Item_name");
$itemStmt->bind_param("ii", $invoiceID, $CID);
$itemStmt->execute();
$itemResult = $itemStmt->get_result();

$items = [];
$totalAmount = 0;
while ($itemRow = $itemResult->fetch_assoc()) {
    $items[] = $itemRow;
    $totalAmount += $itemRow['item_total'];
}
$itemStmt->close();

// Number to words function (Indian system)
function numberToWords($n)
{
    $ones = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine');
    $teens = array('Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen');
    $tens = array('', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety');

    if ($n == 0) return 'Zero';
    if ($n < 0) return 'Minus ' . numberToWords(-$n);

    $n = intval($n);

    if ($n < 10) {
        return $ones[$n];
    } elseif ($n < 20) {
        return $teens[$n - 10];
    } elseif ($n < 100) {
        $result = $tens[(int)floor($n / 10)];
        if ($n % 10 > 0) $result .= ' ' . $ones[$n % 10];
        return $result;
    } elseif ($n < 1000) {
        $result = $ones[(int)floor($n / 100)] . ' Hundred';
        if ($n % 100 > 0) $result .= ' and ' . numberToWords($n % 100);
        return $result;
    } elseif ($n < 100000) {
        $result = numberToWords((int)floor($n / 1000)) . ' Thousand';
        if ($n % 1000 > 0) $result .= ' ' . numberToWords($n % 1000);
        return $result;
    } elseif ($n < 10000000) {
        $result = numberToWords((int)floor($n / 100000)) . ' Lakh';
        if ($n % 100000 > 0) $result .= ' ' . numberToWords($n % 100000);
        return $result;
    } else {
        $result = numberToWords((int)floor($n / 10000000)) . ' Crore';
        if ($n % 10000000 > 0) $result .= ' ' . numberToWords($n % 10000000);
        return $result;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Invoice #INV-<?php echo str_pad($invoiceID, 4, '0', STR_PAD_LEFT); ?> - Architect Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-tertiary-fixed-variant": "#564427",
                        "inverse-on-surface": "#eaf1ff",
                        "on-primary-fixed": "#111c2d",
                        "secondary": "#0058be",
                        "on-primary-fixed-variant": "#3c475a",
                        "surface-container": "#e5eeff",
                        "surface-dim": "#cbdbf5",
                        "surface-container-highest": "#d3e4fe",
                        "on-tertiary-container": "#a38c6a",
                        "error": "#ba1a1a",
                        "tertiary-container": "#35260c",
                        "secondary-fixed": "#d8e2ff",
                        "surface-tint": "#545f73",
                        "on-surface-variant": "#45474c",
                        "primary": "#091426",
                        "on-background": "#0b1c30",
                        "surface-bright": "#f8f9ff",
                        "on-secondary": "#ffffff",
                        "surface-variant": "#d3e4fe",
                        "on-secondary-fixed": "#001a42",
                        "on-error-container": "#93000a",
                        "on-surface": "#0b1c30",
                        "tertiary-fixed-dim": "#ddc39d",
                        "outline": "#75777d",
                        "primary-container": "#1e293b",
                        "on-secondary-container": "#fefcff",
                        "inverse-surface": "#213145",
                        "error-container": "#ffdad6",
                        "secondary-fixed-dim": "#adc6ff",
                        "surface-container-high": "#dce9ff",
                        "primary-fixed-dim": "#bcc7de",
                        "on-secondary-fixed-variant": "#004395",
                        "on-primary": "#ffffff",
                        "surface-container-low": "#eff4ff",
                        "secondary-container": "#2170e4",
                        "background": "#f8f9ff",
                        "outline-variant": "#c5c6cd",
                        "surface": "#f8f9ff",
                        "on-error": "#ffffff",
                        "primary-fixed": "#d8e3fb",
                        "on-tertiary-fixed": "#271902",
                        "inverse-primary": "#bcc7de",
                        "tertiary": "#1e1200",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed": "#fadfb8",
                        "on-tertiary": "#ffffff",
                        "on-primary-container": "#8590a6"
                    },
                    fontFamily: {
                        "headline": ["Manrope", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                        "label": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Manrope', sans-serif;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .print-area {
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
</head>

<body class="bg-surface text-on-surface min-h-screen">
    <!-- Top Action Bar (No Print) -->
    <div class="no-print sticky top-0 z-50 bg-slate-50/80 backdrop-blur-xl shadow-sm">
        <div class="max-w-5xl mx-auto px-8 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="invoice" class="p-2 hover:bg-slate-200/50 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-primary" data-icon="arrow_back">arrow_back</span>
                </a>
                <div>
                    <h2 class="text-lg font-bold tracking-tighter text-primary">Invoice #INV-<?php echo str_pad($invoiceID, 4, '0', STR_PAD_LEFT); ?></h2>
                    <p class="text-xs text-on-surface-variant">Generated on <?php echo date('M d, Y'); ?></p>
                </div>
            </div>
            <div class="flex gap-3">
                <button onclick="window.print()"
                    class="px-5 py-2.5 rounded-lg font-semibold text-secondary bg-secondary-fixed flex items-center gap-2 hover:bg-secondary-fixed-dim transition-colors">
                    <span class="material-symbols-outlined" data-icon="print">print</span>
                    Print Invoice
                </button>
                <a href="invoice"
                    class="px-5 py-2.5 rounded-lg font-semibold text-on-surface-variant bg-surface-container-low flex items-center gap-2 hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined" data-icon="list">list</span>
                    All Invoices
                </a>
            </div>
        </div>
    </div>

    <!-- Invoice Content -->
    <div class="max-w-5xl mx-auto p-8">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden print-area" id="print-area">
            <!-- Invoice Header -->
            <div class="bg-primary text-on-primary px-10 py-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-48 h-48 bg-secondary opacity-10 -mr-24 -mt-24 rounded-full blur-3xl"></div>
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <h1 class="text-3xl font-black tracking-tighter">Architect Admin</h1>
                        <p class="text-on-primary-container text-sm mt-1">Management Suite</p>
                    </div>
                    <div class="text-right">
                        <h2 class="text-4xl font-black tracking-tighter opacity-90">INVOICE</h2>
                        <p class="text-on-primary-container text-lg font-bold">#INV-<?php echo str_pad($invoiceID, 4, '0', STR_PAD_LEFT); ?></p>
                    </div>
                </div>
            </div>

            <!-- Invoice Details -->
            <div class="px-10 py-8">
                <div class="grid grid-cols-2 gap-10 mb-10">
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary text-sm" data-icon="person">person</span>
                            Billed To
                        </h4>
                        <p class="font-bold text-xl text-primary"><?php echo htmlspecialchars($customerName); ?></p>
                        <?php if ($customerAddress): ?>
                            <p class="text-on-surface-variant mt-1"><?php echo htmlspecialchars($customerAddress); ?></p>
                        <?php endif; ?>
                        <?php if ($customerMobile): ?>
                            <p class="text-on-surface-variant">Tel: <?php echo htmlspecialchars($customerMobile); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="text-right">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-3 flex items-center justify-end gap-2">
                            <span class="material-symbols-outlined text-secondary text-sm" data-icon="info">info</span>
                            Invoice Details
                        </h4>
                        <div class="space-y-1">
                            <p class="text-primary"><span class="font-bold">Invoice No:</span> <?php echo $invoiceID; ?></p>
                            <p class="text-primary"><span class="font-bold">Order No:</span> <?php echo htmlspecialchars($orderID); ?></p>
                            <p class="text-primary"><span class="font-bold">Invoice Date:</span> <?php echo $customerDate; ?></p>
                            <?php if ($OD): ?>
                                <p class="text-primary"><span class="font-bold">Order Date:</span> <?php echo htmlspecialchars($OD); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Line Items Table -->
                <div class="border border-outline-variant/20 rounded-xl overflow-hidden mb-8">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-surface-container-low/50">
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-on-surface-variant">SR</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-on-surface-variant">Item Name</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-widest text-on-surface-variant">Rate</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-widest text-on-surface-variant">Qty</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-widest text-on-surface-variant">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10">
                            <?php
                            $sr = 1;
                            foreach ($items as $item) {
                                echo "<tr class='hover:bg-surface-container-low/30 transition-colors'>";
                                echo "<td class='px-6 py-4 text-sm font-medium text-on-surface-variant'>" . $sr++ . "</td>";
                                echo "<td class='px-6 py-4 text-sm font-semibold text-primary'>" . htmlspecialchars($item['Item_name']) . "</td>";
                                echo "<td class='px-6 py-4 text-sm text-right text-on-surface-variant'>₹" . number_format($item['Item_Per_rate'], 2) . "</td>";
                                echo "<td class='px-6 py-4 text-sm text-right text-on-surface-variant'>" . rtrim(rtrim($item['Item_qty'], '0'), '.') . "</td>";
                                echo "<td class='px-6 py-4 text-sm text-right font-bold text-primary'>₹" . number_format($item['item_total'], 2) . "</td>";
                                echo "</tr>";
                            }

                            if (count($items) === 0) {
                                echo "<tr><td colspan='5' class='px-6 py-8 text-center text-on-surface-variant'>No items found for this invoice.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Totals Section -->
                <div class="flex justify-end mb-8">
                    <div class="w-80 space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-on-surface-variant">Subtotal</span>
                            <span class="font-bold text-primary">₹<?php echo number_format($totalAmount, 2); ?></span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-on-surface-variant">CST/GST (0%)</span>
                            <span class="font-bold text-primary">₹0.00</span>
                        </div>
                        <div class="border-t border-outline-variant/20 pt-3 flex justify-between items-center">
                            <span class="text-lg font-bold text-primary">Grand Total</span>
                            <span class="text-2xl font-black text-primary">₹<?php echo number_format($totalAmount, 2); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Amount in Words -->
                <div class="bg-surface-container-low/50 rounded-xl px-6 py-4 mb-8">
                    <p class="text-sm">
                        <span class="font-bold text-primary">Amount in Words:</span>
                        <span class="text-on-surface-variant italic"><?php echo numberToWords($totalAmount); ?> Rupees Only</span>
                    </p>
                </div>

                <!-- Footer -->
                <div class="border-t border-outline-variant/20 pt-8">
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-3">Terms & Conditions</h4>
                            <ul class="text-xs text-on-surface-variant space-y-1">
                                <li>1. No claims will be recognized unless notified in writing within 2 days after receipt of goods.</li>
                                <li>2. Payment should be made by A/c Payee / Draft only.</li>
                                <li>3. Subject to local jurisdiction.</li>
                            </ul>
                        </div>
                        <div class="text-right">
                            <h4 class="text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-3">For, Architect Admin</h4>
                            <div class="mt-12 pt-3 border-t border-outline-variant/30 inline-block min-w-[200px]">
                                <p class="text-xs font-bold text-on-surface-variant">Authorized Signature</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printInvoice() {
            window.print();
        }
    </script>
</body>

</html>
<?php $conn->close(); ?>