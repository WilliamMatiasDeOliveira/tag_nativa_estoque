<?php
include("../layouts/header.php");
include("../layouts/nav.php");
?>

<style>
    label {
        font-weight: bold;
        color: #141234;
    }

    h1 {
        text-align: center;
        font-weight: bold;
        color: #141234;
    }
</style>

<div class="container col-5">
    <div class="form-group">
        <h1>CADASTRAR UM PRODUTO</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="nome" class='form-label'>NOME</label>
            <input type="text" name='nome' class='form-control'>

            <label for="modelo" class='form-label'>MODELO</label>
            <input type="text" name='modelo' class='form-control'>

            <label for="cor" class='form-label'>COR</label>
            <input type="text" name='cor' class='form-control'>

            <label for="quantidade" class='form-label'>QUANTIDADE</label>
            <input type="text" name='quantidade' class='form-control'>

            <label for="foto">ESCOLHA UMA IMAGEM</label>
            <br><br>
            <input type="file" name="foto">
            <br><br>
            <input type="submit" name='cadastrar' value='CADASTRAR' class='btn btn-primary form-control'>
        </form>
    </div>
</div>


<?php
if (isset($_POST['cadastrar'])) {

    $nome = $util->sanitaze($_POST['nome']);
    $modelo = $util->sanitaze($_POST['modelo']);
    $cor = $util->sanitaze($_POST['cor']);
    $quantidade = $util->sanitaze($_POST['quantidade']);
    $foto = $_FILES['foto'];

    if (!empty($nome) && !empty($modelo) && !empty($cor) && !empty($quantidade)) {

        $pdo->cad_produto($nome, $modelo, $cor, $quantidade, $foto);
    } else {
        echo '<br>';
        echo '<div id="alertDiv" class="alert alert-warning" role="alert" style="text-align:center">';
        echo 'PREENCHA TODOS OS CAMPOS !!';
        echo '</div>';
        echo '<script>
                setTimeout(function() {
                    document.getElementById("alertDiv").style.display = "none";
                }, 4000);
              </script>';
    }
}
?>

<?php
include("../layouts/footer.php");
?>