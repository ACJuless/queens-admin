<?php
// Manually set user input values
$username = $_POST["username"];
$email = $_POST["email"];
$pw = $_POST["pw"];

// Check if username is not null
if (empty($username)) {
    die("Username cannot be null.");
}

// Database connection details
$host = "localhost";
$dbname = "project";
$dbusername = "root";
$dbpassword = "";

// Establish connection
$conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}

// Prepare the SQL statement with placeholders
$sql = "INSERT INTO users (username, email, pw) VALUES (?, ?, ?)";
$stmt = mysqli_stmt_init($conn);

// Check if the statement was prepared successfully
if (!mysqli_stmt_prepare($stmt, $sql)) {
    die("SQL statement preparation failed: " . mysqli_error($conn));
}

// Bind the user input parameters to the prepared statement
mysqli_stmt_bind_param($stmt, "sss", $username, $email, $pw);

// Execute the prepared statement
if (mysqli_stmt_execute($stmt)) {
    echo "Record Saved!";
} else {
    echo "Error saving record: " . mysqli_stmt_error($stmt);
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
