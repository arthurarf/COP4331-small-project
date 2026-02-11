<?php

/*
For user registration. 
Once registered, each user gets their own 'ID' in the
Users table in the database.

Takes a Json object with these fields:
{
    "FirstName": "" ,
    "LastName": "" ,
    "Login": "" ,
    "Password" : "" 
}
*/


include 'db.php';
include 'response.php';

$inData = getRequestInfo();

$stmt = $conn->prepare("INSERT INTO Users (FirstName, LastName, Login, Password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $inData["FirstName"], $inData["LastName"], $inData["Login"], $inData["Password"]);

if ($stmt->execute()) {
    $userId = $conn->insert_id;
    returnWithInfo($userId, $inData["Login"], $inData["FirstName"], $inData["LastName"]);
} else {
    returnWithError("Login already exists or registration failed");
}

$stmt->close();
$conn->close();

?>