<?php
// require_once "../../config/db.php";
// require_once "../../middleware/AuthMiddleware.php";

// AuthMiddleware::checkRole(['admin']);

// $data = json_decode(file_get_contents("php://input"), true);

// $stmt = $conn->prepare("INSERT INTO records (user_id,amount,type,category,date,notes) VALUES (?,?,?,?,?,?)");
// $stmt->bind_param("idssss",
//     $_SESSION['user']['id'],
//     $data['amount'],
//     $data['type'],
//     $data['category'],
//     $data['date'],
//     $data['notes']
// );
// $stmt->execute();

// echo json_encode(["message"=>"Record created"]);
?>
<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "finance_dashboard");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB Connection Failed"]);
    exit;
}

// Get POST data
$full_name = $_POST['full_name'] ?? '';
$email = $_POST['email'] ?? '';
$role = $_POST['role'] ?? '';
$status = $_POST['status'] ?? '';

// Validation
if ($full_name == '' || $email == '') {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit;
}

// Insert
$stmt = $conn->prepare("INSERT INTO users (full_name, email, role, status) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $full_name, $email, $role, $status);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User created successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to insert"]);
}

$stmt->close();
$conn->close();
?>