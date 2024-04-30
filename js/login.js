/*Esse código JavaScript é responsável por enviar os dados de um formulário para o servidor e lidar com a resposta. Ele utiliza a função fetch para fazer a requisição assíncrona, trata a resposta e realiza ações com base no resultado. */
async function sendForm(form) {
    try {
        // Aqui estamos usando fetch para enviar os dados do formulário para o servidor
        const response = await fetch("model/login.php", { method: 'post', body: new FormData(form) });
        
        // Verificamos se a resposta da requisição é bem sucedida (status 200-299)
        if (!response.ok) throw new Error(response.statusText);
        
        // Se a resposta for bem sucedida, obtemos o texto do corpo da resposta
        var bodyText = await response.text();
        
        // Em seguida, tentamos analisar o corpo do texto como JSON
        const result = JSON.parse(bodyText);

        // Se a análise do JSON for bem sucedida e o resultado indicar sucesso
        if (result.success)
            // Redirecionamos o usuário para a página de acesso restrito
            window.location.assign('acessoRestrito');
        else {
            // Se não houver sucesso, exibimos uma mensagem de erro no elemento com id "loginFailMsg"
            document.querySelector("#loginFailMsg").style.display = 'block';
            
            // Também exibimos um alerta ao usuário informando que o usuário/senha está incorreto
            window.alert("Usuário e/ou senha incorreta. Por favor, tente novamente.");
            
            // Limpa o campo de senha do formulário
            form.senha.value = "";
            
            // Coloca o foco novamente no campo de senha para que o usuário possa digitar novamente
            form.senha.focus();
        }
    }
    catch (e) {
        // Se ocorrer algum erro durante o processo, exibimos o corpo da resposta e o erro no console
        console.log(bodyText ?? "");
        console.error(e);
    }
}

// Obtém o formulário com id "formulario"
const form = document.querySelector("#formulario");

// Define o evento onsubmit do formulário para chamar a função sendForm
form.onsubmit = function (e) {
    // Chama a função sendForm passando o formulário como parâmetro
    sendForm(form);
    
    // Previne o comportamento padrão do formulário de ser enviado
    e.preventDefault();
}
