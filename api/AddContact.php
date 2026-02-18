<?php

/*
For adding a new contact for a user.
Each contact must be associated with a UserID.
UserID is a reference to the ID of the user in the Users table.
 - This helps to make sure each user only has access to their own contacts.
 
Takes a Json object with these fields:
{
    "userId": 0,
    "firstName": "" ,
    "lastName": "" ,
    "email": "" ,
    "phone" : "" 
}
*/
include 'db.php';
include 'response.php';

$inData = getRequestInfo();

$stmt = $conn->prepare("INSERT INTO Contacts (UserID, FirstName, LastName, Email, Phone) VALUES (?, ?, ?, ?, ?)");

if (!$stmt) {
    http_response_code(500);
    returnWithError("Database error");
    exit();
}

$stmt->bind_param("issss", $inData["userId"], $inData["firstName"], $inData["lastName"], $inData["email"], $inData["phone"]);

if ($stmt->execute()) {
    http_response_code(200);
    $contactId = $conn->insert_id;
    returnWithSuccess("Contact added successfully");
} else {
    http_response_code(500);
    returnWithError("Failed to add contact");
}

$stmt->close();
$conn->close();

?>