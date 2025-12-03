<?php
// api/utils.php

/**
 * Lee los datos de la petición (JSON, POST o GET) y devuelve un array asociativo.
 */
function getRequestData(): array
{
    // Si te llega como JSON (fetch, Axios, etc.)
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
        return $data;
    }

    // Si viene por POST (formulario tradicional)
    if (!empty($_POST)) {
        return $_POST;
    }

    // Si viene por GET (parámetros en la URL)
    if (!empty($_GET)) {
        return $_GET;
    }

    return [];
}

/**
 * Envía una respuesta JSON con código HTTP y termina el script.
 */
function jsonResponse($data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
