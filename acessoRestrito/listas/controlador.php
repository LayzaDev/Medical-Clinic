<?php
    // Inclui os arquivos necessários para acessar as classes e estabelecer conexão com o banco de dados
    require '../../conexaoBanco.php';
    require '../../model/Agenda.php';
    require '../../model/Endereco.php';
    require '../../model/Paciente.php';
    require '../../model/Funcionario.php';

    // Estabelece a conexão com o banco de dados
    $pdo = mysqlConnect();

    // Obtém a ação a ser realizada a partir dos parâmetros da requisição GET
    $acao = $_GET['acao'];

    // Executa a ação de acordo com o valor recebido
    switch ($acao){
        case 'listagem_agenda_pessoal':
            // Obtém o email do médico a partir dos parâmetros da requisição GET ou define como vazio se não estiver presente
            $emailMedico = $_GET['email'] ?? "";

            // Obtém os agendamentos pessoais do médico com base no email fornecido
            $dados = Agenda::getAgendamentosMedico($pdo, $emailMedico);

            // Define o cabeçalho da resposta como JSON
            header('Content-type: application/json');
            // Retorna os dados como JSON
            echo json_encode($dados);
            break;
        case 'listagem_agenda':
            // Obtém todos os agendamentos
            $dados = Agenda::getAgendamentos($pdo);

            // Define o cabeçalho da resposta como JSON
            header('Content-type: application/json');
            // Retorna os dados como JSON
            echo json_encode($dados);
            break;
        case 'listagem_enderecos':
            // Obtém todos os CEPs dos endereços
            $dados = Endereco::getCEPs($pdo);

            // Define o cabeçalho da resposta como JSON
            header('Content-type: application/json');
            // Retorna os dados como JSON
            echo json_encode($dados);
            break;
        case 'listagem_funcionarios':
            // Obtém todos os funcionários
            $dados = Funcionario::getFuncionarios($pdo);

            // Define o cabeçalho da resposta como JSON
            header('Content-type: application/json');
            // Retorna os dados como JSON
            echo json_encode($dados);
            break;
        case 'listagem_pacientes':
            // Obtém todos os pacientes
            $dados = Paciente::getPacientes($pdo);

            // Define o cabeçalho da resposta como JSON
            header('Content-type: application/json');
            // Retorna os dados como JSON
            echo json_encode($dados);
            break;
        default:
            // Se nenhuma ação correspondente for encontrada, retorna uma mensagem de erro
            exit('Falha na solicitação de dados!');
            break;
    }
?>
