<?php
require_once('classes/Crud.php');
require_once('conexao/conexao.php');
//Estão incluindo arquivos externos no código. O 'require_once" é usado para garantir que esses arquivos sejam incluídos apenas uma vez, evitando duplicações.
//O arquivo 'class/Crud.php' está sendo incluído,  que sugere que ele contm a definição de que uma classe chamada "Crud" que provavelmente lida com operações de CRUD (Create, Read, Update, Delete) em um banco de dados.
//O arquivo 'conexao/concexao.php' também está sendo incluído, indicando que ele provavelmente contém a configuração de uma conexão com o banco de dados

$database = new Database();
$db = $database->getConnection();
$crud = new Crud($db);
//new Database()': é criada uma nova instância da classe 'Database'. Isso está definido em alguma parte do código e representa uma classes responsável por gerenciar a conexão com o banco de dados.
//'$database->getConnection()': chama o método 'getConnection()' na instância da classe 'Database'. Esse método realiza a conexão com o banco de dados e retorna um objeto de conexão
//'$db = $database->getConnection()': o objetivo de conexão retornado pelo método 'getConnection()' é atribuído à variável '$db'. Essa variével é agora uma conexão ativa com o banco de dados e será usada posteriormente para executar consultas SQL.
//'new Crud($db)': é criada uma nova instância da classe 'Crud', passando o objeto de conexão '$db' provavelmente é responsável por realizar operações de Crud no banco de dados, e agora está pronta para usar a conexão que foi estabelecida.

if(isset($_GET['action'])){ //'if(isset($_GET['action']))': Esta linha verifica se a variável "action" foi definida na URL por meio do método GET. Ela avalia se há uma ação específica a ser executada no sistema com base no valor passado na URL.
    switch($_GET['action']){ //'switch($_GET['action'])': Inicia uma estrutura de seleção "switch" com base no valor da variável "action" passada via GET. Isso permite que o código escolha diferentes caminhos de execução com base no valor de "action".
        //Cada "case" dentro do "switch" corresponde a uma ação específica que pode ser realizada no sistema:
        case 'create'; //'case 'create':': Se o valor de "action" for igual a "create", isso indica que o usuário deseja criar um novo registro no banco de dados. O código chama `$crud->create($_POST)` para criar o registro com os dados enviados via POST e, em seguida, atualiza a variável `$rows` chamando `$crud->read()` para listar os registros atualizados.
        $crud->create($_POST);
        $rows = $crud->read();
        break;
        case 'read': //'case 'read':': Se o valor de "action" for igual a "read", isso indica que o usuário deseja ler (listar) os registros existentes no banco de dados. O código simplesmente chama '$crud->read()' e atribui o resultado à variável '$rows'.
        $rows = $crud->read();
        break;
        case 'update'; //'case 'update':': Se o valor de "action" for igual a "update", isso indica que o usuário deseja atualizar um registro existente no banco de dados. Primeiro, o código verifica se o campo "id" está definido no POST. Se estiver, chama '$crud->update($_POST)' para atualizar o registro. Em seguida, atualiza a variável '$rows' chamando '$crud->read()' para listar os registros atualizados.
        if(isset($_POST['id'])){
            $crud->update($_POST);
        }
        $rows = $crud->read();
        break;

        case 'delete'; //'case 'delete':': Se o valor de "action" for igual a "delete", isso indica que o usuário deseja excluir um registro com base no ID passado via GET. O código chama '$crud->delete($_GET['id'])' para excluir o registro e, em seguida, atualiza a variável '$rows' chamando '$crud->read()' para listar os registros restantes.
        $crud->delete($_GET['id']);
        $rows = $crud->read();
        break;

        default: //'default:': Se o valor de "action" não corresponder a nenhum dos casos anteriores, o bloco "default" é executado. Isso geralmente é usado para listar todos os registros existentes no banco de dados chamando '$crud->read()' e atribuindo o resultado à variável '$rows'.
        $rows = $crud->read();
        break;
    }
}else{
    $rows = $crud->read();
} //O resultado final é que, com base no valor de "action" passado na URL, diferentes operações de CRUD (ou listar registros) são executadas no banco de dados e os resultados são armazenados na variável '$rows'. Se "action" não estiver definida na URL, a listagem de registros é a ação padrão.

