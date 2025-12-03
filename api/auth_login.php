<?php
require_once __DIR__ . "/conexion.php";
require_once __DIR__ . "/utils.php";

$data = getRequestData();

$email    = $data["email"] ?? "";
$password = $data["password"] ?? "";

if (!$email || !$password) {
    jsonResponse(["error" => "Email y password requeridos"], 400);
}

$stmt = $conn->prepare("SELECT id, name, email, password_hash FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user   = $result->fetch_assoc();

if (!$user) {
    jsonResponse(["error" => "Usuario no encontrado"], 404);
}

if (!password_verify($password, $user["password_hash"])) {
    jsonResponse(["error" => "Contraseña incorrecta"], 401);
}

unset($user["password_hash"]);

jsonResponse(["success" => true, "user" => $user]);
$stmt->close();