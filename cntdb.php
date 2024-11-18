<?php
session_start(); // Start the session
$conn = mysqli_connect("localhost", "root", "", "adminlogin");

if (!$conn) {
    die("Cannot connect to database: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the expected POST keys exist
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        
        // SQL query to check credentials
        $query = "SELECT * FROM admin WHERE Admin_Name='$username' AND Admin_Password='$password'";
        $result = mysqli_query($conn, $query);

        // Check for errors in the query
        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            // Successful login
            $_SESSION['loggedin'] = true; // Set a session variable
            header("Location: adminduty.php"); // Redirect to the admin dashboard
            exit(); // Stop further execution
        } else {
            // Failed login
            echo "Invalid username or password.";
        }
    } else {
        echo "Please enter both username and password.";
    }
}

// No need to close the connection here if you want to use it later
// mysqli_close($conn);
?>
