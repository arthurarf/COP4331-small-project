<?php

/*
For updating a contact's information.
The ID and UserID fields are needed to identify the contact, so these don't get changed.

Takes a Json object with these fields:
{
    "id": 0 ,
    "userId": 0 ,
    "firstName": "" ,
    "lastName": "" ,
    "email": "" ,
    "phone" : "" 
}
*/

include 'db.php';
include 'response.php';

$inData = getRequestInfo();

$stmt = $conn->prepare("UPDATE Contacts SET FirstName=?, LastName=?, Email=?, Phone=? WHERE ID=? AND UserID=?");

if (!$stmt) {
    http_response_code(500);
    returnWithError("Database error");
    exit();
}

$stmt->bind_param("ssssii", $inData["firstName"], $inData["lastName"], $inData["email"], $inData["phone"], $inData["id"], $inData["userId"]);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    http_response_code(200);
    returnWithSuccess("Contact updated successfully");
} else {
    http_response_code(404);
    returnWithError("Failed to update contact or contact not found");
}

$stmt->close();
$conn->close();

?>