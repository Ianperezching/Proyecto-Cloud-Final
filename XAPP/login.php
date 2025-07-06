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
<?php
require 'config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$email = $data["email"] ?? '';
$password = $data["password"] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password_hash'])) {
    echo json_encode(["status" => "success", "message" => "Inicio de sesión exitoso", "user" => [
        "id" => $user["id"],
        "email" => $user["email"],
        "username" => $user["username"]
    ]]);
} else {
    echo json_encode(["status" => "error", "message" => "Credenciales inválidas"]);
}

$stmt->close();
$conn->close();
?>