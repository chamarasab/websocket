<?php
// Include the file that establishes the database connection
include_once 'local_db_conn.php';
// Start the session to access session data
session_start();

// Set default message for display
$_SESSION["message"] = "Welcome";

// Check if the form has been submitted (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if the database connection is established
  if (!isset($local_conn)) {
    $_SESSION["message"] = "connection_failed";
  } else {
    // Get form inputs
    $username = $_POST["username"];
    $password = $_POST["password"];
    $captcha = $_POST["captcha"];

    // Validate form inputs
    if (empty($username) || empty($password) || empty($captcha)) {
      //empty input fields
      echo '<div class="container fixed-bottom">
            <div class="row justify-content-center">
              <div class="col-md-5">
                <div class="alert alert-danger alert-dismissible text-center" role="alert">
                  Empty Inputs !
                </div>
              </div>
            </div>
          </div>';
    } elseif (trim($_SESSION["code"]) !== trim($captcha)) {
      //captcha failed
      echo '<div class="container fixed-bottom">
            <div class="row justify-content-center">
              <div class="col-md-5">
                <div class="alert alert-danger alert-dismissible text-center" role="alert">
                  Captcha Failed !
                </div>
              </div>
            </div>
          </div>';
    } else {
      try {
        // Prepare and execute the query to fetch user data from the database
        $search_query = "SELECT U.id AS u_id, U.username AS u_username, U.role AS u_role, U.password AS u_password, U.institute_id AS u_institute_id, I.id AS i_id, I.name AS i_name, I.accno AS i_accno FROM users AS U INNER JOIN institute AS I ON U.institute_id = I.id WHERE U.username = :username AND U.password = :password;";

        //$search_query = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $local_conn->prepare($search_query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Fetch the result (user data)
        $result = $stmt->fetch();

        if ($result) {
          // User login successful

          // Update session message
          $_SESSION["message"] = "user_validation_success";

          // Store user data in session variables
          $_SESSION["username"] = $username;
          $_SESSION["role"] = $result["u_role"];
          $_SESSION["institute_accno"] = $result["i_accno"];
          $_SESSION["institute_id"] = $result["i_id"];
          $_SESSION["institute_name"] = $result["i_name"];

          // Redirect users based on their roles
          switch ($_SESSION["role"]) {
            case "external":
              header('location: dashboard.php');
              exit();
            default:
              header('location: logout.php');
              exit();
          }
        } else {
          // User not found in the database
          echo '<div class="container fixed-bottom">
                <div class="row justify-content-center">
                  <div class="col-md-5">
                    <div class="alert alert-danger alert-dismissible text-center" role="alert">
                      User Not Found !
                    </div>
                  </div>
                </div>
              </div>';
        }
      } catch (PDOException $e) {
        // Handle database query errors
        //echo "Error: " . $e->getMessage();
        echo '<div class="container fixed-bottom">
                <div class="row justify-content-center">
                  <div class="col-md-5">
                    <div class="alert alert-danger alert-dismissible text-center" role="alert">' .
          $e->getMessage()
          . '</div>
                  </div>
                </div>
              </div>';
      }
    }
  }
} else {
  // The page was accessed via GET request, i.e., not submitted via the login form
  $_SESSION["message"] = "welcome";
}

// Include the login HTML page for display
include_once 'html/login.html';
