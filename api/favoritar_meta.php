<?php
// favoritar_meta
session_start();
require_once "../config/conexao.php";

header('Content-Type: application/json');

if(!isset($_SESSION["usuario_id"])){
    echo json_encode(["status" => "erro"]);
    exit;
}

$usuario_id = $_SESSION["usuario_id"];

$data = json_decode(file_get_contents("php://input"), true);

if(!isset($data["id"])){
    echo json_encode(["status" => "erro"]);
    exit;
}

$id = $data["id"];

try {

    // Remove favorita anterior
    $sqlReset = "UPDATE simulacoes 
                 SET favorita = 0 
                 WHERE usuario_id = :usuario_id";
    $stmtReset = $pdo->prepare($sqlReset);
    $stmtReset->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
    $stmtReset->execute();

    // Define nova favorita
    $sqlFav = "UPDATE simulacoes 
               SET favorita = 1 
               WHERE id = :id AND usuario_id = :usuario_id";
    $stmtFav = $pdo->prepare($sqlFav);
    $stmtFav->bindParam(":id", $id, PDO::PARAM_INT);
    $stmtFav->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
    $stmtFav->execute();

    echo json_encode(["status" => "ok"]);

} catch (PDOException $e) {
    echo json_encode(["status" => "erro"]);
}
