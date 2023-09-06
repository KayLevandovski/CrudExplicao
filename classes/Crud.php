<?php
include_once('conexao/concexao.php'); //'include_once('conexao/conexao.php');': Esta linha de código está incluindo um arquivo chamado "conexao.php" que está localizado em um diretório chamado "conexao". O 'include_once' é uma função que permite incluir o conteúdo desse arquivo no script atual. Geralmente, arquivos de conexão contêm definições de configuração para se conectar a um banco de dados ou realizar outras tarefas relacionadas à conexão com recursos externos.
$db = new Database(); //'$db = new Database();': Nesta linha, está sendo criada uma nova instância da classe 'Database'. Presumivelmente, a classe 'Database' é definida no arquivo "conexao.php" incluído anteriormente. Criar uma nova instância dessa classe geralmente é o primeiro passo para estabelecer uma conexão com um banco de dados ou realizar operações relacionadas ao banco de dados.
//No geral, esse trecho de código está envolvido na inicialização da conexão com um banco de dados, mas os detalhes específicos dependem do conteúdo do arquivo "conexao.php" e da implementação da classe 'Database'. Para entender completamente o que está acontecendo, seria necessário examinar o código dentro do arquivo "conexao.php".

class Crud{ //A classe 'Crud' está sendo definida.
//Dois atributos privados estão sendo declarados dentro da classe:
    private $conn; //'$conn': Este atributo será usado para armazenar uma conexão com o banco de dados. Ele é provavelmente do tipo 'Database' ou outra classe que represente uma conexão ao banco de dados.
    private $table_name = "idols"; //'$table_name': Este atributo está definindo o nome da tabela do banco de dados com a qual as operações CRUD serão realizadas. Neste caso, a tabela se chama "idols".
    public function __construct($db){ //Um construtor público ('__construct') está sendo definido. Esse construtor espera receber um argumento '$db', que provavelmente é a conexão com o banco de dados. Dentro do construtor, a conexão é atribuída ao atributo '$conn'.
        $this->conn = $db;
    } //Essa classe 'Crud' será utilizada para realizar operações como inserir, consultar, atualizar e excluir registros na tabela "idols" do banco de dados, usando a conexão que é passada como parâmetro ao construtor. Há métodos adicionais na classe `Crud` para realizar essas operações CRUD específicas.
    
    //Nesse trecho de código PHP, você está definindo dois métodos dentro da classe que provavelmente é parte de um sistema de CRUD (Create, Read, Update, Delete) para uma tabela de banco de dados chamada "idols". Vou explicar o que está acontecendo em cada um dos métodos:
    //Método 'create':
    public function create($postValues){ //Este método é usado para inserir um novo registro na tabela "idols".
        //Ele recebe um parâmetro chamado '$postValues', que provavelmente contém os valores a serem inseridos na tabela.
        $empresa = $postValues['empresa']; //Os valores específicos são extraídos do array '$postValues' e armazenados em variáveis separadas: '$empresa', '$artista', '$contrato', '$ano', e '$numero'.
        $artista = $postValues['artista'];
        $contrato = $postValues['contrato'];
        $ano = $postValues['ano'];
        $numero = $postValues['numero'];

    //Em seguida, é construída uma consulta SQL de inserção usando esses valores, e a consulta é preparada com o uso de placeholders (símbolos de ponto de interrogação) para evitar ataques de SQL injection.
        $query = "INSERT INTO ". $this->table_name . " (empresa, artista, contrato, ano, numero) VALUES (?,?,?,?,?)";
        $stmt = $this->conn->prepare($query); //O método então prepara a consulta SQL usando a conexão com o banco de dados ('$this->conn->prepare($query)') e associa os valores às posições dos placeholders usando 'bindParam'.
        $stmt->bindParam(1, $empresa);
        $stmt->bindParam(2, $artista);
        $stmt->bindParam(3, $contrato);
        $stmt->bindParam(4, $ano);
        $stmt->bindParam(5, $numero);

        $rows = $this->read();
        if($stmt->execute()){ //Após a preparação, o método tenta executar a consulta SQL com '$stmt->execute()'.
            print "<script>alert('Cadastro Ok!</script>"; //Se a inserção for bem-sucedida, ele exibe um alerta com "Cadastro Ok!" e redireciona o usuário para uma página de leitura (provavelmente uma listagem de registros). Em seguida, retorna 'true'.
            print "<script> location.href='?action=read; </script>";
            return true;
        }else{
            return false; //Se a inserção falhar, ele retorna 'false'.
        }

    }

