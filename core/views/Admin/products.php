<div class="container">
    <table class="table">
        <thead>
            <tr>
                <td>ID</td>
                <td>Nome</td>
                <td>Ações</td>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)) : ?>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?= $product->id ?></td>
                        <td><?= $product->nome ?></td>
                        <td><a href="?a=edit_product&id=<?=$product->id ?>">Editar</a> | <a href="?a=remove_product&id=<?=$product->id ?>">Remover</a></td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>