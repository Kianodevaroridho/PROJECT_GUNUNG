<?php

include '../config/config.php';

// Validate and sanitize ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Prepare to delete pendaki related to mountains in this location
        $stmt1 = mysqli_prepare($conn, "
            DELETE p FROM pendaki p
            JOIN gunung g ON p.gunung_id = g.id_gunung
            WHERE g.lokasi_id = ?
        ");
        mysqli_stmt_bind_param($stmt1, "i", $id);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_close($stmt1);

        // Prepare to delete mountains in this location
        $stmt2 = mysqli_prepare($conn, "DELETE FROM gunung WHERE lokasi_id = ?");
        mysqli_stmt_bind_param($stmt2, "i", $id);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);

        // Prepare to delete the location itself
        $stmt3 = mysqli_prepare($conn, "DELETE FROM lokasi WHERE id_lokasi = ?");
        mysqli_stmt_bind_param($stmt3, "i", $id);
        mysqli_stmt_execute($stmt3);
        mysqli_stmt_close($stmt3);

        // If all queries were successful, commit the transaction
        mysqli_commit($conn);
        header("Location: index.php?status=delete_success");

    } catch (mysqli_sql_exception $exception) {
        // If any query fails, roll back the transaction
        mysqli_rollback($conn);
        header("Location: index.php?status=delete_error");
    }

} else {
    // Invalid ID
    header("Location: index.php?status=invalid_id");
}

exit();