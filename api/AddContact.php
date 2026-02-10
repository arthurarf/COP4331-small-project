<?php

include 'db.php';
include 'response.php';

$inData = getRequestInfo();

$stmt = $conn->prepare("INSERT INTO Contacts (UserID, FirstName, LastName, Email, Phone) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $inData["userID"], $inData["firstName"], $inData["lastName"], $inData["email"], $inData["phone"]);

if ($stmt->execute()) {
    $contactId = $conn->insert_id;
    returnWithSuccess("Contact added successfully");
} else {
    returnWithError("Failed to add contact");
}

$stmt->close();
$conn->close();

?>