<?php

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