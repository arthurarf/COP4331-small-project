<?php

/*
For adding a new contact for a user.
Each contact must be associated with a UserID.
UserID is a reference to the ID of the user in the Users table.
 - This helps to make sure each user only has access to their own contacts.
 
Takes a Json object with these fields:
{
    "UserID": 0,
    "FirstName": "" ,
    "LastName": "" ,
    "Email": "" ,
    "Phone" : "" 
}
*/
include 'db.php';
include 'response.php';

$inData = getRequestInfo();

$stmt = $conn->prepare("INSERT INTO Contacts (UserID, FirstName, LastName, Email, Phone) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $inData["UserID"], $inData["FirstName"], $inData["LastName"], $inData["Email"], $inData["Phone"]);

if ($stmt->execute()) {
    $contactId = $conn->insert_id;
    returnWithSuccess("Contact added successfully");
} else {
    returnWithError("Failed to add contact");
}

$stmt->close();
$conn->close();

?>
