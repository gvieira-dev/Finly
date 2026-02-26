<?php
// listar_simulacoes
session_start();
require_once("../config/conexao.php");

if(!isset($_SESSION["usuario_id"])) {
    http_response_code(403);
    exit;
}

$stmt = $pdo->prepare("
SELECT * FROM simulacoes
WHERE usuario_id = ?
ORDER BY id DESC
");

$stmt->execute([$_SESSION["usuario_id"]]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
