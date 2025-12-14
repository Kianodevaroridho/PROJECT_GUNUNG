<?php

include '../config/config.php';

// Validate and sanitize ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    // Use prepared statements to prevent SQL injection
    $stmt = mysqli_prepare($conn, "DELETE FROM gunung WHERE id_gunung = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Deletion successful
        header("Location: index.php?status=delete_success");
    } else {
        // Deletion failed
        header("Location: index.php?status=delete_error");
    }
    mysqli_stmt_close($stmt);
} else {
    // Invalid ID
    header("Location: index.php?status=invalid_id");
}

exit();