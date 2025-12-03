<?php
// ====== CORS ======
$allowedOrigin = "http://localhost:4321"; // Astro dev server

header("Access-Control-Allow-Origin: $allowedOrigin");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Vary: Origin");

// Preflight: si es OPTIONS, respondemos 200 y salimos
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

// ====== CONEXIÓN BD ======
$host = "localhost";
$user = "root";
$pass = "";
$db   = "taskflow_lite";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Error de conexión a la base de datos"]);
    exit;
}

$conn->set_charset("utf8mb4");