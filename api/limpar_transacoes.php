<?php
// limpar_transacoes
session_start();
header('Content-Type: application/json');

if(!isset($_SESSION["usuario_id"])){
    echo json_encode(["status"=>"erro","mensagem"=>"Usuário não logado"]);
    exit;
}

$usuario_id = $_SESSION["usuario_id"];
require_once __DIR__ . '/../config/conexao.php';

try {
    $stmt = $pdo->prepare("DELETE FROM transacoes WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);

    echo json_encode(["status"=>"ok"]);

} catch(PDOException $e){
    echo json_encode(["status"=>"erro","mensagem"=>"Erro PDO: ".$e->getMessage()]);
}
