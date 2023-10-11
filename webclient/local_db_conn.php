<?php
// Database configuration
$db_host = "localhost";
$db_name = "bill_payment";
$db_user = "root";
$db_pass = "AEzakmi@6526560";

try {
    // Establish a connection without specifying the database
    $local_conn = new PDO("mysql:host=$db_host;charset=utf8mb4", $db_user, $db_pass);
    $local_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$local_conn->exec("USE $db_name");
    // Check if the database exists
    $stmt = $local_conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'");
    $databaseExists = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$databaseExists) {
        // Create the database
        $createDatabaseSQL = "CREATE DATABASE $db_name";
        $local_conn->exec($createDatabaseSQL);
        //echo "Database created successfully";

        echo '<div class="container fixed-bottom">
        <div class="row justify-content-center">
          <div class="col-md-5">
            <div class="alert alert-success alert-dismissible text-center" role="alert">
                New Database created successfully.
            </div>
          </div>
        </div>
      </div>';

        // Reconnect to the newly created database
        $local_conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
        $local_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        createNewTables($local_conn);
    } else {
        //echo "Database already exists";
        /*echo '<div class="container fixed-bottom">
        <div class="row justify-content-center">
          <div class="col-md-5">
            <div class="alert alert-success alert-dismissible text-center" role="alert">
                Welcome to bill payment system.
            </div>
          </div>
        </div>
      </div>';*/
        $local_conn->exec("USE bill_payment");
    }
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

function createNewTables($local_conn)
{
    // Define the SQL statements to create tables
    /*$sqlStatements = [
        "CREATE TABLE IF NOT EXISTS `billers` (
            `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `accountno` varchar(15) NOT NULL DEFAULT '0',
            `name` varchar(20) NOT NULL
        )",
        "CREATE TABLE IF NOT EXISTS `bills` (
            `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `biller_id` int(11) NOT NULL DEFAULT 0,
            `reference` varchar(16) NOT NULL DEFAULT '',
            `amount` double(10,2) NOT NULL,
            `date` timestamp NOT NULL DEFAULT current_timestamp(),
            `response` varchar(20) NOT NULL,
            `user` varchar(20) DEFAULT NULL,
            `dbacc` varchar(15) DEFAULT NULL,
            `cracc` varchar(15) DEFAULT NULL,
            INDEX `date` (`date`),
            INDEX `reference` (`reference`),
            INDEX `amt` (`amount`) USING BTREE,
            INDEX `biller_id` (`biller_id`)
        )",
        "CREATE TABLE IF NOT EXISTS `institute` (
            `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `name` varchar(50) DEFAULT NULL,
            `accno` varchar(15) DEFAULT NULL
        )",
        "CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `username` varchar(200) NOT NULL,
            `password` text NOT NULL,
            `institute_id` varchar(30) NOT NULL DEFAULT '0',
            `role` varchar(20) NOT NULL DEFAULT 'external',
            `created_at` timestamp NOT NULL DEFAULT current_timestamp()
        )",
        "INSERT INTO `users` (`id`, `username`, `password`, `institute_id`, `role`) VALUES
        (10781, 'chamara', '6526560', '1', 'external')"
    ];*/
    $sqlStatements = [
        "CREATE TABLE IF NOT EXISTS `billers` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `accountno` varchar(15) NOT NULL DEFAULT '0',
            `name` varchar(20) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",

        "CREATE TABLE IF NOT EXISTS `bills` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `biller_id` int(11) NOT NULL DEFAULT 0,
            `reference` varchar(16) NOT NULL DEFAULT '',
            `amount` double(10,2) NOT NULL,
            `date` timestamp NOT NULL DEFAULT current_timestamp(),
            `response` varchar(20) NOT NULL,
            `user` varchar(20) DEFAULT NULL,
            `dbacc` varchar(15) DEFAULT NULL,
            `cracc` varchar(15) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `date` (`date`),
            KEY `reference` (`reference`),
            KEY `amt` (`amount`) USING BTREE,
            KEY `biller_id` (`biller_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",

        "CREATE TABLE IF NOT EXISTS `institute` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(50) DEFAULT NULL,
            `accno` varchar(15) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

        "CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(200) NOT NULL,
            `password` text NOT NULL,
            `institute_id` varchar(30) NOT NULL DEFAULT '0',
            `role` varchar(20) NOT NULL DEFAULT 'external',
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",

        "INSERT INTO `billers` (`id`, `accountno`, `name`) VALUES
        (1, '204100193156004', 'CEB'),
        (2, '204100193156005', 'Mobitel'),
        (3, '204100193156006', 'Hutch'),
        (4, '204100193156007', 'Etisalat');",

        "INSERT INTO `institute` (`id`, `name`, `accno`) VALUES
        (1, 'cooperative1', '204200100091326'),
        (2, 'ruralbank', '204200100091327');",

        "INSERT INTO `users` (`id`, `username`, `password`, `institute_id`, `role`) VALUES
            (10781, 'chamara', '6526560', '1', 'external')"
    ];


    try {
        foreach ($sqlStatements as $sql) {
            // Execute the SQL statement to create the table
            $local_conn->exec($sql);
        }
        //echo "Tables created successfully";
        echo '<div class="container fixed-bottom">
            <div class="row justify-content-center">
              <div class="col-md-5">
                <div class="alert alert-success alert-dismissible text-center" role="alert">
                    New tables created successfully.
                </div>
              </div>
            </div>
          </div>';
    } catch (PDOException $e) {
        echo "Error creating tables: " . $e->getMessage();
    }
}
