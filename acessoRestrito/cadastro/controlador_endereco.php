<?php
  // Inclui o arquivo que contém a definição da classe Endereco e o arquivo de conexão com o banco de dados.
  require '../../model/Endereco.php';
  require '../../conexaoBanco.php';

  // Estabelece uma conexão com o banco de dados.
  $pdo = mysqlConnect();

  // Verifica se a variável 'acao' foi enviada via método GET, se não, define seu valor como uma string vazia.
  $acao = $_GET['acao'] ?? '';

  // Se a ação for 'getEndereco', realiza a seguinte operação:
  if($acao == 'getEndereco'){
    // Obtém o valor do parâmetro 'cep' enviado via método GET, se não estiver definido, define como uma string vazia.
    $cep = $_GET['cep'] ?? '';
    
    // Chama o método estático 'getCEP' da classe Endereco, passando a conexão PDO e o CEP como parâmetros. Retorna os dados do endereço correspondente.
    $dados = Endereco::getCEP($pdo, $cep);

    // Define o cabeçalho HTTP para indicar que a resposta será no formato JSON.
    header('Content-type: application/json');

    // Codifica os dados do endereço em formato JSON e os imprime na saída.
    echo json_encode($dados);
  }
?>
