<?php

/*
For searching contacts.
If the Search field is provided, it will show contacts that 
match the search term.
If the Search field is not provided, it will show all contacts that
belong to the user.

Takes a Json object with these fields:
{
    "UserID": 0,
    "Search": "" // This field is optional
}
*/

include 'db.php';
include 'response.php';

$inData = getRequestInfo();

if (isset($inData["Search"]) && !empty($inData["Search"])) {
    $searchTerm = "%" . $inData["Search"] . "%";
    $stmt = $conn->prepare("SELECT ID, FirstName, LastName, Email, Phone, DateCreated FROM Contacts WHERE UserID=? AND (FirstName LIKE ? OR LastName LIKE ?)");
    $stmt->bind_param("iss", $inData["UserID"], $searchTerm, $searchTerm);
} else {
    $stmt = $conn->prepare("SELECT ID, FirstName, LastName, Email, Phone FROM Contacts WHERE UserID=?");
    $stmt->bind_param("i", $inData["UserID"]);
}

$stmt->execute();
$result = $stmt->get_result();

$contacts = array();
while ($row = $result->fetch_assoc()) {
    $contacts[] = $row;
}

echo json_encode($contacts);

$stmt->close();
$conn->close();

?>
