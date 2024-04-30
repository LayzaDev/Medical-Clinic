// Função para selecionar os médicos de acordo com a especialidade escolhida
function selectMedicos() {
    var especialidade = document.getElementById('especialidade').value;
    var medicoSelect = document.getElementById('medico');

    // Cria uma nova instância do objeto XMLHttpRequest para fazer a requisição
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'agendamentoController.php?acao=getMedicosEspecialidade&param='+especialidade);
    xhr.responseType = 'json';

    // Define o que acontece quando a requisição é completada
    xhr.onload = function(){
        // Verifica se a requisição foi bem sucedida e se há uma resposta do servidor
        if(xhr.status != 200 || xhr.response == null){
            console.log('Erro ao solicitar a requisição');
            return false;
        }

        // Obtém os dados de resposta do servidor
        const dados = xhr.response;

        // Limpa as opções existentes no elemento select de médicos
        medicoSelect.innerHTML = '';

        // Cria e adiciona uma opção padrão no elemento select de médicos
        var opcao = document.createElement('option');
        opcao.text = 'Selecione um médico';
        opcao.value = '';
        medicoSelect.appendChild(opcao);

        // Itera sobre os dados de médicos recebidos do servidor
        for (let i = 0; i < dados.length; i++) {
            // Cria e adiciona uma opção para cada médico no elemento select de médicos
            var opcao = document.createElement('option');
            opcao.text = dados[i].nome;
            opcao.value = dados[i].id_medico;
            medicoSelect.appendChild(opcao);
        }
    }
    // Envia a requisição
    xhr.send();
}

// Função para selecionar os horários disponíveis de um médico em uma data específica
function selectHorario() {
    let medico = document.getElementById('medico').value;
    let data = document.getElementById('data').value;
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'agendamentoController.php?acao=getHorarios&medico='+medico+'&data='+data)
    xhr.responseType = 'json';

    // Define o que acontece quando a requisição é completada
    xhr.onload = function(){
        // Verifica se a requisição foi bem sucedida e se há uma resposta do servidor
        if(xhr.status != 200 || xhr.response == null){
            console.log('Erro ao efetuar requisição de horários disponíveis.');
            return false;
        }

        // Obtém os dados de resposta do servidor
        const dados = xhr.response;

        // Obtém o elemento select de horários
        var horario = document.getElementById('horario');
    
        // Limpa as opções existentes no elemento select de horários
        horario.innerHTML = '';
    
        // Cria e adiciona uma opção padrão no elemento select de horários
        var opcao = document.createElement('option');
        opcao.text = 'Selecione um horário';
        opcao.value = '';
        horario.appendChild(opcao);

        // Itera sobre os horários disponíveis recebidos do servidor
        for (let i = 8; i < 18; i++) {
            if (!dados.includes(i+':00') && !dados.includes('0'+i+':00')){
                // Se o horário não estiver na lista de horários ocupados, cria e adiciona uma opção para o horário no elemento select de horários
                var opcao = document.createElement('option');
                opcao.text = i.toString() + ':00';
                opcao.value = i.toString() + ':00';
                horario.appendChild(opcao);
            }
        }
    }
    // Envia a requisição
    xhr.send();
}

// Função que é executada quando a página é carregada
window.onload = function(){
    // Faz uma requisição para obter as especialidades dos médicos e preencher o elemento select de especialidades
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'agendamentoController.php?acao=getEspecialidadeMedicos');
    xhr.responseType = 'json';
    
    // Define o que acontece quando a requisição é completada
    xhr.onload = function(){
        // Verifica se a requisição foi bem sucedida e se há uma resposta do servidor
        if(xhr.status != 200 || xhr.response == null){
            console.log('Erro ao realizar as solicitações');
            console.log(xhr.status);
            return false;
        }
        
        // Obtém os dados de resposta do servidor
        const dados = xhr.response;
        var especialidade = document.getElementById('especialidade');

        // Itera sobre as especialidades recebidas do servidor e preenche o elemento select de especialidades
        for(i = 0; i < dados.length; i++){
            var opcao = document.createElement('option');
            opcao.text = dados[i];
            opcao.value = dados[i];
            especialidade.appendChild(opcao);
        }
    }

    // Define o que acontece em caso de erro na requisição
    xhr.onerror = function(){
        alert('Erro ao efetuar a requisição das especialidades.');
    }

    // Envia a requisição
    xhr.send();
}

// Obtém o formulário de cadastro de agenda
var form = document.getElementById('cadAgenda');

// Define o que acontece quando o formulário é submetido
form.onsubmit = async function(e){
    // Previne o comportamento padrão de submissão do formulário
    e.preventDefault();

    // Cria um objeto FormData com os dados do formulário
    let dados = new FormData(form);

    // Configura as opções para a requisição fetch
    const opcoes = {
        method: 'POST',
        body: dados
    }

    // Faz uma requisição fetch para enviar os dados do formulário para o servidor
    let envioForm = await fetch('agendamentoController.php', opcoes);

    // Obtém a resposta do servidor
    let resposta = await envioForm.json();

    // Verifica se a resposta indica que a consulta da agenda foi bem sucedida
    if(resposta){
        // Exibe uma mensagem de sucesso
        alert('Consulta agenda!');

        // Limpa as opções existentes no elemento select de horários
        var horario = document.getElementById('horario');
        horario.innerHTML = '';

        // Cria e adiciona uma opção padrão no elemento select de horários
        var opcao = document.createElement('option');
        opcao.text = 'Horário Consulta';
        opcao.value = '';
        horario.appendChild(opcao);

        // Reseta o formulário
        form.reset();
    } else {
        // Se a resposta indica falha, exibe uma mensagem de erro
        let span = document.querySelector('span#avisoErro');
        span.textContent = 'Erro ao enviar o formulário';
        span.style = 'display: inline-block';
    }
}
