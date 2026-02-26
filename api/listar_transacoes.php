<?php
// listar_transacoes
session_start();
header('Content-Type: application/json');

// Evita warnings
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

if(!isset($_SESSION["usuario_id"])){
    echo json_encode([]);
    exit;
}

$usuario_id = $_SESSION["usuario_id"];
require_once __DIR__ . '/../config/conexao.php';

try {
    $stmt = $pdo->prepare("
        SELECT descricao, valor, tipo, DATE_FORMAT(data,'%d/%m/%Y %H:%i') AS data
        FROM transacoes
        WHERE usuario_id = ?
        ORDER BY data DESC
    ");
    $stmt->execute([$usuario_id]);
    $transacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($transacoes);

} catch(PDOException $e){
    echo json_encode([]);
}
