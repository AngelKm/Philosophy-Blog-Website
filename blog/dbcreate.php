<!--
1. Set Up Your Database:
 Create a new database in your MySQL server. 
You can use a tool, such as phpMyAdmin or run SQL commands.
 -->
 <?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = "localhost";
$username = "root";
$password = "";

// Create connection

$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error); // stop everyting after this
}

// Create database
$create_db = "CREATE DATABASE blog"; // formDataBase is database name
// check if the database has been created or not
if (mysqli_query($conn, $create_db)) { // retruns true or false
  echo "Database created successfully"; // true
} else { // false and shows text below with the error that was detected
  echo "Error creating database: " . mysqli_error($conn);
}
// close the connection
mysqli_close($conn);
?>


