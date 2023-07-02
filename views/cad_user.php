<?php
include("../layouts/header.php");
?>

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
<div id="logo">
    <img src="img/tag_nativa2.png">
</div>
<div class="container col-3 mt-5">
    <div class="form-group">
        <form method="post">
            <label for="login" class='form-label'>LOGIN</label>
            <input type="text" name='login' class='form-control'>

            <label for="senha" class='form-label'>SENHA</label>
            <input type="password" name='senha' class='form-control'>

            <label for="key" class='form-label'>CHAVE DE SEGURANÇA</label>
            <input type="password" name='key' class='form-control'>

            <br><br>

            <input type="submit" name='cadastrar' value='CADASTRAR' class='btn btn-primary form-control'>

        </form>
    </div>
</div>

<?php
if (isset($_POST['cadastrar'])) {

    $chave = $util->sanitaze($_POST['key']);
    $login = $util->sanitaze($_POST['login']);
    $senha = $util->sanitaze($_POST['senha']);

    $pdo->cad_user($chave, $login, $senha);
}

?>



<?php
include("../layouts/footer.php");
?>