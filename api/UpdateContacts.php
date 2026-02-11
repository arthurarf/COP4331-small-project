<?php

/*
For updating a contact's information.
The ID and UserID fields are needed to identify the contact, so these don't get changed.

Takes a Json object with these fields:
{
    "ID": 0 ,
    "UserID": 0 ,
    "FirstName": "" ,
    "LastName": "" ,
    "Email": "" ,
    "Phone" : "" 
}
*/

include 'db.php';
include 'response.php';

$inData = getRequestInfo();

$stmt = $conn->prepare("UPDATE Contacts SET FirstName=?, LastName=?, Email=?, Phone=? WHERE ID=? AND UserID=?");
$stmt->bind_param("ssssii", $inData["FirstName"], $inData["LastName"], $inData["Email"], $inData["Phone"], $inData["ID"], $inData["UserID"]);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    returnWithSuccess("Contact updated successfully");
} else {
    returnWithError("Failed to update contact or contact not found");
}

$stmt->close();
$conn->close();

?>