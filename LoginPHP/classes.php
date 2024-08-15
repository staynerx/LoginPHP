<?php

class Tabela
{
    private $pdo;

    public function __construct($conexao)
    {
        $this->pdo = $conexao;
    }

    public function buscarDado($nome, $senha)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM login_master WHERE nome = :nome AND senha = :senha LIMIT 1");
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":senha", $senha);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            return $res;
        } else {
            return false;
        }
    }

    public function buscarDados()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pessoa");
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            return $res;
        } else {
            return false;
        }
    }

    public function cadastrarPessoa($nome, $telefone, $senha)
    {
        // $hashed_password = password_hash($senha, PASSWORD_DEFAULT);
        if (isset($_POST["cadastrar"])) {

            $stmt = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, senha) VALUES (:nome, :telefone, :senha)");
            $stmt->bindValue(":nome", $nome);
            $stmt->bindValue(":telefone", $telefone);
            $stmt->bindValue(":senha", $senha);
            $stmt->execute();
        }
    }

    public function excluirPessoa($id)
    {

        $stmt = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
    }

    public function editarPessoa($id, $nome, $telefone, $senha)
    {

        $stmt = $this->pdo->prepare("UPDATE pessoa SET nome = :nome, telefone = :telefone, senha = :senha WHERE id = :id");
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":nome", $nome);
        $stmt->bindValue(":telefone", $telefone);
        $stmt->bindValue(":senha", $senha);
        $stmt->execute();
    }

    public function encerrarSessao()
    {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}

$tabela = new Tabela($p->getConexao());

$res = $tabela->buscarDados();

if (isset($_POST["cadastrar"])) {
    $tabela->cadastrarPessoa($_POST["nome"], $_POST["telefone"], $_POST["senha"]);
}

if (isset($_GET["id"])) {
    $tabela->excluirPessoa($_GET["id"]);
}
