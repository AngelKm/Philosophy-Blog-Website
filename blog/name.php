<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Select the database
if (!mysqli_select_db($conn, $dbname)) {
    die("Failed to select database: " . mysqli_error($conn));
  }

$insert = "INSERT INTO users(firstname, lastname, username, email, password)
VALUES ('Mark', 'Smith', 'Mark', 'mark@example.com', 'markbear')";


if ($conn->query($insert) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $insert . "<br>" . $conn->error;
}

//echo "Hello!!";

$conn->close();
?>