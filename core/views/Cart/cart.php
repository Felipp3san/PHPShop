<style>
    #quantity {
        width: 50px;
    }

    #decrease,
    #increase,
    #quantity {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        height: 30px;
    }
    
    #decrease,
    #increase {
        width: 40px;
        font-weight: bold;
    }
</style>

<div class="container-fluid">
    <h2 class="mt-4 mb-4">Seu Carrinho</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <!-- Lista de itens no carrinho -->
                    <h5 class="card-title">Itens no Carrinho</h5>
                    <ul class="list-group">
                        <!-- ITEM CARRINHO -->
                        <?php if (isset($data['cart_items']) && $data['cart_items'] != false) : ?>
                            <?php foreach ($data['cart_items'] as $item) : ?>
                                <li class="list-group-item ">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <div class="col-2">
                                            <!-- IMAGEM -->
                                            <img src="assets/images/produtos/<?= substr($item->imagem, 0, strpos($item->imagem, "@")) ?>" class="img-thumbnail border-0" width="150" height="150" alt="<? $product->nome ?>">
                                        </div>
                                        <div class="col-8">
                                            <!-- TITULO -->
                                            <h5><?= $item->nome ?></h5>
                                            <!-- DESCRICAO -->
                                            <p class="lead"><?= $item->descricao_curta ?></p>
                                        </div>
                                        <div class="col-2 d-grid justify-content-center">
                                            <!-- PRECO  -->
                                            <p class="badge text-bg-primary border-0 fs-4"><?= $item->preco ?> €</p>
                                            <!-- QUANTIDADE -->

                                            <div class="d-flex border shadow-sm">
                                                <button class="btn btn-secondary rounded-0 fs-5 p-0" id="decrease">-</button>
                                                <input type="text" class="form-control rounded-0 fs-5 p-0" id="quantity" value="<?= $item->quantidade ?>" disabled>
                                                <button class="btn btn-secondary rounded-0 fs-5 p-0" id="increase">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach ?>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <!-- Resumo do carrinho -->
                    <h5 class="card-title">Resumo do Pedido</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Subtotal
                            <span>R$ 100,00</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Frete
                            <span>Grátis</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Total</strong>
                            <strong>R$ 100,00</strong>
                        </li>
                    </ul>
                    <!-- Botões de ação -->
                    <div class="mt-3">
                        <button type="button" class="btn btn-primary btn-block">Finalizar Compra</button>
                        <button type="button" class="btn btn-secondary btn-block mt-2">Continuar Comprando</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#increase').click(function() {
            var value = parseInt($('#quantity').val());
            $('#quantity').val(value + 1);
        });

        $('#decrease').click(function() {
            var value = parseInt($('#quantity').val());
            if (value > 1) {
                $('#quantity').val(value - 1);
            }
        });
    });
</script>