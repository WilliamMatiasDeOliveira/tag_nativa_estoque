<?php
require_once('Database.php');
require_once('Classes.php');

$util = new Util();

$pdo = new Database();

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
    <link rel="stylesheet" href="estilo.css">
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Roboto:ital@1&display=swap" rel="stylesheet">

</head>

<body>



    <?php
    if (isset($_GET['excluir'])) {
        $id = $_GET['excluir'];
        $pdo->excluir_produto($id);

        header("location: ver_estoque.php");


        exit; // Certifique-se de encerrar o script após o redirecionamento
    }

    ?>

</body>

</html>