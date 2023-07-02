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
        font-weight: bold;
    }
</style>

<div class="container col-12">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Modelo</th>
                <th>Cor</th>
                <th>Quantidade</th>
                <th>Foto</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $produtos = $pdo->listar_produtos();
            ?>
            <?php foreach ($produtos as $produto) : ?>
                <tr>
                    <td><?php echo $produto['nome']; ?></td>
                    <td><?php echo $produto['modelo']; ?></td>
                    <td><?php echo $produto['cor']; ?></td>
                    <td><?php echo $produto['quantidade']; ?></td>
                    <td><img class="produto-img" src="fotos/<?php echo $produto['foto']; ?>" alt="Foto do Produto" width="100" height="60"></td>
                    <td>
                        <a class="btn btn-primary" href="editar.php?editar=<?= $produto['id']; ?>">Editar</a>
                        <a class="btn btn-danger" href="excluir.php?excluir=<?= $produto['id']; ?>">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include("../layouts/footer.php");
?>