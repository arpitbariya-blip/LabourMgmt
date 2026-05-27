<?php
include('connect.php');

header('Content-Type: application/json');

$labour_id = isset($_POST['labour_id']) ? intval($_POST['labour_id']) : 0;
$month = isset($_POST['month']) ? $_POST['month'] : '';

if (!$labour_id || !$month) {
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
    exit;
}

// Get labour info
$stmt = $conn->prepare("SELECT labour_name, salary FROM labour WHERE labour_id = ?");
$stmt->bind_param("i", $labour_id);
$stmt->execute();
$labourResult = $stmt->get_result();
$labourInfo = $labourResult->fetch_assoc();
$stmt->close();

if (!$labourInfo) {
    echo json_encode(['status' => 'error', 'message' => 'Labour not found']);
    exit;
}

// Get salary summary for the month
$stmt = $conn->prepare("
    SELECT 
        COUNT(*) as total_days,
        SUM(la.attendance) as days_present,
        SUM(l.salary * la.attendance) as base_salary,
        SUM(la.OT) as total_ot,
        SUM(la.withdrawal) as total_withdrawal,
        SUM(l.salary * la.attendance) + SUM(la.OT) - SUM(la.withdrawal) as net_pay
    FROM labour l 
    INNER JOIN labour_attedance la ON l.labour_id = la.labour_id 
    WHERE l.labour_id = ? AND DATE_FORMAT(la.Present_date, '%Y-%m') = ?
");
$stmt->bind_param("is", $labour_id, $month);
$stmt->execute();
$result = $stmt->get_result();
$summary = $result->fetch_assoc();
$stmt->close();

echo json_encode([
    'status' => 'success',
    'data' => [
        'labour_name' => $labourInfo['labour_name'],
        'daily_rate' => floatval($labourInfo['salary']),
        'days_present' => intval($summary['days_present'] ?? 0),
        'total_days' => intval($summary['total_days'] ?? 0),
        'base_salary' => floatval($summary['base_salary'] ?? 0),
        'total_ot' => floatval($summary['total_ot'] ?? 0),
        'total_withdrawal' => floatval($summary['total_withdrawal'] ?? 0),
        'net_pay' => floatval($summary['net_pay'] ?? 0)
    ]
]);

$conn->close();
