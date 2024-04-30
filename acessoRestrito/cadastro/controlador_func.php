<?php
// Inclui o arquivo de conexão com o banco de dados.
require '../../conexaoBanco.php';

// Estabelece uma conexão com o banco de dados.
$pdo = mysqlConnect();

// Resgata os dados da pessoa do formulário enviado via método POST.
$nome = $_POST["nome"] ?? "";
$sexo = $_POST["sexo"] ?? "";
$email = $_POST["email"] ?? "";
$telefone = $_POST["telefone"] ?? "";
$CEP = $_POST["cep"] ?? "";
$logradouro = $_POST["logradouro"] ?? "";
$cidade = $_POST["cidade"] ?? "";
$estado = $_POST["estado"] ?? "";

// Resgata os atributos específicos de Funcionário.
$dt_contrato = $_POST["data"] ?? "";
$salario = $_POST["salario"] ?? "";
$senha = $_POST["senha"] ?? "";

// Resgata os atributos específicos de Médico, se o vínculo for igual a "M".
$vinculo = $_POST["vinculo"] ?? "";
$crm = $_POST["crm"] ?? "";
$especialidade = $_POST["especialidade"] ?? "";

// Criptografa a senha antes de armazená-la no banco de dados.
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Prepara as consultas SQL para inserir os dados nas respectivas tabelas do banco de dados.
$sql1 = <<<SQL
INSERT INTO Pessoa (nome, sexo, email, telefone, CEP, logradouro, cidade, estado)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
SQL;

$sql2 = <<<SQL
INSERT INTO Funcionario (dt_contrato, salario, senhaHash, id_pessoa)
VALUES (?, ?, ?, ?)
SQL;

$sql3 = null;

// Se o vínculo for "M", prepara a consulta SQL para inserir os dados do Médico.
if($vinculo == "M"){
  $sql3 = <<<SQL
  INSERT INTO Medico (especialidade, crm, id_funcionario)
  VALUES (?, ?, ?)
  SQL;
}

try {
  // Inicia uma transação no banco de dados.
  $pdo->beginTransaction();

  // Prepara e executa a primeira consulta SQL para inserir os dados da Pessoa.
  $stmt1 = $pdo->prepare($sql1);
  if(!$stmt1->execute([
    $nome, 
    $sexo, 
    $email, 
    $telefone, 
    $CEP, 
    $logradouro,  
    $cidade, 
    $estado
  ])) throw new Exception("Falha na primeira inserção");

  // Obtém o ID da pessoa recém-inserida.
  $id_pessoa = $pdo->lastInsertId();

  // Prepara e executa a segunda consulta SQL para inserir os dados do Funcionário.
  $stmt2 = $pdo->prepare($sql2);
  if(!$stmt2->execute([
    $dt_contrato, 
    $salario, 
    $senhaHash, 
    $id_pessoa
  ])) throw new Exception("Falha na segunda inserção");

  // Obtém o ID do funcionário recém-inserido.
  $id_funcionario = $pdo->lastInsertId();

  // Se a consulta SQL para o Médico foi preparada, prepara e executa a terceira consulta SQL para inserir os dados do Médico.
  if($sql3 != null){
    $stmt3 = $pdo->prepare($sql3);
    if(!$stmt3->execute([
      $especialidade,
      $crm,
      $id_funcionario
    ])) throw new Exception("Falha na terceira inserção");
  }

  // Comita a transação, confirmando as operações no banco de dados.
  $pdo->commit();

} catch (Exception $e) {
  // Se ocorrer uma exceção, executa rollback para desfazer as alterações feitas durante a transação.
  $pdo->rollBack();
  // Imprime uma mensagem de erro com informações sobre a exceção.
  exit('Rollback executado: ' . $e->getMessage());
}
?>
