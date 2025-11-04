<?php
// auth_middleware.php
require_once 'cors.php';
require_once 'jwt.php';

function getBearerToken() {
    $headers = null;
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } else if (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        if (isset($requestHeaders['Authorization'])) $headers = trim($requestHeaders['Authorization']);
    }
    if (!$headers) return null;
    if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
        return $matches[1];
    }
    return null;
}

function require_auth() {
    $token = getBearerToken();
    if (!$token) {
        http_response_code(401);
        echo json_encode(['error' => 'Token not provided']);
        exit;
    }
    $payload = jwt_verify($token);
    if (!$payload) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid or expired token']);
        exit;
    }
    return $payload; // contains at least user_id and username
}
