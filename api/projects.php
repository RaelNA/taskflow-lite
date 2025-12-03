<?php
require_once "conexion.php";
require_once "utils.php";

$method = $_SERVER["REQUEST_METHOD"];

// Simulación de usuario logueado (id = 1)
// En producción vendría del token
$userId = 1;

if ($method === "GET") {
    $sql = "SELECT * FROM projects WHERE owner_id = ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $projects = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    jsonResponse($projects);
}

if ($method === "POST") {
    $data = getRequestData();

    $name = $data["name"] ?? "";
    $desc = $data["description"] ?? "";

    if (!$name) jsonResponse(["error" => "Nombre requerido"], 400);

    $sql = "INSERT INTO projects (name, description, owner_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $desc, $userId);
    $stmt->execute();

    jsonResponse(["success" => true, "id" => $stmt->insert_id]);
}

jsonResponse(["error" => "Método no permitido"], 405);
