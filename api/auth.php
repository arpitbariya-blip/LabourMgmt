<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mht_id = isset($_POST['mht_id']) ? trim($_POST['mht_id']) : '';

    if (empty($mht_id)) {
        header("Location: ../login.php?error=MHT ID is required");
        exit();
    }

    $csvFile = '../users.csv';
    $authenticated = false;

    if (!file_exists($csvFile)) {
        // If file doesn't exist, we'll create a default one for testing if it's the first time
        // In a real scenario, this file should be pre-uploaded.
        $handle = fopen($csvFile, 'w');
        fputcsv($handle, ['mht_id', 'name']);
        fputcsv($handle, ['123456', 'Test User']);
        fputcsv($handle, ['MHT001', 'Admin']);
        fclose($handle);
    }

    if (($handle = fopen($csvFile, "r")) !== FALSE) {
        // Skip header
        fgetcsv($handle);
        
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[0] === $mht_id) {
                $authenticated = true;
                $_SESSION['mht_id'] = $mht_id;
                $_SESSION['user_name'] = isset($data[1]) ? $data[1] : 'MHT User';
                break;
            }
        }
        fclose($handle);
    }

    if ($authenticated) {
        header("Location: ../index.php");
        exit();
    } else {
        header("Location: ../login.php?error=Invalid MHT ID");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
