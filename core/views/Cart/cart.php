<style>
    .quantity-width {
        max-width: 50px;
    }
</style>

<div class="container-fluid">
    <h2 class="mb-4">Seu Carrinho</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="product-card shadow p-3">
                <div class="card-body">
                    <!-- Lista de itens no carrinho -->
                    <h5 class="card-title mb-3">Itens no Carrinho</h5>
                    <ul class="list-group rounded-0">
                        <!-- ITEM CARRINHO -->
                        <?php if (isset($data['cart_items']) && $data['cart_items'] != false) : ?>
                            <li class="list-group-item">
                                <div class="row text-center">
                                    <div class="col-5"><span>Produto</span></div>
                                    <div class="col-2"><span>Preço</span></div>
                                    <div class="col-2"><span>Quantidade</span></div>
                                    <div class="col-2"><span>Preço Final</span></div>
                                    <div class="col-1"></div>
                                </div>
                            </li>
                            <?php foreach ($data['cart_items'] as $item) : ?>
                                <li class="list-group-item">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <div class="col-2">
                                            <!-- IMAGEM -->
                                            <a href="?a=details&product-id=<?= $item->item_id ?>">
                                                <img src="assets/images/produtos/<?= substr($item->imagem, 0, strpos($item->imagem, "@")) ?>" class="img-thumbnail border-0" width="150" height="150" alt="<? $product->nome ?>">
                                            </a>
                                        </div>
                                        <div class="col-3">
                                            <!-- TITULO -->
                                            <span class="fw-semibold"><?= $item->nome ?></span>
                                        </div>
                                        <div class="col-2">
                                            <span class="lead fs-4 d-flex justify-content-center"><?= number_format($item->preco, 2) ?> €</span>
                                        </div>
                                        <div class="col-2">
                                            <div class="d-flex justify-content-center">
                                                <!-- REMOVER 1 DO CARRINHO -->
                                                <form action="?a=remove_from_cart" method="POST">
                                                    <input type="hidden" name="actual-url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                                    <input type="hidden" name="item-id" value="<?= $item->item_id ?>">
                                                    <input type="hidden" name="to-remove" value="1">
                                                    <input type="hidden" name="quantity" value="<?= $item->quantidade ?>">
                                                    <button class="btn btn-outline-secondary btn-sm rounded-0 border-2">-</button>
                                                </form>
                                                <input type="text" class="form-control rounded-0 border-2 text-center p-0 quantity-width" value="<?= $item->quantidade ?>" disabled>
                                                <!-- ADICIONAR 1 NO CARRINHO -->
                                                <form action="?a=add_to_cart" method="POST">
                                                    <!-- QUANTIDADE -->
                                                    <input type="hidden" name="selected-quantity" class="form-control rounded-0 border-2 text-center p-0 quantity-width" value="<?= $item->quantidade ?>">
                                                    <input type="hidden" name="actual-url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                                    <input type="hidden" name="item-id" value="<?= $item->item_id ?>">
                                                    <input type="hidden" name="item-price" value="<?= $item->item_preco ?>">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button class="btn btn-outline-secondary rounded-0 border-2 btn-sm">+</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-2 d-grid justify-content-center">
                                            <!-- PRECO TOTAL -->
                                            <span class="lead fw-medium fs-4 d-flex justify-content-center text-truncate"><?= number_format($item->preco * $item->quantidade, 2) ?> €</span>
                                        </div>
                                        <!-- REMOVER PRODUTO DO CARRINHO -->
                                        <div class="col-1 d-grid justify-content-center">
                                            <form action="?a=remove_from_cart" method="POST">
                                                <input type="hidden" name="actual-url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                                <input type="hidden" name="item-id" value="<?= $item->item_id ?>">
                                                <input type="hidden" name="item-price" value="<?= $item->item_preco ?>">
                                                <input type="hidden" name="to-remove" value="<?= $item->quantidade ?>">
                                                <input type="hidden" name="quantity" value="<?= $item->quantidade ?>">
                                                <button type="submit" class="btn btn-link rounded-0 fs-5 p-0 border-2">
                                                    <i class="text-secondary fa-solid fa-x"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <!-- SOMAR TOTAL DOS PRODUTOS -->
                                        <?php $total = (!isset($total)) ? $item->preco * $item->quantidade : $total + $item->preco * $item->quantidade ?>
                                    </div>
                                </li>
                            <?php endforeach ?>
                        <?php else : ?>
                            <span class="lead">Seu carrinho está vazio.</span>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="product-card shadow p-3">
                <div class="card-body">
                    <!-- Resumo do carrinho -->
                    <h5 class="card-title mb-3">Resumo do Pedido</h5>
                    <ul class="list-group rounded-0">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Subtotal
                            <span><?php echo number_format($total = (!isset($total)) ? 0 : $total, 2) ?> €</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Frete
                            <span>Grátis</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Total</strong>
                            <strong><?php echo number_format($total = (!isset($total)) ? 0 : $total, 2) ?> €</strong>
                        </li>
                    </ul>
                    <!-- Botões de ação -->
                    <div class="d-grid mt-3">
                        <a type="button" class="btn btn-primary btn-block rounded-0" href="?a=preview_order">Finalizar Compra</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>