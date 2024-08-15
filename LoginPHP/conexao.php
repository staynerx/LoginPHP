<?php
class Conexao
{

    private $pdo;
    public function __construct($dbname, $host, $user, $senha)
    {
        try {

            $this->pdo = new PDO("mysql:dbname={$dbname};host={$host}", $user, $senha);
        } catch (PDOException $e) {
            echo "Erro com banco de dados" . $e->getMessage();
            exit();
        } catch (Exception $e) {
            echo "Erro com banco de dados 2" . $e->getMessage();
            exit();
        }
    }

    public function getConexao()
    {
        return $this->pdo;
    }
}

$p = new Conexao("crudpdo", "localhost", "root", "");
