<?php
include('api/connect.php');

$attendanceData = $_POST['attendance_data'];
$attendanceDate = $_POST['attendance_date'];

foreach ($attendanceData as $data) {
    $labourId = intval($data['labour_id']);
    $attendanceValue = intval($data['attendance']);
    $attendanceDate = mysqli_real_escape_string($conn, $attendanceDate);

    $checkQuery = "SELECT attendance FROM `labour_attedance` WHERE `labour_id` = '$labourId' AND `Present_date` = '$attendanceDate'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        $query = "INSERT INTO `labour_attedance`(`labour_id`, `Present_date`, `attendance`) VALUES ('$labourId', '$attendanceDate','$attendanceValue')";
        mysqli_query($conn, $query);
    } else {
        $query = "UPDATE `labour_attedance` SET `attendance` = '$attendanceValue' WHERE `labour_id` = '$labourId' AND `Present_date` = '$attendanceDate'";
        mysqli_query($conn, $query);
    }
}

echo "1";
