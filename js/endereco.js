/*Esse código realiza uma requisição assíncrona para cadastrar um endereço no servidor utilizando XMLHttpRequest. Após o cadastro, trata a resposta do servidor exibindo mensagens de sucesso ou erro e limpando os campos do formulário em caso de erro. */
function insertEndereco(form) {
    // Cria uma nova instância do objeto XMLHttpRequest para fazer a requisição
    let xhr = new XMLHttpRequest();
    
    // Configura a requisição para enviar os dados do formulário para o arquivo enderecoController.php no servidor
    xhr.open('POST', '../enderecoController.php');
    
    // Define o tipo de resposta esperada como JSON
    xhr.responseType = 'json';

    // Define o que acontece quando a requisição é completada
    xhr.onload = function () {
        // Verifica se a requisição não foi bem sucedida ou se não houve resposta do servidor
        if (xhr.status != 200 || xhr.response == null) {
            console.log('Erro ao efetuar o cadastro de endereço');
            alert('Erro ao efetuar o cadastro de endereço');
            return false;
        }

        // Se a resposta foi bem sucedida, obtém o objeto JSON retornado pelo servidor
        const result = xhr.response;
        
        // Verifica se o cadastro do endereço foi realizado com sucesso
        if (result.success){
            // Se sim, exibe uma mensagem de sucesso e redireciona para a página de acesso restrito
            alert('Cadastro de endereço efetuado com sucesso');
            window.location.assign('acessoRestrito');
        } else {
            // Se não, exibe uma mensagem de erro e limpa os campos do formulário
            alert('Erro ao efetuar o cadastro de endereço');
            form.cep.value = "";
            form.logr.value = "";
            form.estado.value = "";
            form.cidade.value = "";
        }
    }
    
    // Envia a requisição
    xhr.send();
}

// Obtém o formulário com id "formCad"
var form = document.querySelector("#formCad");

// Define o evento onsubmit do formulário para chamar a função insertEndereco
form.onsubmit = function (e) {
    // Chama a função insertEndereco passando o formulário como parâmetro
    insertEndereco(form);
    
    // Previne o comportamento padrão do formulário de ser enviado
    e.preventDefault();
}
