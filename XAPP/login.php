<?php
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];
$password = $data['password'];
$ip = $_SERVER['REMOTE_ADDR'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // Registrar login
    $login = $pdo->prepare("INSERT INTO login (user_id, ip_address) VALUES (?, ?)");
    $login->execute([$user['id'], $ip]);

    echo json_encode(["success" => true, "message" => "Login exitoso"]);
} else {
    echo json_encode(["success" => false, "message" => "Credenciales inválidas"]);
}
?>
