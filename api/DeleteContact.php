<?php

include 'db.php';
include 'response.php';

$inData = getRequestInfo();

$stmt = $conn->prepare("DELETE FROM Contacts WHERE ID=? AND UserID=?");
$stmt->bind_param("ii", $inData["contactID"], $inData["userID"]);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    returnWithSuccess("Contact deleted successfully");
} else {
    returnWithError("Failed to delete contact or contact not found");
}

$stmt->close();
$conn->close();

?>