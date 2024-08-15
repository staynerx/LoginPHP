<?php
require_once("conexao.php");
require_once("classes.php");
session_start();

if (!isset($_SESSION['logado']) || !$_SESSION['logado']) {

    header("Location: index.php");
    exit();
} else {
    echo "<h2 class='sucesso_logar'>Bem vindo, " . $_SESSION['nome'] . "!</h2>";
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <div class="cadastrar">

            <form class="formulario_logout" action="tabela.php" method="post">
                <button class="btn_sair" type="submit" name="logout">Sair</button>
            </form>

            <?php
            if (isset($_POST["logout"])) {
                $tabela->encerrarSessao();
            }
            ?>

            <h2>Cadastrar</h2>

            <form class="formulario" action="tabela.php" method="post">
                <input type="text" name="nome" placeholder="Nome" required="required">
                <input type="number" name="telefone" placeholder="Telefone" required="required">
                <input type="password" name="senha" placeholder="Senha" required="required">
                <input class="botao" type="submit" name="cadastrar" value="Cadastrar">
            </form>
            <?php
            if (isset($_GET["editar"])) {
                $res = $tabela->buscarDados();
                foreach ($res as $key => $value) {
                    if ($value["id"] == $_GET["editar"]) {
                        echo "<h2>Editar</h2>";
                        echo "<form class='formulario_editar' action='tabela.php' method='post'>";
                        echo "<input type='hidden' name='id' value='" . $value["id"] . "'>";
                        echo "<input type='text' name='nome' placeholder='Nome' required='required' value='" . $value["nome"] . "'>";
                        echo "<input type='text' name='telefone' placeholder='Telefone' required='required' value='" . $value["telefone"] . "'>";
                        echo "<input type='password' name='senha' placeholder='Senha' required='required' value='" . $value["senha"] . "'>";
                        echo "<input class='botao' type='submit' name='editar' value='Editar'>";
                        echo "</form>";
                    }
                }
            }

            if (isset($_POST["editar"])) {
                $id = $_POST["id"];
                $tabela->editarPessoa($id, $_POST["nome"], $_POST["telefone"], $_POST["senha"]);
            }
            ?>


        </div>

        <div class="tabela">

            <table>
                <tr class="cabecalho_tabela">
                    <th>id</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Senha</th>
                    <th>Ação</th>
                </tr>

                <?php
                $res = $tabela->buscarDados();
                foreach ($res as $key => $value) {
                    echo "<tr>";
                    echo "<td>" . $value["id"] . "</td>";
                    echo "<td>" . $value["nome"] . "</td>";
                    echo "<td>" . $value["telefone"] . "</td>";
                    echo "<td>" . $value["senha"] . "</td>";

                    echo "<td><a href='tabela.php?editar=" . $value["id"] . "'>Editar</a></td>";
                    echo "<td><a href='tabela.php?id=" . $value["id"] . "'>Excluir</a></td>";
                    echo "</tr>";
                }
                ?>

            </table>
        </div>

    </div>

</body>

</html>