<?php
require_once("conexao.php");
require_once("classes.php");
session_start();
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style_logar.css">
</head>

<body class="body_logar">



    <div class="container">
        <?php

        if (isset($_POST["logar"])) {

            $res = $tabela->buscarDado(strtolower($_POST["nome"]), $_POST["senha"]);
            try {
                if ($res) {

                    echo "<h2 class='sucesso_logar'>Login com sucesso</h2>";
                    echo "</br>";
                    echo "<h2 class='sucesso_logar2'>Bem vindo, " . $res["nome"] . "!</h2>";
                    echo "<a href='tabela.php' class='verTabela'>Ver Tabela</a>";
                    session_start();
                    $_SESSION['logado'] = true;
                    $_SESSION['nome'] = $res["nome"];
                } else {

                    echo "<h2 class='erro_logar'>Login ou senha inválidos!</h2>";
                }
            } catch (PDOException $e) {
                echo "Erro com banco de dados" . $e->getMessage();
                exit();
            } catch (Exception $e) {
                echo "Erro com banco de dados 2" . $e->getMessage();
                exit();
            }
        }

        ?>
        <form class="formulario_login" action="index.php" method="post">
            <input type="text" name="nome" placeholder="Nome" required="required">
            <input type="password" name="senha" placeholder="Senha" required="required">
            <input class="botao" type="submit" name="logar" value="Login">
        </form>

    </div>


</body>

</html>