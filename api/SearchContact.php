<?php

/*
For searching contacts.
If the Search field is provided, it will show contacts that 
match the search term.
If the Search field is not provided, it will show all contacts that
belong to the user.

Takes a Json object with these fields:
{
    "userId": 0,
    "search": "" // This field is optional
}
*/

include 'db.php';
include 'response.php';

$inData = getRequestInfo();

if (isset($inData["search"]) && !empty($inData["search"])) {
    $searchTerm = "%" . $inData["search"] . "%";
    $stmt = $conn->prepare("SELECT ID, FirstName, LastName, Email, Phone, DateCreated FROM Contacts WHERE UserID=? AND (FirstName LIKE ? OR LastName LIKE ?)");
    
    if (!$stmt) {
        http_response_code(500);
        returnWithError("Database error");
        exit();
    }
    
    $stmt->bind_param("iss", $inData["userId"], $searchTerm, $searchTerm);
} else {
    $stmt = $conn->prepare("SELECT ID, FirstName, LastName, Email, Phone, DateCreated FROM Contacts WHERE UserID=?");
    
    if (!$stmt) {
        http_response_code(500);
        returnWithError("Database error");
        exit();
    }
    
    $stmt->bind_param("i", $inData["userId"]);
}

$stmt->execute();
$result = $stmt->get_result();

$contacts = array();
while ($row = $result->fetch_assoc()) {
    $contacts[] = $row;
}

http_response_code(200);
echo json_encode($contacts);

$stmt->close();
$conn->close();

?>