<?php
require_once('core/Database.php');
require_once('core/Classes.php');

$pdo = new Database();
$util = new Util();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- CSS APLICATION -->
    <link rel="stylesheet" href="../css/estilo.css">
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Roboto:ital@1&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #141234;
        }

        label {
            color: #35C6D3;
            font-weight: bold;
        }

        #logo {
            margin-top: 2em;
            text-align: center;
            overflow: hidden;
            height: 10em;
            background-color: #141234;
            margin-bottom: -1em;
        }

        #logo img {
            width: 300px;
            margin-top: -5em;

        }
    </style>
</head>

<body>

    <div id="logo">
        <img src="views/img/tag_nativa2.png">
    </div>


    <div class="container col-3 mt-5">
        <div class="form-group">
            <form method="post">
                <label for="login" class='form-label'>LOGIN</label>
                <input type="text" name='login' class='form-control'>
                <br>
                <label for="senha" class='form-label'>SENHA</label>
                <input type="password" name='senha' class='form-control'>

                <br><br>

                <input type="submit" name='entrar' value='ENTRAR' class='btn btn-primary form-control'>
                <br><br>
                <a href="views/cad_user.php">Ainda não tem uma conta?</a>
            </form>
        </div>
    </div>

    <?php

    if (isset($_POST['entrar'])) {

        $login = $util->sanitaze($_POST['login']);
        $senha = $util->sanitaze($_POST['senha']);

        $pdo->login($login, $senha);
    }

    include("layouts/footer.php");
    ?>