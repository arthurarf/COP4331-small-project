<?php
// Referenced in all endpoints
// This file includes helper functions used in the endpoints

function getRequestInfo()
{
    return json_decode(file_get_contents('php://input'), true);
}

function sendResultInfoAsJson($obj)
{
    header('Content-type: application/json');
    echo json_encode($obj);
}

function returnWithError($err)
{
    $retValue = array('error' => $err);
    sendResultInfoAsJson($retValue);
}

function returnWithInfo($id, $login, $firstName, $lastName)
{
    $retValue = array(
        'ID' => $id,
        'Login' => $login,
        'FirstName' => $firstName,
        'LastName' => $lastName,
        'error' => ''
    );
    sendResultInfoAsJson($retValue);
}

function returnWithSuccess($message)
{
    $retValue = array(
        'success' => true,
        'message' => $message,
        'error' => ''
    );
    sendResultInfoAsJson($retValue);
}

?>