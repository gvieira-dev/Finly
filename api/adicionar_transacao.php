<?php
// adicionar_transacao
session_start();
header('Content-Type: application/json');

// Evita warnings que quebram JSON
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

if(!isset($_SESSION["usuario_id"])){
    echo json_encode(["status"=>"erro","mensagem"=>"Usuário não logado"]);
    exit;
}

$usuario_id = $_SESSION["usuario_id"];
$data = json_decode(file_get_contents('php://input'), true);

// Conexão
require_once __DIR__ . '/../config/conexao.php';

// Validação
if(empty($data['descricao'])){
    echo json_encode(["status"=>"erro","mensagem"=>"Descrição vazia","recebido"=>$data]);
    exit;
}

if(!isset($data['valor']) || !is_numeric($data['valor'])){
    echo json_encode(["status"=>"erro","mensagem"=>"Valor inválido","recebido"=>$data]);
    exit;
}

if(!isset($data['tipo']) || !in_array($data['tipo'], ['entrada','saida'])){
    echo json_encode(["status"=>"erro","mensagem"=>"Tipo inválido","recebido"=>$data]);
    exit;
}

$descricao = $data['descricao'];
$valor = floatval($data['valor']);
$tipo = $data['tipo'];

try {
    $stmt = $pdo->prepare("INSERT INTO transacoes (usuario_id, descricao, valor, tipo) VALUES (?, ?, ?, ?)");
    $stmt->execute([$usuario_id, $descricao, $valor, $tipo]);

    echo json_encode(["status"=>"ok"]);

} catch(PDOException $e){
    echo json_encode([
        "status"=>"erro",
        "mensagem"=>"Erro PDO: ".$e->getMessage(),
        "recebido"=>$data
    ]);
}
