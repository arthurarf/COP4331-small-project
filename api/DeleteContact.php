<?php

/*
For deleting a contact.
The ID field is the ID of the contact in the Contacts table.
UserID corresponds to the ID of the user in the Users table.

Takes a Json object with these fields:
{
    "ID": 0,
    "UserID": 0
}
*/
include 'db.php';
include 'response.php';

$inData = getRequestInfo();

$stmt = $conn->prepare("DELETE FROM Contacts WHERE ID=? AND UserID=?");
$stmt->bind_param("ii", $inData["ID"], $inData["UserID"]);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    returnWithSuccess("Contact deleted successfully");
} else {
    returnWithError("Failed to delete contact or contact not found");
}

$stmt->close();
$conn->close();

?>
