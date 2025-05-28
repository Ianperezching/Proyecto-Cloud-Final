<?php
require 'config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$username = $data["username"];
$password = $data["password"];

$stmt = $conn->prepare("CALL sp_login_user(?, ?)");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    echo json_encode(["status" => "success", "message" => "Inicio de sesión exitoso", "user" => $user]);
} else {
    echo json_encode(["status" => "error", "message" => "Credenciales inválidas"]);
}

$stmt->close();
$conn->close();
?>