<?php
$host = "";
$database = "";
$username = ""; 
$password = ""; 


$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
// if ($conn->connect_error) {
//     echo "Database connection failed: " . $conn->connect_error;
// } else {
//     echo "Database connection successful!";
//     // You can optionally close the connection here if you only need to test it.
//     // $conn->close();
// }

?>