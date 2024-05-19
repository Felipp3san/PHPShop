<div class="container">

    <div class="row">
        <?php if (isset($_SESSION['order_placed'])) : ?>
            <h2 class="mb-4">Pedido criado!</h2>
            <?php unset($_SESSION['order_placed']) ?>
        <?php else : ?>
            <h2 class="mb-4">Detalhes do pedido</h2>
        <?php endif ?>
    </div>

    <!-- Estado do pedido -->
    <div class="row">
        <div class="product-card p-3 shadow">
            <div class="card-header">
                Pedido #<span id="num_pedido"><?= $order['details']->num_pedido ?></span>
            </div>
            <div class="card-title mt-2">
                <strong class="fs-5">Estado do pedido</strong>
            </div>
            <div class="card-body">
                <?php if ($order['details']->estado_entrega_id == 1) : ?>
                    <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" style="width: 25%"></div>
                    </div>
                    <p class="fw-semibold" style="width: 25%; text-align:right;"><?= $order['details']->estado_entrega ?></p>
                <?php elseif ($order['details']->estado_entrega_id == 2) : ?>
                    <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 50%"></div>
                    </div>
                    <p class="fw-semibold" style="width: 50%; text-align:right;"><?= $order['details']->estado_entrega ?></p>
                <?php elseif ($order['details']->estado_entrega_id == 3) : ?>
                    <div class="progress" role="progressbar" aria-label="Success striped example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped bg-success" style="width: 100%"></div>
                    </div>
                    <p class="fw-semibold" style="width: 100%; text-align:right;"><?= $order['details']->estado_entrega ?></p>
                <?php elseif ($order['details']->estado_entrega_id == 4) : ?>
                    <div class="progress" role="progressbar" aria-label="Danger striped example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped bg-danger" style="width: 100%"></div>
                    </div>
                    <p class="fw-semibold" style="width: 100%; text-align:right;"><?= $order['details']->estado_entrega ?></p>
                <?php endif ?>
            </div>
        </div>
    </div>

    <div class="row d-flex gap-3">
        <!-- Morada de entrega -->
        <div class="col product-card p-3 shadow">
            <div class="card-header">
                <strong class="fs-5">Morada de entrega</strong>
            </div>
            <div class="card-body">
                <p class="m-1"><strong>Nome:</strong> <span><?= ucwords($order_address->nome, " ") ?></span></p>
                <p class="m-1"><strong>Apelido:</strong> <span><?= ucwords($order_address->apelido, " ") ?></span></p>
                <p class="m-1"><strong>Morada:</strong> <span><?= ucwords($order_address->morada, " ") ?></span></p>
                <p class="m-1"><strong>Cidade:</strong> <span><?= ucwords($order_address->cidade, " ") ?></span></p>
                <p class="m-1"><strong>Código Postal:</strong> <span><?= substr($order_address->cod_postal, 0, 4) . '-' . substr($order_address->cod_postal, 4) ?></span></p>
                <p class="m-1"><strong>Telefone: </strong> <span><?= $order_address->telefone ?></span></p>
                <p class="m-1"><strong>NIF:</strong> <span><?= $order_address->nif ?></span></p>
            </div>
        </div>
        <!-- Detalhes do pedido -->
        <div class="col product-card p-3 shadow">
            <div class="card-header">
                <strong class="fs-5">Detalhes do pedido</strong>
            </div>
            <div class="card-body">
                <p class="m-1"><strong>Data do Pedido:</strong> <span><?= $order['details']->data_pedido ?></span></p>
                <p class="m-1"><strong>Cliente:</strong> <span><?= ucwords($order['details']->nome_cliente, " ") ?></span></p>
                <p class="m-1"><strong>Observações:</strong> <span></span></p>
                <p class="m-1"><strong>Tipo Pagamento:</strong> <span><?= $order['details']->tipo_pagamento ?></span></p>
                <p class="m-1"><strong>Estado Pagamento:</strong> <span><?= $order['details']->estado_pagamento ?></span></p>
                <p class="m-1"><strong>Código de Rastreamento:</strong> <span><?= $order['details']->cod_rastreamento ?></span></p>
            </div>
        </div>
    </div>

    <!-- Itens do pedido -->
    <div class="row">
        <div class="product-card p-3 shadow">
            <div class="card-header mb-3">
                <strong class="fs-5">Itens do pedido</strong>
            </div>
            <div class="card-body">
                <ul id="itens_pedido" class="list-group rounded-0">
                    <?php $total = 0 ?>
                    <?php foreach ($order['products'] as $product) : ?>
                        <li class="list-group-item">
                            <div class="row d-flex justify-content-between align-items-center">
                                <!-- IMAGEM -->
                                <div class="col-auto">
                                    <a href="?a=details&product-id=<?= $product->id ?>">
                                        <img class="product-image img-thumbnail border-0" src="assets/images/produtos/<?= substr($product->imagem_produto, 0, strpos($product->imagem_produto, "@")) ?>" width="200" height="200" alt="<? $product->nome_produto ?>">
                                    </a>
                                </div>
                                <div class="col d-flex flex-column gap-2">
                                    <!-- TITULO -->
                                    <div class="row">
                                        <span class="fw-semibold"><?= $product->nome_produto ?></span>
                                    </div>
                                    <!-- QUANTIDADE -->
                                    <div class="row d-inline-flex">
                                        <span class="fs-6">Quantidade: <?= $product->quantidade ?></span>
                                    </div>
                                    <!-- PRECO TOTAL -->
                                    <div class="row">
                                        <span class="lead fw-medium fs-4"><?= number_format($product->preco * $product->quantidade, 2) ?> €</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php $total += $product->preco * $product->quantidade ?>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="card-footer mt-4 d-flex justify-content-end">
                <ul class="col-3 list-group rounded-0 text-end">
                    <li class="list-group-item">
                        <span>Subtotal:</span> <strong><?= number_format($total, 2) ?> €</strong>
                    </li>
                    <li class="list-group-item">
                        <span>Frete:</span> <strong>Grátis</strong>
                    </li>
                    <li class="list-group-item">
                        <span>Total:</span> <strong><?= number_format($total, 2) ?> €</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>