<h1>
    <?= $titulo ?>
</h1>

<h1>
<i class="fa-solid fa-trash"></i>
</h1>

<table>
    <thead>
        <tr>
            <th>
                Clientes
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clientes as $cliente) : ?>
            <tr>
                <td>
                    <?= $cliente ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>