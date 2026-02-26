<?php
// meta_favorita
session_start();
require_once "../config/conexao.php";

header('Content-Type: application/json');

if(!isset($_SESSION["usuario_id"])){
    echo json_encode(null);
    exit;
}

$usuario_id = $_SESSION["usuario_id"];

try {

    $sql = "SELECT * FROM simulacoes 
            WHERE usuario_id = :usuario_id 
            AND favorita = 1 
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
    $stmt->execute();

    $meta = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($meta ? $meta : null);

} catch (PDOException $e) {
    echo json_encode(null);
}
