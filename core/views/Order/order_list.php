<div class="container">
    <h2 class="mb-4">Meus pedidos</h2>
    <?php if (!empty($orders)) : ?>
        <?php foreach ($orders as $order) : ?>
            <div class="product-card shadow p-4">
                <div class="row d-flex justify-content-between">
                    <div class="card-title col-6 d-flex align-items-center">
                        <strong class="fs-5"><?= $order->estado_entrega ?></strong>
                    </div>
                    <div class="card-title col-6 d-flex justify-content-end d-flex align-items-center">
                        <div class="text-end">
                            <p class="m-0 p-0">Pedido número: <?= $order->num_pedido ?></p>
                            <p class="m-0 p-0">Criado em: <?= $order->data_pedido ?></p>
                        </div>
                        <div class="vr mx-2"></div>
                        <a class="btn btn-link text-decoration-none text-dark fw-bold m-0 p-0" href="?a=order_details&order_number=<?= $order->num_pedido ?>">
                            <span class="d-flex gap-2 align-items-center">Detalhes do pedido <i class="fa-solid fa-chevron-right"></span></i>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="card-body d-flex flex-column gap-3">
                    <?php if (sizeof($order->products) == 1) : ?>
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <a class="btn btn-transparent border-0 p-0" href="?a=details&product-id=<?= $order->products[0]->id ?>">
                                    <img class="product-image img-thumbnail border-0" src="assets/images/produtos/<?= substr($order->products[0]->imagem_produto, 0, strpos($order->products[0]->imagem_produto, "@")) ?>" width="200" height="200" alt="<? $order->products[0]->nome_produto ?>">
                                </a>
                            </div>
                            <div class="col-6">
                                <p class="fs-5"><?= $order->products[0]->nome_produto ?></p>
                                <p class="fs-5 fw-semibold"><?= $order->products[0]->preco ?> <span class="fw-normal">x<?= $order->products[0]->quantidade ?></span></p>
                            </div>
                            <div class="col d-flex justify-content-end align-self-end">
                                <p class="lead fs-3 m-0">Total: <span class="fs-3 fw-semibold"> <?= $order->products[0]->preco_total ?></span> € </p>
                            </div>
                        </div>
                    <?php elseif (sizeof($order->products) > 1) : ?>
                        <div class="d-flex gap-2">
                            <!-- Declarar contador -->
                            <?php $limit = 0 ?>
                            <?php $total = 0 ?>

                            <div class="col-9">
                                <?php foreach ($order->products as $product) : ?>
                                    <!-- Verificar contador (limite 4) -->
                                    <?php if ($limit == 4) {
                                        break;
                                    } ?>

                                    <a class="btn btn-transparent border-0 p-0" href="?a=details&product-id=<?= $product->id ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?= $product->nome_produto ?>">

                                        <img class="product-image img-thumbnail border-0" src="assets/images/produtos/<?= substr($product->imagem_produto, 0, strpos($product->imagem_produto, "@")) ?>" width="200" height="200" alt="<? $product->nome_produto ?>">
                                    </a>

                                    <?php $total += $product->quantidade * $product->preco ?>
                                    <!-- Incrementar contador -->
                                    <?php $limit++ ?>
                                <?php endforeach ?>
                            </div>

                            <div class="col d-flex justify-content-end align-self-end">
                                <p class="lead fs-3 m-0">Total: <span class="fs-3 fw-semibold"> <?= $total ?></span> € </p>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach ?>
    <?php else : ?>
        <div class="product-card shadow p-4">
            <div class="row d-flex justify-content-between">
                <span class="lead">Não há pedidos para visualizar.</span>
            </div>
        </div>
    <?php endif ?>
</div>