// ===== ELEMENTOS DO DOM =====
const inputSalario = document.getElementById("inputSalario");
const inputGastos = document.getElementById("inputGastos");
const inputMeta = document.getElementById("inputMeta");
const inputRendaExtra = document.getElementById("inputRendaExtra");
const inputNomeSimulacao = document.getElementById("inputNomeSimulacao");
const btn = document.getElementById("btn");

// ===== MODAL DE RESUMO =====
const modal = document.getElementById("modal");
const modalText = document.getElementById("modal-text");
const closeBtn = document.getElementById("close");

// ===== MODAL HISTÓRICO =====
const btnHistorico = document.getElementById("btn-historico");
const modalHistorico = document.getElementById("modal-historico");
const closeHistorico = document.getElementById("close-historico");

// ===== MODAL CONTROLE FINANCEIRO =====
const btnFinanceiro = document.getElementById("btn-financeiro");
const modalFinanceiro = document.getElementById("modal-financeiro");
const closeFinanceiro = document.getElementById("close-financeiro");

const formFinanceiro = document.getElementById("form");
const descricaoInput = document.getElementById("descricao");
const valorInput = document.getElementById("valor");
const tipoInput = document.getElementById("tipo");
const listaTransacoes = document.getElementById("lista");
const saldoElement = document.getElementById("saldo");
const btnLimpar = document.getElementById("btn-limpar");

let transacoes = [];

// ===== FUNÇÕES MODAIS =====
function abrirModal(texto){
    modalText.innerHTML = texto;
    modal.style.display = "flex";
}

// Fechar modais
closeBtn.addEventListener("click", () => modal.style.display = "none");
closeHistorico.addEventListener("click", () => modalHistorico.style.display = "none");
closeFinanceiro.addEventListener("click", () => modalFinanceiro.style.display = "none");

window.addEventListener("click", (e) => {
    if(e.target === modal) modal.style.display = "none";
    if(e.target === modalHistorico) modalHistorico.style.display = "none";
    if(e.target === modalFinanceiro) modalFinanceiro.style.display = "none";
});

// ===== BOTÃO SIMULAR =====
btn.addEventListener("click", calcular);

// ===== BOTÃO HISTÓRICO =====
btnHistorico.addEventListener("click", () => {
    carregarHistorico();
    modalHistorico.style.display = "flex";
});

// ===== BOTÃO FINANCEIRO =====
btnFinanceiro.addEventListener("click", () => {
    modalFinanceiro.style.display = "flex";
    carregarTransacoes();
});

// ===== FUNÇÃO DE VALIDAÇÃO =====
function validarValor(valor, minimo){
    return !Number.isNaN(valor) && valor >= minimo;
}

// ===== FUNÇÃO PRINCIPAL SIMULAÇÃO =====
function calcular(){
    const salario = Number(inputSalario.value);
    const gastos = Number(inputGastos.value);
    const meta = Number(inputMeta.value);
    const extra = Number(inputRendaExtra.value);
    const nomeSimulacao = inputNomeSimulacao.value.trim();

    if(!validarValor(salario,1)) return alert("Salário Inválido!");
    if(!validarValor(gastos,0)) return alert("Gasto Inválido!");
    if(!validarValor(meta,1)) return alert("Meta Inválida!");
    if(!validarValor(extra,0)) return alert("Renda Inválida!");
    if(nomeSimulacao === "") return alert("Dê um nome para sua simulação!");

    const sobra = salario - gastos;
    const valorMensal = sobra + extra;

    if(!validarValor(valorMensal,1)){
        alert("Seus gastos são maiores ou iguais à sua renda.");
        return;
    }

    const meses = Math.ceil(meta / valorMensal);
    const anos = Math.floor(meses / 12);
    const mesesRestantes = meses % 12;

    let tempoTexto = "";
    if(anos > 0 && mesesRestantes > 0){
        tempoTexto = `${anos} ano(s) e ${mesesRestantes} mês(es)`;
    } else if(anos > 0){
        tempoTexto = `${anos} ano(s)`;
    } else {
        tempoTexto = `${meses} mês(es)`;
    }

    abrirModal(`
        <p>🏷️ Objetivo: <strong>${nomeSimulacao}</strong></p>
        <p>💰 Você pode guardar: <span class="valor-mensal">R$ ${valorMensal.toFixed(2)}</span> por mês</p>
        <p>🎯 Meta: <span class="meta">R$ ${meta.toFixed(2)}</span></p>
        <p>⏳ Tempo estimado: <span class="tempo">${tempoTexto}</span></p>
    `);

    const simulacao = {
        nome: nomeSimulacao,
        salario: salario.toFixed(2),
        gastos: gastos.toFixed(2),
        meta: meta.toFixed(2),
        extra: extra.toFixed(2),
        valorMensal: valorMensal.toFixed(2),
        tempoTexto: tempoTexto
    };

    fetch("../api/salvar_simulacao.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(simulacao)
    })
    .then(res => res.json())
    .then(data => {
        if(data.status !== "ok"){
            console.error("Erro ao salvar:", data);
        }
    })
    .catch(err => console.error("Erro:", err));
}

