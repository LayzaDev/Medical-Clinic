/*Este código faz uma solicitação assíncrona para obter informações de endereço do servidor com base no CEP fornecido pelo usuário. Quando o usuário digita algo no campo de CEP (inputCep.onkeyup), a função busca_endereco é chamada para iniciar a busca do endereço correspondente ao CEP digitado. */
async function busca_endereco(cep){
  // Verifica se o comprimento do CEP é diferente de 9 caracteres (considerando a máscara de CEP usual)
  if (cep.length != 9) return;

  try {
    // Cria uma nova instância do objeto XMLHttpRequest para fazer a requisição
    let xhr = new XMLHttpRequest();
    
    // Configura a requisição para obter o endereço do servidor usando o CEP fornecido como parâmetro
    xhr.open("GET", "../cadastro/controlador_endereco.php?acao=getEndereco&cep="+cep);
    
    // Define o tipo de resposta esperada como JSON
    xhr.responseType = 'json';
  
    // Define o que acontece quando a requisição é completada
    xhr.onload = function () {
      // Verifica se a requisição foi bem sucedida e se há uma resposta do servidor
      if (xhr.status != 200 || xhr.response === null) {
        console.log("Resposta não obtida");
        return;
      }

      // Obtém o objeto JSON retornado pelo servidor com as informações do endereço
      const endereco = xhr.response;
      
      // Obtém o formulário com id "formCad"
      let form = document.querySelector("#formCad");
      
      // Preenche os campos do formulário com as informações do endereço obtido
      form.logradouro.value = endereco.logradouro;
      form.cidade.value = endereco.cidade;
      form.estado.value = endereco.estado;
    };

    // Define o que acontece em caso de erro na requisição
    xhr.onerror = function () {
      console.error("Requisição não finalizada");
      return;
    };

    // Envia a requisição
    xhr.send();
  } catch (error) {
    // Captura e trata qualquer erro que ocorra durante o processo
    console.error('Erro ao fazer requisição:', error);
  }
}

// Define um evento para quando a página é carregada
window.onload = function () {
  // Obtém o elemento de entrada de CEP
  const inputCep = document.querySelector("#cep");
  
  // Define um evento para quando o usuário digitar algo no campo de CEP
  inputCep.onkeyup = () => busca_endereco(inputCep.value);
}
