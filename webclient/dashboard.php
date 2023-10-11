<?php

include_once 'local_db_conn.php';

session_start();

$dataArray = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $reference = $_POST["reference"];
    $amount = $_POST["amount"];
    $response = "success";
    $biller = $_POST["biller"];
    $b_name = $_POST["b_name"];
    $cracc = $_POST["biller_acc_no"];
    $mobile = $_POST["mobile"];

    // Validate form inputs
    if (empty($reference) || empty($amount) || $biller == 'Select') {
        $_SESSION["message"] = "empty_inputs";
        header('location: dashboard.php');
        exit();
    } else {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO bills (reference, amount, response, biller_id, user, cracc, dbacc, mobile) VALUES (:reference, :amount, :response, :biller, :user, :cracc, :dbacc, :mobile)";
            $stmt = $local_conn->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':reference', $reference, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
            $stmt->bindParam(':response', $response, PDO::PARAM_STR);
            $stmt->bindParam(':biller', $biller, PDO::PARAM_STR);
            $stmt->bindParam(':user',  $_SESSION["username"], PDO::PARAM_STR);
            $stmt->bindParam(':cracc', $cracc, PDO::PARAM_STR);
            $stmt->bindParam(':dbacc',  $_SESSION["institute_accno"], PDO::PARAM_STR);
            $stmt->bindParam(':mobile', $mobile, PDO::PARAM_STR);

            // Execute the prepared statement
            $stmt->execute();

            // Redirect to a success page or display a success message
            header('Location: dashboard.php');
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $_SESSION["message2"] = $e->getMessage();
        }
    }
} else {
    //GET
    if (empty($_SESSION["username"])) {
        header('Location: logout.php');
        exit;
    } else {
        $_SESSION["message"] = "welcome";
        //getDefaultDataSet
        // Prepare and execute a parameterized query
        $query = "SELECT * FROM bills ORDER BY date DESC LIMIT 100";

        try {
            $stmt = $local_conn->prepare($query);
            $stmt->execute();

            $dataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle query execution errors
            $_SESSION["message2"] = $e->getMessage();
            header('location:dashboard.php');
            //return false;
        }

        $billers = "SELECT * FROM billers"; //for dropdown in 'select biller' input field

        try {
            $stmt = $local_conn->prepare($billers);
            $stmt->execute();

            $billersArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle query execution errors
            $_SESSION["message2"] = $e->getMessage();
            header('location:dashboard.php');
            //return false;
        }

        include_once "pagination.php";
        include_once 'html/dashboard.html';
    }
}
