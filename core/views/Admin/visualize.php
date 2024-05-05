<div class="container mt-5">
    <h3><?= $data['categoria'] ?></h3>
    <hr>
    <table class="table">
        <thead>
            <tr>
                <?php foreach($elementos[0] as $chave => $valor):?>
                    <th><?= ucfirst($chave)?></th>
                <?php endforeach ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($elementos as $elemento):?>
            <tr>
                <?php foreach($elemento as $atributo):?>
                <td>
                    <?= $atributo ?>
                </td>
                <?php endforeach ?>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <a class="btn btn-primary rounded-0" href="?a=management_panel">Retornar</a>
</div>