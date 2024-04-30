<?php

// Inclui o arquivo que contém a definição da classe Endereco e o arquivo de conexão com o banco de dados.
require 'model/Endereco.php';
require 'conexaoBanco.php';

// Estabelece uma conexão com o banco de dados MySQL.
$pdo = mysqlConnect();

// Recupera os dados do formulário HTML enviados via método POST.
$CEP = $_POST["cep"] ?? "";
$logr = $_POST["logradouro"] ?? "";
$estado = $_POST["estado"] ?? "";
$cidade = $_POST["cidade"] ?? "";

// Cria um novo objeto Endereco com os dados recuperados do formulário.
$novoEndereco = new Endereco(
    $CEP,
    $logr,
    $estado,
    $cidade
);

// Adiciona o endereço na tabela do banco de dados e armazena o resultado.
$resultado = $novoEndereco->insertEndereco($pdo);

// Verifica o resultado da inserção e redireciona o usuário de acordo com o resultado.
if ($resultado === 0) {
    // Se a inserção for bem-sucedida, exibe um alerta de sucesso e redireciona para a página inicial.
    echo '<script>alert("Endereço cadastrado com sucesso!");</script>';
    header("location: index.html");
} elseif ($resultado === 1) {
    // Se o endereço já estiver cadastrado, exibe um alerta e redireciona para a página de cadastro de endereço.
    echo '<script>alert("Endereço já cadastrado.");</script>';
    header("location: endereco.html");
} else {
    // Se ocorrer uma falha na inserção, exibe um alerta de falha e redireciona para a página de cadastro de endereço.
    echo '<script>alert("Falha ao cadastrar o endereço, tente novamente!");</script>';
    header("location: endereco.html");
}
?>
