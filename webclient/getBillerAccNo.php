<?php
// Include the file that establishes the database connection
include_once 'local_db_conn.php';

if (isset($_POST['biller_id'])) {
    $billerId = $_POST['biller_id'];

    // Prepare and execute the query to fetch biller_acc_no based on biller ID
    $query = "SELECT accountno FROM billers WHERE id = :biller_id";
    $stmt = $local_conn->prepare($query);
    $stmt->bindParam(':biller_id', $billerId);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Return the biller_acc_no as JSON
        echo json_encode($result);
    } else {
        // Return an error message as JSON (if needed)
        echo json_encode(['error' => 'Biller not found']);
    }
} else {
    // Return an error message as JSON (if needed)
    echo json_encode(['error' => 'Invalid request']);
}
