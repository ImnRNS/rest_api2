<?php
header("Content-Type: application/json");

include 'db_config.php';

// Get the posted data
$data = json_decode(file_get_contents("php://input"), true);

// Validate the data
if (!isset($data['id'], $data['name'], $data['email'], $data['nim'])) {
    die(json_encode(["error" => "Invalid input"]));
}

$id = $data['id'];
$name = $data['name'];
$email = $data['email'];
$nim = $data['nim'];

// Check data types
if (!is_int($id) || !is_string($name) || !is_string($email) || !is_string($nim)) {
    die(json_encode(["error" => "Invalid input types"]));
}

// Fetch the existing user data
$stmt = $koneksi->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "User not found"]);
    $stmt->close();
    $koneksi->close();
    exit();
}

$existingUser = $result->fetch_assoc();
$stmt->close();

// Prepare and bind for update
$stmt = $koneksi->prepare("UPDATE users SET name=?, email=?, nim=? WHERE id=?");
$stmt->bind_param("sssi", $name, $email, $nim, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "oldData" => $existingUser]);
} else {
    echo json_encode(["error" => $stmt->error]);
}

$stmt->close();
$koneksi->close();
?>
