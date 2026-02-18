<?php
// Referenced in all endpoints
// This file establishes a connection to the database using these credentials:

$host = "localhost";
$username = "api_user";
$password = "COP4331apiUser";
$database = "COP4331";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(array("error" => "Connection failed: " . $conn->connect_error)));
}

?>