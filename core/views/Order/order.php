<div class="container my-5">
    <h2 class="mt-4 mb-4 text-center">Pedido criado!</h2>

    <div class="row">
        <div class="col-md-6 mb-4 mx-auto">
            <div class="product-card p-3 shadow">
                <div class="card-header">
                    Pedido #<span id="num_pedido"><?= $order[0]->num_pedido ?></span>
                </div>
                <div class="card-body">
                    <h3 class="card-title my-3">Detalhes do Pedido</h3>
                    <p class="card-text m-1"><strong>Data do Pedido:</strong> <span id="data_pedido"><?= $order[0]->data_pedido ?></span></p>
                    <p class="card-text m-1"><strong>Cliente:</strong> <span id="cliente_id"><?= ucwords($order[0]->nome_cliente, " ") ?></span></p>
                    <p class="card-text m-1"><strong>Observações:</strong> <span id="observacoes"></span></p>
                    <p class="card-text m-1"><strong>Estado Pagamento:</strong> <span id="estado_pagamento"><?= $order[0]->estado_pagamento ?></span></p>
                    <p class="card-text m-1"><strong>Estado Entrega:</strong> <span id="estado_entrega">Entregue</span></p>
                    <p class="card-text"><strong>Código de Rastreamento:</strong> <span id="cod_rastreamento"></span></p>
                    <h6>Itens do Pedido</h6>
                    <ul id="itens_pedido" class="list-group rounded-0">
                        <?php foreach ($products as $product) : ?>
                            <li class="list-group-item">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <!-- IMAGEM -->
                                    <div class="col-4">
                                        <a href="?a=details&product-id=<?= $product->id ?>">
                                            <img src="assets/images/produtos/<?= substr($product->imagem_produto, 0, strpos($product->imagem_produto, "@")) ?>" class="img-thumbnail border-0" width="150" height="150" alt="<? $product->nome_produto ?>">
                                        </a>
                                    </div>
                                    <div class="col-8 d-flex flex-column gap-2">
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
                        <?php endforeach ?>
                    </ul>
                </div>
                <!-- <div class="card-footer text-muted">
                    <span class="pt-3 d-block" id="created_at">Pedido criado em: 2023-05-01 09:00:00</span>
                </div> -->
            </div>
        </div>
    </div>
</div>