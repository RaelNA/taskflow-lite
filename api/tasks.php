<?php
require_once "conexion.php";
require_once "utils.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    // /api/tasks.php?project_id=1
    $projectId = isset($_GET["project_id"]) ? (int) $_GET["project_id"] : 0;

    if ($projectId <= 0) {
        jsonResponse(["success" => false, "error" => "project_id inválido"], 400);
    }

    $sql = "SELECT id, project_id, title, description, status 
            FROM tasks 
            WHERE project_id = ? 
            ORDER BY id DESC";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        jsonResponse(["success" => false, "error" => "Error en la consulta"], 500);
    }

    $stmt->bind_param("i", $projectId);
    $stmt->execute();

    $result = $stmt->get_result();
    $tasks = $result->fetch_all(MYSQLI_ASSOC);

    jsonResponse($tasks);
}

if ($method === "POST") {
    // Cuerpo JSON
    $data = getRequestData();

    $project_id  = isset($data["project_id"]) ? (int) $data["project_id"] : 0;
    $title       = $data["title"] ?? "";
    $description = $data["description"] ?? "";
    $status      = $data["status"] ?? "todo";

    if ($project_id <= 0 || !$title) {
        jsonResponse([
            "success" => false,
            "error"   => "project_id y título son obligatorios"
        ], 400);
    }

    $sql = "INSERT INTO tasks (project_id, title, description, status)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        jsonResponse(["success" => false, "error" => "Error preparando la consulta"], 500);
    }

    $stmt->bind_param("isss", $project_id, $title, $description, $status);

    if (!$stmt->execute()) {
        jsonResponse([
            "success" => false,
            "error"   => "No se pudo insertar la tarea"
        ], 500);
    }

    jsonResponse([
        "success" => true,
        "id"      => $stmt->insert_id
    ]);
}

// Si llega aquí, método no permitido
jsonResponse(["success" => false, "error" => "Método no permitido"], 405);
