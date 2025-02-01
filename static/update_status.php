<?php
include 'db.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $status = $_POST['status'] ?? 'Pending';

    $response = ['success' => false];

    if (!empty($email)) {
        // Prepare and execute the update query
        $query = "UPDATE users SET status = ? WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $status, $email);
        
        if ($stmt->execute()) {
            $response['success'] = true;
        }
        
        $stmt->close();
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>