<?php
include("../layouts/header.php");
include("../layouts/nav.php");
?>


<style>
    .produto-img {
        max-width: 100px;
        max-height: 100px;
    }

    th {
        font-size: 2em;
        color: #141234;
    }

    tr {
        color: #141234;
    }

    h1 {
        text-align: center;
        color: #141234;
        font-weight: bold;
    }
</style>

<div class="container col-12 mt-5">
    <h1>Pesquisar Produto</h1>
    <form action="buscar_produto.php" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="keyword" placeholder="Digite o nome ou nome e modelo do produto">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Pesquisar</button>
            </div>
        </div>
    </form>

    <?php


    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $pesquisa = $_GET['keyword'];
        $results = $pdo->buscar_produto($pesquisa);

        if (empty($results)) {
            echo '<br>';
            echo '<div id="alertDiv" class="alert alert-danger" role="alert" style="text-align:center">';
            echo 'NENHUM ITEM ENCONTRADO !!';
            echo '</div>';
            echo '<script>
                setTimeout(function() {
                    document.getElementById("alertDiv").style.display = "none";
                }, 4000);
              </script>';
        }
    } else {
        echo '<br>';
        echo '<div id="alertDiv" class="alert alert-danger" role="alert" style="text-align:center">';
        echo 'DIGITE SUA PESQUISA !!';
        echo '</div>';
        echo '<script>
                setTimeout(function() {
                    document.getElementById("alertDiv").style.display = "none";
                }, 4000);
              </script>';
        $results = [];
    }
    ?>





    <?php if (!empty($results)) { ?>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Modelo</th>
                    <th>Cor</th>
                    <th>Quantidade</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $product) { ?>
                    <tr>
                        <td><?php echo $product['nome']; ?></td>
                        <td><?php echo $product['modelo']; ?></td>
                        <td><?php echo $product['cor']; ?></td>
                        <td><?php echo $product['quantidade']; ?></td>
                        <td>
                            <?php if (!empty($product['foto'])) { ?>
                                <img src="fotos/<?php echo $product['foto']; ?>" alt="Foto do Produto" width="100" height="60">
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>


<?php
include("../layouts/footer.php");
?>