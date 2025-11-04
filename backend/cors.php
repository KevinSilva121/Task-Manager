<?php
// cors.php - permitir requisições AJAX do frontend
header('Access-Control-Allow-Origin: *'); // se for deploy, restrinja à origem
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
