<?php
header("Content-Type: application/json");
include('connect.php');

$labour_id = isset($_POST['labour_id']) ? intval($_POST['labour_id']) : 0;
$type = isset($_POST['type']) ? $_POST['type'] : '';
$amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
$date = isset($_POST['date']) ? mysqli_real_escape_string($conn, $_POST['date']) : '';

if ($labour_id == 0 || $amount == 0 || $date == '' || $type == '') {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit;
}

// Check if attendance record exists for this date
$checkSql = "SELECT * FROM labour_attedance WHERE labour_id = $labour_id AND Present_date = '$date'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows > 0) {
    // Update existing record
    if ($type == 'OT') {
        $sql = "UPDATE labour_attedance SET OT = OT + $amount WHERE labour_id = $labour_id AND Present_date = '$date'";
    } else {
        $sql = "UPDATE labour_attedance SET withdrawal = withdrawal + $amount WHERE labour_id = $labour_id AND Present_date = '$date'";
    }
} else {
    // Insert new record with attendance = 0
    if ($type == 'OT') {
        $sql = "INSERT INTO labour_attedance (labour_id, Present_date, attendance, OT, withdrawal) VALUES ($labour_id, '$date', 0, $amount, 0)";
    } else {
        $sql = "INSERT INTO labour_attedance (labour_id, Present_date, attendance, OT, withdrawal) VALUES ($labour_id, '$date', 0, 0, $amount)";
    }
}

if ($conn->query($sql)) {
    echo json_encode(["status" => "success", "message" => "Record saved successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed: " . $conn->error]);
}

$conn->close();
?>
