<?php
include('connect.php');

// Get POST data
$customer_id = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : 0;
$item_id     = isset($_POST['item_id']) ? intval($_POST['item_id']) : 0;
$order_id    = isset($_POST['order_id']) ? mysqli_real_escape_string($conn, $_POST['order_id']) : '';
$invoice_no  = isset($_POST['invoice_no']) ? intval($_POST['invoice_no']) : 0;

// Validation
if ($customer_id == 0 || $item_id == 0 || $order_id == '' || $invoice_no == 0) {
    echo "<script>alert('All fields are required.'); window.history.back();</script>";
    exit;
}

// Check if invoice number already exists with same order
$checkSql = "SELECT invoice_id FROM invoice WHERE Invoice_no = ? AND Order_ID = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("is", $invoice_no, $order_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    echo "<script>alert('This invoice already exists for the selected order.'); window.history.back();</script>";
    $checkStmt->close();
    exit;
}
$checkStmt->close();

// Insert invoice
$stmt = $conn->prepare("INSERT INTO invoice (Invoice_no, Customer_id, Item_id, Order_ID) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiis", $invoice_no, $customer_id, $item_id, $order_id);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: ../invoice.php");
    exit;
} else {
    echo "<script>alert('Failed to create invoice: " . addslashes($conn->error) . "'); window.history.back();</script>";
    $stmt->close();
    $conn->close();
    exit;
}
?>
