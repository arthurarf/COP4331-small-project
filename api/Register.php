<?php

/*
For user registration. 
Once registered, each user gets their own 'ID' in the
Users table in the database.

Takes a Json object with these fields:
{
    "firstName": "" ,
    "lastName": "" ,
    "login": "" ,
    "password" : "" 
}
*/


include 'db.php';
include 'response.php';

$inData = getRequestInfo();

$stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Login, Password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $inData["firstName"], $inData["lastName"], $inData["login"], $inData["password"]);

if ($stmt->execute()) {
    $userId = $conn->insert_id;
    returnWithInfo($userId, $inData["login"], $inData["firstName"], $inData["lastName"]);
} else {
    returnWithError("Login already exists or registration failed");
}

$stmt->close();
$conn->close();

?>