?>

<!DOCTYPE html> //'<!DOCTYPE html>': Define o tipo de documento como HTML5.
<html lang="en"> //'<html lang="en">': Inicia o elemento HTML e define o atributo "lang" como "en" (inglês) para indicar o idioma da página como inglês.
<head> //'<head>': Inicia a seção do cabeçalho da página, onde informações sobre a página são definidas. Dentro do cabeçalho, são realizadas as seguintes ações:
    <meta charset="UTF-8"> //'<meta charset="UTF-8">: Define a codificação de caracteres da página como UTF-8, permitindo o uso de caracteres especiais.
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> //'<meta name="viewport" content="width=device-width, initial-scale=1.0">': Define as configurações de visualização da página, especialmente para dispositivos móveis, garantindo que a largura da página seja igual à largura do dispositivo e que a escala inicial seja 1.0.
    <title>Crud</title> //'<title>Crud</title>': Define o título da página como "Crud".
    <style> //Em seguida, é definido um bloco de estilos embutidos na página usando a tag '<style>'. Esses estilos são aplicados a elementos HTML posteriormente no corpo da página.
        form{
        max-width: 500px;
        margin: 0 auto;
        }
        label{
            display: flex;
            margin-top: 10px;
        }
        input[type=texto]{
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=submit]{
            background-color: #4caf50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius:  4px;
            cursor: pointer;
            float: right
        }
        input[type=submit]:hover{
            background-color: #45a049;
        }
        table{
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }
        th, td{
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        th{
            background-color: #f2f2f2;
            font-weight: bold;
        }
        a{
            display: inline-block;
            padding: 4px 8px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        a:hover{
            background-color: #0069d9;
        }

        a:delete{
            background-color: #dc3545;
        }
        a.delete:hover{
            background-color: #c82333;
        }

        </style>
</head>
<body> //'<body>': Inicia a seção do corpo da página, onde o conteúdo visível aos usuários será colocado. Aqui, o código PHP é inserido dentro do corpo da página para gerar dinamicamente o conteúdo, dependendo das ações e dos dados do banco de dados. O código PHP será responsável por criar formulários, listar registros e aplicar estilos aos elementos HTML.
esta parte do código HTML e PHP estabelece a estrutura básica da página da web, define o cabeçalho, os estilos e prepara o corpo da página para a geração dinâmica de conteúdo com base nas ações e dados do PHP posteriormente no código.
    
    <?php
    if(isset($_GET['action'])) && $_GET['action'] == 'update' && isset($_GET['id']){ //'if(isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])):'': Esta linha verifica se três condições são atendidas simultaneamente:
//Verifica se a variável "action" está definida na URL via método GET.
//Verifica se o valor de "action" é igual a "update". Isso geralmente significa que o usuário deseja atualizar um registro.
//Verifica se a variável "id" também está definida na URL via método GET.
//Se todas essas condições forem verdadeiras, o código dentro do bloco IF é executado. Isso indica que o usuário deseja atualizar um registro específico no banco de dados com base no ID fornecido.
        $id = $_GET['id']; //'$id = $_GET['id'];': O código atribui o valor da variável "id" obtida via GET à variável local "$id". Isso captura o ID do registro que o usuário deseja atualizar.
        $result = $crud->readOne($id); //'$result = $crud->readOne($id);': É chamado o método '$crud->readOne($id)'. Isso provavelmente é responsável por recuperar os detalhes de um registro específico no banco de dados com base no ID fornecido. O resultado é armazenado na variável "$result".

        if(!$result){ //'if(!$result){': É iniciada uma verificação para determinar se a consulta ao banco de dados retornou algum resultado (ou seja, se o registro foi encontrado).
            echo "Registro não encontrado."; //'echo "Registro não encontrado.";': Se o registro não for encontrado, uma mensagem "Registro não encontrado." é exibida na página.
            exit(); //'exit();': A função 'exit()' é chamada, encerrando imediatamente a execução do código PHP. Isso é feito para evitar que o restante do código seja executado caso o registro não seja encontrado.
        } //Se o registro for encontrado com sucesso, o código continuará abaixo, onde os dados do registro serão extraídos e atribuídos a variáveis locais, como "$empresa", "$artista", "$contrato", "$ano" e "$numero". Esses valores provavelmente serão usados para preencher um formulário de edição, permitindo ao usuário atualizar os detalhes do registro.
        $empresa = $result['empresa'];
        $artista = $result['artista'];
        $contrato = $result['contrato'];
        $ano = $result['ano'];
        $numero = $result['numero'];

        ?>

        <form action="?action=update" method="POST"> //'<form action="?action=update" method="POST">': Aqui, um formulário HTML é definido. O atributo 'action' especifica que, quando o formulário for enviado, a ação a ser executada é "update" (para atualizar um registro no banco de dados). O método de envio é "POST".
            <input type="hidden" name="id" value="<?php echo $id ?>"> //'<input type="hidden" name="id" value="<?php echo $id ?>">': É criado um campo de entrada oculto (hidden input) para armazenar o ID do registro que está sendo atualizado. O valor desse campo é preenchido com o valor da variável '$id' obtida anteriormente.
            //Em seguida, são definidos campos de entrada para editar os detalhes do registro, como "empresa", "artista", "contrato", "ano" e "numero". Cada campo é inicializado com os valores correspondentes obtidos anteriormente nas variáveis `$modelo`, `$marca`, `$placa`, `$cor` e `$ano`. Isso permite que o usuário veja os valores atuais do registro e os edite conforme necessário.
            <label for="empresa">Empresa</label>
            <input type="text" name="empresa" value-="<?php echo $empresa ?>">

            <label for="artista">Artista</label>
            <input type="text" name="artista" value="<?php echo $artista ?>">

            <label for="contrato">Contrato</label>
            <input type="text" name="contrato" value="<?php echo $contrato ?>">

            <label for="ano">Ano</label>
            <input type="text" name="ano" value="<?php echo $ano ?>">

            <label for="numero">Número</label>
            <input type="text" name="numero" value="<?php echo $numero ?>">

            <input type="submit" value="Atualizar" name="enviar" onclick="return confirm('Certeza que deseja atualizar?')"> //'<input type="submit" value="Atualizar" name="enviar" onclick="return confirm('Certeza que deseja atualizar?')">': Este é um botão de envio do formulário. Quando pressionado, ele enviará os dados do formulário para a ação "update". O atributo "onclick" exibe uma caixa de diálogo de confirmação antes de enviar o formulário, pedindo ao usuário que confirme se deseja ou não atualizar o registro.
    </form> //Após o fechamento do formulário ('</form>'), o código PHP é retomado com '<?php'. Nesse ponto, provavelmente, o código continuará após o fechamento do formulário para tratar o envio do formulário e realizar a atualização no banco de dados com base nos dados fornecidos pelo usuário.
//Basicamente, esta parte do código HTML define um formulário que permite ao usuário editar os detalhes de um registro existente no banco de dados e, quando enviado, direciona a ação para a atualização desse registro. Os valores atuais do registro são preenchidos nos campos de entrada para facilitar a edição.
    
<?php
            
    }else{
    
    ?>

    <form action="?action=create" method="POST"> //'<form action="?action=create" method="POST">'': Aqui, um formulário HTML está sendo definido. O atributo 'action' especifica que, quando o formulário for enviado, a ação a ser executada é "create" (provavelmente para criar um novo registro no banco de dados). O método de envio é "POST".
        //Em seguida, são definidos campos de entrada no formulário para permitir ao usuário inserir os detalhes do novo registro. Os campos incluem "empresa", "artista", "contrato", "ano" e "numero". Cada campo tem um rótulo associado definido com a tag '<label>'.
        <label for="">Empresa</label>
        <input type="text" name="empresa">

        <label for="">Artista</label>
        <input type="text" name="artista">

        <label for="">Contrato</label>
        <input type="text" name="contrato">

        <label for="">Ano</label>
        <input type="text" name="ano">

        <label for="">Número</label>
        <input type="text" name="numero">

        <input type="submit" value="Cadastrar" name="enviar"> //'<input type="submit" value="Cadastrar" name="enviar">': Este é um botão de envio do formulário. Quando pressionado, ele enviará os dados do formulário para a ação "create". O texto exibido no botão é "Cadastrar".

    </form> //Após o fechamento do formulário ('</form>'), o código PHP é retomado com '<?php'. Nesse ponto, o código PHP verifica se a variável "action" não está definida na URL (o que significa que o usuário não escolheu nenhuma ação específica). Se isso for verdadeiro, o código abaixo é executado.
    <?php //'<?php ... } ?>': Isso fecha a estrutura condicional iniciada anteriormente. O código entre '{' e '}' será executado quando a variável "action" não estiver definida na URL. Em outras palavras, isso ocorrerá quando o usuário não tiver escolhido uma ação específica e o sistema deverá exibir o formulário para criar um novo registro.
} //Basicamente, esta parte do código HTML e PHP define um formulário que permite ao usuário inserir detalhes para criar um novo registro no banco de dados. Quando o usuário pressiona o botão "Cadastrar", os dados do formulário serão enviados para a ação "create" para processamento. Se a variável "action" não estiver definida (quando o usuário acessa inicialmente a página), o formulário de criação será exibido.

?>
<table> //'<table>': Inicia a tag de abertura da tabela HTML.
    <tr> //'<tr>': Inicia uma linha na tabela para os cabeçalhos das colunas.
        <td>Id</td> //'<td>': Define células da tabela para cada cabeçalho de coluna. Os cabeçalhos da tabela incluem "Id", "Empresa", "Artista", "Contrato", "Ano", "Número" e "Sonora".
        <td>Empresa</td>
        <td>Artista</td>
        <td>Contrato</td>
        <td>Ano</td>
        <td>Número</td>
        <td>Sonora</td>
</tr>
//Após a definição dos cabeçalhos da tabela, o código PHP é retomado com '<?php'. Nesse ponto, o código PHP provavelmente será responsável por preencher o corpo da tabela com os registros do banco de dados.
//Essa parte do código HTML está preparando a estrutura da tabela que será usada para listar os registros do banco de dados. Os registros serão inseridos nas linhas subsequentes da tabela, e os cabeçalhos das colunas definidos aqui serão usados para identificar os campos dos registros exibidos na tabela.

<?php
if($rows->rowCount() == 0){
    echo "<tr>";
    echo "<td colspan='7'>Nenhum dado encontrado</td>";
    echo "</tr>";
}else{
    while($row = $rows->fetch(PDO::FETCH_ASSOC)){
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['empresa'] . "</td>";
        echo "<td>" . $row['artista'] . "</td>";
        echo "<td>" . $row['contrato'] . "</td>";
        echo "<td>" . $row['ano'] . "</td>";
        echo "<td>" . $row['numero'] . "</td>";
        echo "<td>";
        echo "<a href='?action=update&id=" . $row['id'] . "'>Atualizar</a>";
        echo "<a href='?action=delete&id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que quer apagar esse registro?\")' class='delete>Delete<a/a>";
        echo "</td>";
        echo "</tr>";
    }
}
?>
</table>
</body>
</html>