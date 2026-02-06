<?php

include 'db.php';
include 'response.php';

$inData = getRequestInfo();

// Check if search phrase is provided
if (isset($inData["search"]) && !empty($inData["search"])) {
    $searchTerm = "%" . $inData["search"] . "%";
    $stmt = $conn->prepare("SELECT ID, FirstName, LastName, Email, Phone, DateCreated FROM Contacts WHERE UserID=? AND (FirstName LIKE ? OR LastName LIKE ?)");
    $stmt->bind_param("iss", $inData["userID"], $searchTerm, $searchTerm);
} else {
    $stmt = $conn->prepare("SELECT ID, FirstName, LastName, Email, Phone, DateCreated FROM Contacts WHERE UserID=?");
    $stmt->bind_param("i", $inData["userID"]);
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