<?php
// Include database connection
include 'db.php';

// Check if email parameter exists
if(isset($_GET['email'])) {
    $email = $_GET['email'];
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // First delete from banks table
        $sql_banks = "DELETE FROM banks WHERE email = ?";
        $stmt_banks = $conn->prepare($sql_banks);
        $stmt_banks->bind_param("s", $email);
        $stmt_banks->execute();
        $stmt_banks->close();
        
        // Then delete from jobs table
        $sql_jobs = "DELETE FROM jobs WHERE email = ?";
        $stmt_jobs = $conn->prepare($sql_jobs);
        $stmt_jobs->bind_param("s", $email);
        $stmt_jobs->execute();
        $stmt_jobs->close();
        
        // Finally delete from users table
        $sql_users = "DELETE FROM users WHERE email = ?";
        $stmt_users = $conn->prepare($sql_users);
        $stmt_users->bind_param("s", $email);
        $stmt_users->execute();
        $stmt_users->close();
        
        // If all queries successful, commit the transaction
        $conn->commit();
        header("Location: admin.php?msg=User and related records deleted successfully");
        exit();
        
    } catch (Exception $e) {
        // If any query fails, rollback the transaction
        $conn->rollback();
        header("Location: admin.php?error=Failed to delete user: " . $e->getMessage());
        exit();
    }
} else {
    // No email provided
    header("Location: admin.php?error=No email provided");
    exit();
}

$conn->close();
?>