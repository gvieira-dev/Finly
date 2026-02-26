<?php
// excluir_simulacao
session_start();
require_once("../config/conexao.php");

if(!isset($_SESSION["usuario_id"])) {
    http_response_code(403);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare("
DELETE FROM simulacoes
WHERE id = ? AND usuario_id = ?
");

$stmt->execute([
    $data["id"],
    $_SESSION["usuario_id"]
]);

echo json_encode(["status" => "ok"]);
