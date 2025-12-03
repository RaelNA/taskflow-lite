<?php
require_once "conexion.php";
require_once "utils.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    $projectId = $_GET["project_id"] ?? 0;

    $sql = "SELECT * FROM tasks WHERE project_id = ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $projectId);
    $stmt->execute();

    jsonResponse($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
}

if ($method === "POST") {
    $data = getRequestData();

    $project_id = $data["project_id"] ?? 0;
    $title      = $data["title"] ?? "";
    $desc       = $data["description"] ?? "";
    $status     = $data["status"] ?? "todo";
    $priority   = $data["priority"] ?? "medium";
    $due_date   = $data["due_date"] ?? null;

    if (!$project_id || !$title) jsonResponse(["error" => "Campos requeridos"], 400);

    $sql = "INSERT INTO tasks (project_id, title, description, status, priority, due_date)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $project_id, $title, $desc, $status, $priority, $due_date);
    $stmt->execute();

    jsonResponse(["success" => true, "id" => $stmt->insert_id]);
}

if ($method === "PUT") {
    parse_str(file_get_contents("php://input"), $putData);

    $id       = $putData["id"] ?? 0;
    $status   = $putData["status"] ?? null;

    if (!$id || !$status) jsonResponse(["error" => "Datos insuficientes"], 400);

    $sql = "UPDATE tasks SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    jsonResponse(["success" => true]);
}

if ($method === "DELETE") {
    parse_str(file_get_contents("php://input"), $delData);
    $id = $delData["id"] ?? 0;

    if (!$id) jsonResponse(["error" => "ID requerido"], 400);

    $sql = "DELETE FROM tasks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    jsonResponse(["success" => true]);
}

jsonResponse(["error" => "Método no permitido"], 405);
