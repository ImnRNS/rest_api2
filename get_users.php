<?php
include 'db_config.php';

// Check the database connection
if ($koneksi->connect_error) {
    http_response_code(500);
    die("Connection failed: " . $koneksi->connect_error);
}

$sql = "SELECT * FROM users";
$result = $koneksi->query($sql);

$users = array();

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($users);
    } else {
        http_response_code(404);
        echo json_encode(array("error" => "No users found"));
    }
} else {
    http_response_code(500);
    echo json_encode(array("error" => "Error executing query"));
}

// No need to explicitly close the connection