    //Este método é usado para consultar todos os registros da tabela "idols".
    public function read(){
        $query = "SELECT * FROM ". $this->table_name; //Ele constrói uma consulta SQL de seleção simples, selecionando todos os campos ('SELECT *') da tabela.
        $stmt = $this->conn->prepare($query);
        $stmt->execute(); //Em seguida, prepara a consulta SQL usando a conexão com o banco de dados e a executa com '$stmt->execute()'.
        return $stmt; //O método retorna o resultado da consulta preparada, que provavelmente é um objeto que pode ser iterado para obter os resultados da consulta.
        //Esses métodos fazem parte de uma classe que permite criar novos registros na tabela "idols" e consultar todos os registros existentes. É importante notar que esses métodos podem precisar de mais tratamento de erros e validações, dependendo dos requisitos e das práticas de segurança do aplicativo. Além disso, os scripts PHP geralmente são incorporados em páginas HTML ou em um sistema mais amplo para funcionar completamente.

    }
       //Nesse trecho de código PHP, você está definindo um método chamado 'update' dentro da classe. Este método é responsável por atualizar um registro existente na tabela "idols" do banco de dados com base nos valores fornecidos em '$postValues'. 
        public function update($postValues){ //Os valores necessários para a atualização são extraídos do array '$postValues' e armazenados em variáveis separadas:
        $id = $postValues['id']; //$id: Identificador do registro que será atualizado.
        $empresa = $postValues['empresa']; //'$empresa': Novo valor para o campo "empresa".
        $artista = $postValues['artista']; //'$artista`: Novo valor para o campo "artista".
        $contrato = $postValues['contrato']; //'$contrato': Novo valor para o campo "contrato".
        $ano = $postValues['ano']; //'$ano': Novo valor para o campo "ano".
        $numero = $postValues['numero']; //'$numero': Novo valor para o campo "numero".

        //Em seguida, o código verifica se algum dos campos (incluindo o ID) está vazio usando 'empty()'. Se algum deles estiver vazio, o método retorna 'false', o que pode indicar um erro na entrada de dados.
        //Se todos os campos estiverem preenchidos, uma consulta SQL de atualização é construída usando os valores fornecidos. A consulta utiliza placeholders (símbolos de ponto de interrogação) para evitar ataques de SQL injection.
        if(empty($id) || empty($empresa) || empty($artista) || empty($contrato) || empty($ano) || empty($numero)){
            return false;
        }

        $query = "UPDATE " . $this->table_name . " SET empresa = ?, artista = ?, contrato = ?, ano = ?, numero = ? WHERE id = ?"; 
        $stmt = $this->conn->prepare($query); //A consulta SQL é preparada com a conexão com o banco de dados usando '$this->conn->prepare($query)'.
        $stmt->bindParam(1, $empresa); //Os valores são associados aos placeholders usando 'bindParam'. Observe que há dois placeholders com o número "5". O último deveria ser "6" para associar o valor de '$id', mas parece haver um erro de digitação no código.
        $stmt->bindParam(2, $artista);
        $stmt->bindParam(3, $contrato);
        $stmt->bindParam(4, $ano);
        $stmt->bindParam(5, $numero);
        $stmt->bindParam(5, $id);

        if ($stmt->execute()){ //A consulta SQL é executada com '$stmt->execute()'.
            return true; //Se a atualização for bem-sucedida (ou seja, a consulta SQL é executada com sucesso), o método retorna 'true'. Caso contrário, retorna 'false'.
        }else{
            return false;
        }
    } 
        //Ele recebe um parâmetro '$id', que é o identificador do registro que se deseja ler.
        $query = "SELECT * FROM ". $this_name . "WHERE id = ?"; //Uma consulta SQL de seleção é construída para selecionar todos os campos ('SELECT *') da tabela "idols" onde o campo "id" corresponde ao valor do '$id'. No entanto, há um erro de digitação na consulta SQL, pois falta um espaço antes de "WHERE".
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id); //A consulta SQL é preparada usando a conexão com o banco de dados e, em seguida, o valor do ID é associado ao placeholder usando 'bindParam'.
        $stmt->execute(); //A consulta é executada com '$stmt->execute()'.
        return $stmt->fetch(PDO::FETCH_ASSOC); //O resultado da consulta é obtido usando '$stmt->fetch(PDO::FETCH_ASSOC)', que provavelmente retorna uma única linha de registro como um array associativo contendo os campos da tabela. Esse registro é então retornado pelo método.
    }

    public function delete($id){ //Este método é usado para excluir um registro da tabela "idols" com base no ID fornecido como argumento.
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?"; //Ele recebe um parâmetro '$id', que é o identificador do registro que se deseja excluir.
        //Uma consulta SQL de exclusão é construída para excluir um registro onde o campo "id" corresponde ao valor do '$id'.
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id); //A consulta SQL é preparada usando a conexão com o banco de dados, e o valor do ID é associado ao placeholder usando 'bindParam'.
        if($stmt->execute()){ //A consulta é executada com '$stmt->execute()'.
            return true; //Se a exclusão for bem-sucedida, o método retorna 'true'. Caso contrário, retorna 'false'.
        }else{
            return false;
        }
    }
}
?>