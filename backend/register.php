<?php
// register.php
require_once 'cors.php';
require_once 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

$required = ['first_name','last_name','birth_date','username','password'];
foreach ($required as $f) {
    if (empty($data[$f])) {
        http_response_code(400);
        echo json_encode(['error' => "Field $f is required"]);
        exit;
    }
}

$pdo = getPDO();

// Check username
$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$data['username']]);
if ($stmt->fetch()) {
    http_response_code(409);
    echo json_encode(['error' => 'Username already exists']);
    exit;
}

$hash = password_hash($data['password'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (first_name,last_name,birth_date,username,password_hash) VALUES (?,?,?,?,?)");
$stmt->execute([
    $data['first_name'],
    $data['last_name'],
    $data['birth_date'],
    $data['username'],
    $hash
]);

$userId = $pdo->lastInsertId();
http_response_code(201);
echo json_encode(['message' => 'User created', 'user_id' => $userId]);
