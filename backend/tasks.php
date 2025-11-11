
<?php
// tasks.php
require_once 'cors.php';
require_once 'db.php';
require_once 'auth_middleware.php';

$auth = require_auth(); // retorna payload com user_id
$pdo = getPDO();

$method = $_SERVER['REQUEST_METHOD'];
// id pode vir via parâmetro GET ?id= ou no corpo JSON para PUT/DELETE
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

switch ($method) {
    case 'GET':
        // se id especificado, retorna tarefa específica; senão retorna todas as tarefas do usuário
        if ($id) {
            $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
            $stmt->execute([$id, $auth['user_id']]);
            $task = $stmt->fetch();
            if (!$task) { http_response_code(404); echo json_encode(['error'=>'Not found']); exit; }
            echo json_encode($task);
        } else {
            $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY status ASC, due_date ASC");
            $stmt->execute([$auth['user_id']]);
            $tasks = $stmt->fetchAll();
            echo json_encode($tasks);
        }
        break;
    case 'POST':
        // cria nova tarefa
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || empty($data['title'])) { http_response_code(400); echo json_encode(['error'=>'title required']); exit; }
        $title = $data['title'];
        $description = $data['description'] ?? '';
        $due_date = $data['due_date'] ?? null; // espera formato 'YYYY-MM-DD HH:MM:SS' ou null
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description, due_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$auth['user_id'], $title, $description, $due_date]);
        $id = $pdo->lastInsertId();
        http_response_code(201);
        echo json_encode(['message'=>'created','id'=>$id]);
        break;
    case 'PUT':
        // atualiza tarefa (marcar como concluída, editar título, etc)
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data || empty($data['id'])) { http_response_code(400); echo json_encode(['error'=>'id required']); exit; }
        $tid = intval($data['id']);
        // verifica propriedade da tarefa
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id=? AND user_id=?");
        $stmt->execute([$tid, $auth['user_id']]);
        if (!$stmt->fetch()) { http_response_code(404); echo json_encode(['error'=>'Not found']); exit; }
        $title = $data['title'] ?? null;
        $description = $data['description'] ?? null;
        $due_date = $data['due_date'] ?? null;
        $status = $data['status'] ?? null; // 'open' ou 'done'
        $updates = [];
        $params = [];
        if ($title !== null) { $updates[] = "title = ?"; $params[] = $title; }
        if ($description !== null) { $updates[] = "description = ?"; $params[] = $description; }
        if ($due_date !== null) { $updates[] = "due_date = ?"; $params[] = $due_date; }
        if ($status !== null) { $updates[] = "status = ?"; $params[] = $status; }
        if (empty($updates)) { echo json_encode(['message'=>'nothing to update']); exit; }
        $params[] = $tid; $params[] = $auth['user_id'];
        $sql = "UPDATE tasks SET " . implode(", ", $updates) . " WHERE id = ? AND user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        echo json_encode(['message'=>'updated']);
        break;
    case 'DELETE':
        // deleta tarefa: id via ?id=
        if (!$id) { http_response_code(400); echo json_encode(['error'=>'id required']); exit; }
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $auth['user_id']]);
        echo json_encode(['message'=>'deleted']);
        break;
    default:
        http_response_code(405);
        echo json_encode(['error'=>'Method not allowed']);
        break;
}
