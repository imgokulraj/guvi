<?php
    require '../vendor/autoload.php' ;

// Establish a connection to MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");

    $collectionName = 'userdetails';

    $mongodb = $mongoClient->mydatabase ;
    $mongoCollection = $mongodb->selectCollection($collectionName);


?>


