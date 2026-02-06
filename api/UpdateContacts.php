<?php

include 'db.php';
include 'response.php';

$inData = getRequestInfo();

$stmt = $conn->prepare("UPDATE Contacts SET FirstName=?, LastName=?, Email=?, Phone=? WHERE ID=? AND UserID=?");
$stmt->bind_param("ssssii", $inData["firstName"], $inData["lastName"], $inData["email"], $inData["phone"], $inData["contactID"], $inData["userID"]);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    returnWithSuccess("Contact updated successfully");
} else {
    returnWithError("Failed to update contact or contact not found");
}

$stmt->close();
$conn->close();

?>