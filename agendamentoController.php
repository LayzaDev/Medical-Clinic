<?php
// Inclui os arquivos necessários e estabelece a conexão com o banco de dados.
require 'model/Agenda.php';
require 'model/Medico.php';
require 'conexaoBanco.php';
$pdo = mysqlConnect();

// Obtém a ação da requisição GET, ou define como vazio caso não esteja definida.
$acao = $_GET['acao'] ?? '';

// Executa ação com base no valor obtido.
switch($acao){
    case 'getEspecialidadeMedicos':
        // Obtém as especialidades dos médicos do banco de dados.
        $dados = Medico::getEspecialidades($pdo);

        // Define o cabeçalho HTTP para indicar que a resposta será no formato JSON.
        header('Content-type: application/json');

        // Retorna os dados em formato JSON.
        echo json_encode($dados);
        break;
    case 'getMedicosEspecialidade':
        // Obtém os médicos de uma especialidade específica do banco de dados.
        $e = $_GET['param'] ?? '';
        $dados = Medico::getMedicosEspecialidade($pdo, $e);

        // Define o cabeçalho HTTP para indicar que a resposta será no formato JSON.
        header('Content-type: application/json');

        // Retorna os dados em formato JSON.
        echo json_encode($dados);
        break;
    case 'getHorarios':
        // Obtém os horários disponíveis para um médico em uma determinada data.
        $m = $_GET['medico'] ?? '';
        $d = $_GET['data'] ?? '';

        $dados = Agenda::getAgendamentosMedicoData($pdo, $m, $d);

        // Define o cabeçalho HTTP para indicar que a resposta será no formato JSON.
        header('Content-type: application/json');

        // Retorna os dados em formato JSON.
        echo json_encode($dados);
        break;
}

// Verifica se foram recebidos dados via POST.
$dadosPost = $_POST ?? '';

// Se dados foram recebidos via POST e não estão vazios, processa o agendamento.
if($dadosPost != '' && !empty($dadosPost)){
    // Adiciona um novo agendamento ao banco de dados com base nos dados recebidos via POST.
    $agendamento = Agenda::addAgenda($pdo, $dadosPost);

    // Define o cabeçalho HTTP para indicar que a resposta será no formato JSON.
    header('Content-type: application/json');

    // Retorna os dados do agendamento em formato JSON.
    echo json_encode($agendamento);

    // Termina a execução do script.
    die;
}
?>
