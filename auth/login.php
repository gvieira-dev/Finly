<?php
session_start();
require_once("../config/conexao.php");

$erro = "";

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    if(empty($email) || empty($senha)){
        $erro = "Preencha todos os campos.";
    } else {

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);

        if($stmt->rowCount() === 1){

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if(password_verify($senha, $usuario["senha"])){

                $_SESSION["usuario_id"] = $usuario["id"];
                $_SESSION["usuario_nome"] = $usuario["nome"];

                header("Location: ../dashboard/index.php");
                exit();

            } else {
                $erro = "Senha incorreta.";
            }

        } else {
            $erro = "Usuário não encontrado.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Finly</title>

    <!-- Fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/login.css">
</head>
<body>

<div class="login-container">
    <div class="login-card">

        <h2>Bem-vindo de volta 👋</h2>
        <p>Entre na sua conta para continuar</p>

        <?php if(!empty($erro)): ?>
            <div class="login-error">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <input type="password" name="senha" placeholder="Senha" required>
            </div>

            <button type="submit" class="btn-login">
                Entrar
            </button>

        </form>

        <div class="login-link">
            Não tem conta? <a href="registro.php">Criar conta</a>
        </div>

    </div>
</div>

</body>
</html>
