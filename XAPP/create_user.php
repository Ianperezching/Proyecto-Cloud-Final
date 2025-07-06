require 'config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"];
$email = $data["email"];
$password = $data["password"];

$created_by = "system";

$stmt = $conn->prepare("CALL sp_create_user(?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $password, $created_by);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["status" => "success", "message" => "Usuario creado correctamente"]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudo crear el usuario"]);
}

$stmt->close();
$conn->close();
?>
<?php
require 'config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"] ?? '';
$email = $data["email"] ?? '';
$password = $data["password"] ?? '';

// Validación básica
if (empty($username) || empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios"]);
    exit;
}

// Hashear la contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$created_by = "system";
$state = 1;

$stmt = $conn->prepare("INSERT INTO user (email, password_hash, username, created_at, created_by, state) VALUES (?, ?, ?, NOW(), ?, ?)");
$stmt->bind_param("ssssi", $email, $password_hash, $username, $created_by, $state);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Usuario creado correctamente"]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudo crear el usuario: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>