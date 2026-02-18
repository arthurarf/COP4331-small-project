<?php

/*
For User login.

Takes a Json object with these fields:
{
    "login": "" ,
    "password" : "" 
}
*/
include 'db.php';
include 'response.php';

$inData = getRequestInfo();

$stmt = $conn->prepare("SELECT ID, Login, FirstName, LastName FROM Users WHERE Login=? AND Password=?");

if (!$stmt) {
    http_response_code(500);
    returnWithError("Database error");
    exit();
}

$stmt->bind_param("ss", $inData["login"], $inData["password"]);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    http_response_code(200);
    returnWithInfo($row['ID'], $row['Login'], $row['FirstName'], $row['LastName']);
} else {
    http_response_code(404);
    returnWithError("Invalid login or password");
}

$stmt->close();
$conn->close();

?>