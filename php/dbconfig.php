<?php
    // configuring mongodb 
    require '../vendor/autoload.php' ;
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");

    $collectionName = 'userdetails';

    $mongodb = $mongoClient->mydatabase ;
    $result = $mongodb->createCollection($collectionName) ;
    var_dump($result) ;
    // configuring mysql
    $servername = "localhost";
$username = "root";
$password = "";
$dbname = "userlogin" ;

// Create database connection
$conn = new mysqli($servername, $username, $password);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database
$sql = "CREATE DATABASE userlogin";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

// Close the database connection
$conn->close();

// Define database connection parameters for the newly created database

// Create a new connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create a table with four string attributes
$sql = "CREATE TABLE users (
name VARCHAR(30) NOT NULL,
username VARCHAR(30) NOT NULL,
email VARCHAR(30) NOT NULL,
password VARCHAR(30) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close the database connection
$conn->close();
?>