// ===== FUNÇÃO HISTÓRICO =====
function carregarHistorico(){
    const historicoContainer = document.getElementById("historico");
    historicoContainer.innerHTML = "";

    fetch("../api/listar_simulacoes.php")
        .then(res => res.json())
        .then(historico => {
            if(historico.length === 0){
                historicoContainer.innerHTML = "<p>Nenhuma simulação ainda.</p>";
                return;
            }

            historico.forEach(simulacao => {
                const card = document.createElement("div");
                card.classList.add("sim-card");
                card.style.position = "relative";

                const excluirBtn = document.createElement("span");
                excluirBtn.classList.add("close");
                excluirBtn.textContent = "×";
                excluirBtn.addEventListener("click", () => {
                    fetch("../api/excluir_simulacao.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: simulacao.id })
                    }).then(() => carregarHistorico());
                });

                card.appendChild(excluirBtn);

                const conteudo = document.createElement("div");
                conteudo.innerHTML = `
                    <p>🏷️ <strong>${simulacao.nome}</strong></p>
                    <p>💰 Você pode guardar: <span class="valor-mensal">R$ ${simulacao.valor_mensal}</span> por mês</p>
                    <p>🎯 Meta: <span class="meta">R$ ${simulacao.meta}</span></p>
                    <p>⏳ Tempo estimado: <span class="tempo">${simulacao.tempo}</span></p>
                    <p>🗓️ Data: ${simulacao.data}</p>
                `;

                card.appendChild(conteudo);

                
                // ⭐ BOTÃO FAVORITAR
                const favoritarBtn = document.createElement("span");
                favoritarBtn.innerHTML = "⭐";
                favoritarBtn.classList.add("btn-favoritar");

                favoritarBtn.addEventListener("click", () => {
                    fetch("../api/favoritar_meta.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: simulacao.id })
                    })
                    .then(res => res.json())
                    .then(() => {
                        carregarHistorico();
                        carregarMetaDashboard();
                    });
                });

                card.appendChild(favoritarBtn);

                historicoContainer.appendChild(card);
            });
        })
        .catch(err => console.error("Erro ao carregar histórico:", err));
}


// ===== FUNÇÕES CONTROLE FINANCEIRO =====
function atualizarFinanceiro() {
    listaTransacoes.innerHTML = "";

    let saldo = 0;

    transacoes.forEach(t => {
        const li = document.createElement("li");
        const valor = parseFloat(t.valor);

        if(t.tipo === "entrada"){
            // Entrada → verde
            li.innerHTML = `${t.descricao} - <span style="color:green;">R$ ${valor.toFixed(2)}</span>`;
            saldo += valor;
        } else {
            // Saída → vermelho
            li.innerHTML = `${t.descricao} - <span style="color:red;">R$ ${valor.toFixed(2)}</span>`;
            saldo -= valor;
        }

        listaTransacoes.appendChild(li);
    });

    // Saldo geral
    saldoElement.textContent = `R$ ${saldo.toFixed(2)}`;
    saldoElement.style.color = saldo >= 0 ? "green" : "red";

    carregarMetaDashboard();

}


function carregarTransacoes() {
    fetch("../api/listar_transacoes.php")
        .then(res => res.json())
        .then(data => {
            transacoes = data || [];
            atualizarFinanceiro();
        })
        .catch(err => console.error("Erro ao carregar transações:", err));
}


// ===== LIMPAR TUDO =====
btnLimpar.addEventListener("click", () => {
    if(confirm("Deseja realmente limpar todas as transações?")){
        fetch("../api/limpar_transacoes.php", { method: "POST" })
            .then(res => res.json())
            .then(data => {
                if(data.status === "ok"){
                    transacoes = [];
                    atualizarFinanceiro();
                } else {
                    alert("Erro ao limpar transações!");
                }
            })
            .catch(err => console.error("Erro ao limpar transações:", err));
    }
});


// ===============================
// ⭐ META FAVORITA NO DASHBOARD
// ===============================

const metaDashboard = document.getElementById("meta-dashboard");
const metaNome = document.getElementById("meta-nome");
const metaValor = document.getElementById("meta-valor");
const metaSaldo = document.getElementById("meta-saldo");
const metaProgresso = document.getElementById("meta-progresso");
const metaPorcentagem = document.getElementById("meta-porcentagem");

const btnRemoverFavorita = document.getElementById("remover-favorita");

if(btnRemoverFavorita){
    btnRemoverFavorita.addEventListener("click", () => {

        fetch("../api/remover_favorita.php", {
            method: "POST"
        })
        .then(res => res.json())
        .then(() => {
            metaDashboard.style.display = "none";
            carregarHistorico();
        });

    });
}


