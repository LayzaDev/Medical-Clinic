<?php

session_start();

$email = $_SESSION['user'] ?? "";

if(trim($email) == "")
    header("location: ../../login.html");

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitalize</title>

    <!-- Links CSS -->
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/lista.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header>
        <img src="../../images/logomarca.png" alt="Logomarca da Vitalize">
    </header>
    <nav>
        <ul>
            <li><a href="../../">Home</a></li>
            <li class="flexPeso"><a href="../">Início Adminsitrativo</a></li>
            <li><a href="../cadastro">Cadastro</a></li>
            <li><a href="../listas">Listagem</a></li>
        </ul>
    </nav>
    <main>
        <h1>Meus Agendamentos</h1>
        <div class="table-responsive">
            <table id="tabela" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="dt-center">#</th>
                        <th class="dt-center">Nome</th>
                        <th class="dt-center">Data</th>
                        <th class="dt-center">Horário</th>
                        <th class="dt-center">Contato</th>
                        <th class="dt-center">Especialidade</th>
                        <th class="dt-center">Médico</th>
                        <th class="dt-center">Sexo</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>
    </main>
    <footer>
        <p>&copy; Todos os direitos são reservados à Vitalize.</p>
    </footer>
    <script>
    // Cria uma única instância do objeto XMLHttpRequest
    let xhr = new XMLHttpRequest();
    
    // Define a URL da requisição GET com ação "listagem_agenda_pessoal" e o email como parâmetro
    xhr.open('GET', 'controlador.php?acao=listagem_agenda_pessoal&email=<?php echo $email;?>');
    
    // Define o tipo de resposta esperada como JSON
    xhr.responseType = 'json';

    // Define o que acontece quando a requisição é completada
    xhr.onload = function (){
        // Verifica se a requisição foi bem sucedida e se há uma resposta do servidor
        if (xhr.status != 200 || xhr.response === null) {
            console.log("A resposta não pode ser obtida ");
            console.log(xhr.status);
            return;
        }

        // Obtém os dados da resposta do servidor
        const dados = xhr.response;            

        // Obtém a tabela no documento HTML
        const tabela = document.querySelector('#tabela tbody');

        // Itera sobre os dados obtidos e preenche a tabela com eles
        for(i = 0; i < dados.length; i++){
            let text = '';
            text += '<td class="dt-center">'+dados[i].id_agenda+'</td>'
            text += '<td class="dt-center">'+dados[i].nome+'</td>'
            text += '<td class="dt-center">'+dados[i].dt_agenda+'</td>'
            text += '<td class="dt-center">'+dados[i].hr_agenda+'</td>'
            text += '<td class="dt-center"><p>Email: '+dados[i].email+'</p></td>';
            text += '<td class="dt-center">'+dados[i].especialidade+'</td>'
            text += '<td class="dt-center">'+dados[i].nm_medico+'</td>'
            text += '<td class="dt-center">'+dados[i].sexo+'</td>'

            let el = document.createElement('tr');

            el.innerHTML = text;

            tabela.appendChild(el);
        }
    }
    
    // Envia a requisição
    xhr.send();
</script>

</body>
</html>