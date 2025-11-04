<?php
// login.php
require_once 'cors.php';
require_once 'db.php';
require_once 'jwt.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || empty($data['username']) || empty($data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'username and password required']);
    exit;
}

$pdo = getPDO();
$stmt = $pdo->prepare("SELECT id, username, password_hash, first_name, last_name FROM users WHERE username = ?");
$stmt->execute([$data['username']]);
$user = $stmt->fetch();
if (!$user || !password_verify($data['password'], $user['password_hash'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid credentials']);
    exit;
}

// cria token
$payload = [
    'user_id' => intval($user['id']),
    'username' => $user['username'],
    'name' => $user['first_name'] . ' ' . $user['last_name']
];
$token = jwt_create($payload);

echo json_encode(['token' => $token, 'user' => $payload]);
