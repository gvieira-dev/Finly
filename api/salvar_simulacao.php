<?php
// salvar_simulacao
session_start();
require_once("../config/conexao.php");

if(!isset($_SESSION["usuario_id"])) {
    http_response_code(403);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $pdo->prepare("
INSERT INTO simulacoes 
(usuario_id, nome, salario, gastos, meta, extra, valor_mensal, tempo)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $_SESSION["usuario_id"],
    $data["nome"],
    $data["salario"],
    $data["gastos"],
    $data["meta"],
    $data["extra"],
    $data["valorMensal"],
    $data["tempoTexto"]
]);

echo json_encode(["status" => "ok"]);
