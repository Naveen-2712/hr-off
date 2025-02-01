<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

include 'db.php';

// Function to fetch current chart data
function getChartData($conn) {
    $data = [];
    
    // Query for department distribution
    $dept_query = "SELECT department, COUNT(*) as count FROM employee GROUP BY department";
    $dept_result = mysqli_query($conn, $dept_query);
    
    $dept_labels = [];
    $dept_values = [];
    while ($row = mysqli_fetch_assoc($dept_result)) {
        $dept_labels[] = $row['department'];
        $dept_values[] = (int)$row['count'];
    }
    
    // Query for role distribution
    $role_query = "SELECT role, COUNT(*) as count FROM employee GROUP BY role";
    $role_result = mysqli_query($conn, $role_query);
    
    $role_labels = [];
    $role_values = [];
    while ($row = mysqli_fetch_assoc($role_result)) {
        $role_labels[] = $row['role'];
        $role_values[] = (int)$row['count'];
    }
    
    // Query for status distribution
    $status_query = "SELECT status, COUNT(*) as count FROM employee GROUP BY status";
    $status_result = mysqli_query($conn, $status_query);
    
    $status_labels = [];
    $status_values = [];
    while ($row = mysqli_fetch_assoc($status_result)) {
        $status_labels[] = $row['status'];
        $status_values[] = (int)$row['count'];
    }
    
    return [
        'dept' => [
            'labels' => $dept_labels,
            'values' => $dept_values
        ],
        'role' => [
            'labels' => $role_labels,
            'values' => $role_values
        ],
        'status' => [
            'labels' => $status_labels,
            'values' => $status_values
        ]
    ];
}

// Keep connection alive and send updates
while (true) {
    $data = getChartData($conn);
    
    echo "data: " . json_encode($data) . "\n\n";
    
    ob_flush();
    flush();
    
    // Check for client connection
    if (connection_aborted()) {
        break;
    }
    
    // Minimal delay for near-instant updates
    usleep(1000); // 1ms delay
}
?>
