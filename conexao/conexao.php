<?php
//Neste trecho de código PHP, está sendo definida uma classe chamada 'Database', que é responsável por gerenciar a conexão com um banco de dados MySQL.
class Database{ //É definida uma classe chamada 'Database' usando a palavra-chave 'class'.
    //A classe possui vários atributos privados que representam informações de configuração da conexão com o banco de dados:
    private $host = "localhost"; //'$host': O nome do host onde o banco de dados MySQL está sendo executado. Neste caso, é "localhost".
    private $db_name = "crud05"; //'$db_name': O nome do banco de dados que será utilizado, que é "crud05" neste caso.
    private $username = "root"; //'$username': O nome de usuário usado para autenticar a conexão com o banco de dados. É "root" neste exemplo.
    private $senha = ""; //'$senha': A senha usada para autenticar a conexão com o banco de dados. Está vazia neste exemplo, o que significa que nenhuma senha está sendo usada.
    public $conn; //A classe possui um atributo público chamado '$conn', que será usado para armazenar a conexão PDO com o banco de dados.

    public function getConnection(){ //Este método é responsável por criar e retornar uma instância de conexão PDO com o banco de dados.
        $this->conn = null; //Ele inicializa '$this->conn' como 'null'.

        try {
            $this->conn = new PDO("mysql:host".$this->host.";dbname=".$this->db_name,$this->username,$this->senha); //Em seguida, ele tenta criar uma conexão PDO utilizando as informações de host, nome do banco de dados, nome de usuário e senha fornecidas nos atributos da classe.
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Se a conexão for bem-sucedida, ele define o atributo `PDO::ATTR_ERRMODE` como `PDO::ERRMODE_EXCEPTION`, o que faz com que o PDO lance exceções em caso de erros.
        } catch(PDOException $e){ //Se ocorrer algum erro na criação da conexão, ele captura a exceção do tipo 'PDOException' e exibe uma mensagem de erro, informando o motivo do problema.
            echo "Erro na conexão: ".$e->getMessage(); //Após criar a conexão com o banco de dados (ou retornar `null` em caso de erro), o método retorna a conexão ('$this->conn').
        } //Essa classe 'Database' pode ser usada como parte de um sistema mais amplo para estabelecer uma conexão com o banco de dados MySQL e executar operações nele. O método 'getConnection' é chamado para obter uma instância de conexão PDO sempre que uma conexão com o banco de dados é necessária. 

        return $this->conn;
    }
}

?>