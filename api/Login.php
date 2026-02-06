<?php

include 'db.php';
include 'response.php';

$inData = getRequestInfo();

$stmt = $conn->prepare("SELECT ID, Login, FirstName, LastName FROM Users WHERE Login=? AND Password=?");
$stmt->bind_param("ss", $inData["login"], $inData["password"]);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    returnWithInfo($row['ID'], $row['Login'], $row['FirstName'], $row['LastName']);
} else {
    returnWithError("Invalid login or password");
}

$stmt->close();
$conn->close();

?>