function carregarMetaDashboard(){

    if(!metaDashboard) return; // segurança

    fetch("../api/meta_favorita.php")
        .then(res => res.json())
        .then(meta => {

            if(!meta){
                metaDashboard.style.display = "none";
                return;
            }

            // pega saldo atual direto da tela
            let saldoTexto = saldoElement.textContent.replace("R$","").replace(",",".");
            let saldoAtual = parseFloat(saldoTexto) || 0;

            let valorMetaNumero = parseFloat(meta.meta);

            let porcentagem = (saldoAtual / valorMetaNumero) * 100;

            if(porcentagem > 100) porcentagem = 100;
            if(porcentagem < 0) porcentagem = 0;

            metaDashboard.style.display = "block";
            metaNome.innerHTML = "🏷️ <strong>" + meta.nome + "</strong>";
            metaValor.textContent = "R$ " + valorMetaNumero.toFixed(2);
            metaSaldo.textContent = "R$ " + saldoAtual.toFixed(2);
            metaProgresso.style.width = porcentagem + "%";
            metaPorcentagem.textContent = 
                "Progresso: " + porcentagem.toFixed(1) + "%";
        })
        .catch(err => console.error("Erro ao carregar meta favorita:", err));
}

window.addEventListener("DOMContentLoaded", () => {
    carregarTransacoes(); // já calcula saldo
    carregarMetaDashboard(); // depois calcula barra
});


// Pegando o canvas
const ctxPagina = document.getElementById('graficoPagina').getContext('2d');

// Inicializa o gráfico
let graficoPagina = new Chart(ctxPagina, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Saldo',
            data: [],
            fill: true,
            backgroundColor: 'rgba(99,102,241,0.1)', // azul suave
            borderColor: '#6366f1',
            tension: 0.3,
            pointRadius: 0,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: { duration: 800 },
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { color: '#6b7280' } },
            y: { grid: { color: '#e5e7eb' }, ticks: { color: '#6b7280' } }
        },
        elements: { line: { borderWidth: 3 } }
    }
});

// Função para atualizar o gráfico
function atualizarGraficoPagina() {
    let saldo = 0;
    const labels = [];
    const data = [];

    // Adiciona ponto inicial para garantir atualização na primeira transação
    labels.push(0);
    data.push(saldo);

    transacoes.forEach((t, i) => {
        saldo += t.tipo === 'entrada' ? parseFloat(t.valor) : -parseFloat(t.valor);
        labels.push(i + 1); // número da transação
        data.push(saldo);
    });

    graficoPagina.data.labels = labels;
    graficoPagina.data.datasets[0].data = data;

    // Muda cor da linha se saldo negativo
    if (data[data.length - 1] < 0) {
        graficoPagina.data.datasets[0].borderColor = '#ef4444'; // vermelho
        graficoPagina.data.datasets[0].backgroundColor = 'rgba(239,68,68,0.1)';
    } else {
        graficoPagina.data.datasets[0].borderColor = '#6366f1'; // azul
        graficoPagina.data.datasets[0].backgroundColor = 'rgba(99,102,241,0.1)';
    }

    graficoPagina.update();
}

// Atualiza gráfico ao carregar transações
function carregarTransacoesGrafico() {
    fetch("../api/listar_transacoes.php")
        .then(res => res.json())
        .then(data => {
            transacoes = data || [];
            atualizarFinanceiro();       // atualiza lista e saldo
            atualizarGraficoPagina();   // atualiza gráfico
        })
        .catch(err => console.error("Erro ao carregar transações:", err));
}

// Atualiza ao adicionar transação
formFinanceiro.addEventListener("submit", e => {
    e.preventDefault();
    const descricao = descricaoInput.value.trim();
    const valor = parseFloat(valorInput.value);
    const tipo = tipoInput.value;

    if(!descricao || isNaN(valor) || valor <= 0){
        return alert("Preencha todos os campos corretamente!");
    }

    const transacao = { descricao, valor, tipo };

    fetch("../api/adicionar_transacao.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(transacao)
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === "ok"){
            transacoes.push(transacao);
            atualizarFinanceiro();
            atualizarGraficoPagina(); // <=== atualiza gráfico
            formFinanceiro.reset();
        } else {
            alert("Erro ao adicionar transação!");
        }
    })
    .catch(err => console.error(err));
});

// Atualiza ao limpar todas as transações
btnLimpar.addEventListener("click", () => {
    if(confirm("Deseja realmente limpar todas as transações?")){
        fetch("../api/limpar_transacoes.php", { method: "POST" })
            .then(res => res.json())
            .then(data => {
                if(data.status === "ok"){
                    transacoes = [];
                    atualizarFinanceiro();
                    atualizarGraficoPagina(); // <=== atualiza gráfico
                } else {
                    alert("Erro ao limpar transações!");
                }
            })
            .catch(err => console.error(err));
    }
});

// Chamada inicial ao carregar a página
window.addEventListener("DOMContentLoaded", () => {
    carregarTransacoesGrafico();
});
