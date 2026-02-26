<?php
session_start();

if(!isset($_SESSION["usuario_id"])){
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Finly - Simulador Financeiro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonte Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/style.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            💰 <span>Finly</span>
        </div>

        <div class="username">
            👋 <?php echo htmlspecialchars($_SESSION["usuario_nome"]); ?>
        </div>

        <nav>
            <ul>
                <li class="active">Simulador</li>
                <li id="btn-historico">Suas Metas</li>
                <li id="btn-financeiro">Controle Financeiro</li>
            </ul>
        </nav>

        <div style="padding:20px;">
            <form action="../logout.php" method="POST">
                <button type="submit" class="btn-logout">
                    Sair
                </button>
            </form>
        </div>
    </aside>

    <!-- Área principal -->
    <main class="main-content">

        <div class="header">
            <h1>Construa sua Meta Financeira</h1>
            <p>Simule cenários e descubra quando você alcançará seu objetivo.</p>
        </div>

        <!-- META FAVORITA NO DASHBOARD (AGORA ACIMA DO FORM) -->
        <div id="meta-dashboard" class="card" style="display:none; margin-bottom: 20px;">
            <h2>
                ⭐ Sua Meta Atual
                <span id="remover-favorita" style="float:right; cursor:pointer; font-size:18px;">
                    ✖
                </span>
            </h2>
            
            <p id="meta-nome"></p>
            <p>🎯 Meta: <span id="meta-valor"></span></p>
            <p>💰 Guardado: <span id="meta-saldo"></span></p>

            <div class="barra-progresso">
                <div id="meta-progresso" class="progresso"></div>
            </div>

            <p id="meta-porcentagem"></p>
        </div>

        <!-- Dashboard: Form + Gráfico -->
        <div class="dashboard-wrapper">

            <!-- Formulário -->
            <div class="form-container">
                <div class="card">
                    <h2>Dados Financeiros</h2>
                    <form>
                        <div class="form-group">
                            <label>Salário mensal</label>
                            <input type="number" placeholder="R$ 0,00" id="inputSalario">
                        </div>
                        <div class="form-group">
                            <label>Gastos fixos mensais</label>
                            <input type="number" placeholder="R$ 0,00" id="inputGastos">
                        </div>
                        <div class="form-group">
                            <label>Valor da meta</label>
                            <input type="number" placeholder="R$ 0,00" id="inputMeta">
                        </div>
                        <div class="form-group">
                            <label>Renda extra mensal (opcional)</label>
                            <input type="number" placeholder="R$ 0,00" id="inputRendaExtra">
                        </div>
                        <div class="form-group">
                            <label>Nome da simulação / Objetivo</label>
                            <input type="text" placeholder="Ex: Viagem dos sonhos" id="inputNomeSimulacao">
                        </div>
                        <button type="button" class="btn-primary" id="btn">
                            Simular meta
                        </button>
                    </form>
                </div>
            </div>

            <!-- Gráfico flutuante -->
            <div class="grafico-container">
                <canvas id="graficoPagina"></canvas>
            </div>

        </div>

        <!-- Modal Resultado -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <span id="close" class="close">&times;</span>
                <h1>Resumo Financeiro</h1>
                <div id="modal-text"></div>
            </div>
        </div>

        <!-- Modal Histórico -->
        <div id="modal-historico" class="modal">
            <div class="modal-content modal-grande">
                <span id="close-historico" class="close">&times;</span>
                <h1>Histórico de Simulações</h1>
                <div id="historico">
                    <p>Nenhuma simulação ainda.</p>
                </div>
            </div>
        </div>

        <!-- Modal Controle Financeiro -->
        <div id="modal-financeiro" class="modal">
            <div class="modal-content modal-grande">
                <span id="close-financeiro" class="close">&times;</span>
                <h1>💰 Finly - Controle Financeiro</h1>
                <p class="subtitle">Controle simples das suas finanças</p>

                <div class="saldo">
                    <span>Saldo atual</span>
                    <h2 id="saldo">R$ 0,00</h2>
                </div>

                <form id="form">
                    <input type="text" id="descricao" placeholder="Descrição" required>
                    <input type="number" id="valor" placeholder="Valor" required>

                    <select id="tipo">
                        <option value="entrada">Entrada</option>
                        <option value="saida">Saída</option>
                    </select>

                    <button type="submit">Adicionar</button>
                </form>

                <button type="button" id="btn-limpar">🗑️ Limpar tudo</button>
                <ul id="lista"></ul>
            </div>
        </div>

    </main> 
</div>

<!-- Script JS -->
<script src="../assets/script.js"></script>
<script src="../assets/grafico.js"></script>

</body>
</html>
