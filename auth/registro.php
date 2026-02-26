<?php
// login
session_start();
require_once("../config/conexao.php");

$erro = "";
$sucesso = "";

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome  = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    if(empty($nome) || empty($email) || empty($senha)){

        $erro = "Preencha todos os campos.";

    } else {

        // Verifica se já existe usuário
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        if($stmt->rowCount() > 0){

            $erro = "Este email já está cadastrado.";

        } else {

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, $senhaHash]);

            $sucesso = "Conta criada com sucesso! Você já pode entrar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registro - Finly</title>

    <!-- Fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Mesmo CSS do login -->
    <link rel="stylesheet" href="../assets/login.css">
</head>
<body>

<div class="login-container">
    <div class="login-card">

        <h2>Crie sua conta 🚀</h2>
        <p>Comece a organizar suas finanças hoje</p>

        <?php if(!empty($erro)): ?>
            <div class="login-error">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($sucesso)): ?>
            <div class="login-success">
                <?php echo $sucesso; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <input type="text" name="nome" placeholder="Seu nome" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Seu email" required>
            </div>

            <div class="form-group">
                <input type="password" name="senha" placeholder="Sua senha" required>
            </div>

            <button type="submit" class="btn-login">
                Criar conta
            </button>

        </form>

        <div class="login-link">
            Já tem conta? <a href="login.php">Entrar</a>
        </div>

    </div>
</div>

</body>
</html>
