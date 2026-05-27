<?php
header("Content-Type: application/json");
include('connect.php');

$labour_id = isset($_POST['labour_id']) ? intval($_POST['labour_id']) : 0;
$date = isset($_POST['date']) ? mysqli_real_escape_string($conn, $_POST['date']) : '';

if ($labour_id == 0 || $date == '') {
    echo json_encode(["status" => "error", "message" => "Labour ID and date are required"]);
    exit;
}

$sql = "DELETE FROM labour_attedance WHERE labour_id = $labour_id AND Present_date = '$date'";

if ($conn->query($sql)) {
    echo json_encode(["status" => "success", "message" => "Record deleted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed: " . $conn->error]);
}

$conn->close();
?>
