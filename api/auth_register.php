<?php
require_once "conexion.php";
require_once "utils.php";

$data = getRequestData();

$name     = $data["name"] ?? "";
$email    = $data["email"] ?? "";
$password = $data["password"] ?? "";

if (!$name || !$email || !$password) {
    jsonResponse(["error" => "Faltan campos obligatorios"], 400);
}

$hash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hash);

if ($stmt->execute()) {
    jsonResponse(["success" => true]);
} else {
    jsonResponse(["error" => "Email ya registrado"], 409);
}
$stmt->close();