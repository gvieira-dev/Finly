<?php
// remover_favorita
session_start();
require_once "../config/conexao.php";

header('Content-Type: application/json');

if(!isset($_SESSION["usuario_id"])){
    echo json_encode(["status" => "erro"]);
    exit;
}

$usuario_id = $_SESSION["usuario_id"];

try {

    $sql = "UPDATE simulacoes 
            SET favorita = 0 
            WHERE usuario_id = :usuario_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(["status" => "ok"]);

} catch (PDOException $e) {
    echo json_encode(["status" => "erro"]);
}
