<?php

use core\models\Favorite;
?>

<div class="container">
        <div class="row gap-3">

            <div class="col-7 product-card shadow">
                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner">
                        <?php for ($i = 0; $i < sizeof($pictures) - 1; $i++) : ?>
                            <div class="carousel-item <?php if ($i == 0) echo 'active' ?> p-5">
                                <img src="assets/images/produtos/<?= $pictures[$i] ?>" class="img-fluid" alt="...">
                            </div>
                        <?php endfor ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col product-card shadow p-4 d-flex flex-column justify-content-between">
                <div>
                    <!-- Fabricante -->
                    <p class="fs-5 m-0"><?= $product->nome_fabricante ?></p>
                    <!-- Nome -->
                    <p class="fs-3 mb-4"><?= $product->nome ?></p>
                    <!-- Descrição -->
                    <p class="fs-6 lead text-justify"><?= $product->descricao ?></p>
                </div>

                <div class="d-flex flex-column gap-3">
                    <div class="row">
                        <!-- DISPONILIBIDADE -->
                        <?php if ($product->quantidade > 10) : ?>
                            <div class="text-success d-flex align-items-center gap-2 justify-content-end">
                                <i class="fa-regular fa-circle-check fa-xl"></i>
                                <span class="fs-4">Disponível</span>
                            </div>
                        <?php elseif ($product->quantidade <= 10 && $product->quantidade > 0) : ?>
                            <div class="text-warning d-flex align-items-center gap-2 justify-content-end">
                                <i class="fa-regular fa-circle-check"></i>
                                <span class="fs-4">Poucas Unidades</span>
                            </div>
                        <?php else : ?>
                            <div class="text-danger d-flex align-items-center gap-2 justify-content-end">
                                <i class="fa-regular fa-circle-xmark fa-xl"></i>
                                <span class="fs-4">Indisponível</span>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="row d-flex align-items-center">
                        <!-- FAVORITO -->
                        <div class="col">
                            <?php if (isset($_SESSION['customer_id'])) : ?>
                                <div class="col">
                                    <?php if (Favorite::verify_favorite($_SESSION['customer_id'], $product->id)) : ?>
                                        <form action="?a=remove_favorite" method="POST">
                                            <input type="hidden" name="actual-url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                            <input type="hidden" name="favorite-customer-id" value="<?= $_SESSION['customer_id'] ?>">
                                            <input type="hidden" name="favorite-item-id" value="<?= $product->id ?>">
                                            <button class="btn btn-link p-0 resize-hover" type="submit">
                                                <i class="fa-solid fa-heart fa-2xl" style="color: #ff0000;"></i>
                                            </button>
                                        </form>
                                    <?php else : ?>
                                        <form action="?a=add_favorite" method="POST">
                                            <input type="hidden" name="actual-url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                            <input type="hidden" name="favorite-customer-id" value="<?= $_SESSION['customer_id'] ?>">
                                            <input type="hidden" name="favorite-item-id" value="<?= $product->id ?>">
                                            <input type="hidden" name="favorite-item-category" value="<?= $product->nome_categoria ?>">
                                            <button class="btn btn-link p-0 resize-hover" type="submit">
                                                <i class="fa-regular fa-heart fa-2xl" style="color: #ff0000;"></i>
                                            </button>
                                        </form>
                                    <?php endif ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <!-- PREÇO -->
                        <div class="col-8">
                            <span class="display-6 mb-0 d-flex justify-content-end"><?= $product->preco ?> €</span>
                        </div>
                    </div>

                    <!-- ADICIONAR AO CARRINHO -->
                    <form action="?a=add_to_cart" method="POST">
                        <input type="hidden" name="actual-url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                        <input type="hidden" name="item-id" value="<?= $product->id ?>">
                        <input type="hidden" name="item-price" value="<?= $product->preco ?>">

                        <!-- QUANTIDADE -->
                        <div class="row">
                            <div class="col-5">
                                <div class="d-flex h-100">
                                    <input type="hidden" id="max-quantity" value="<?= $product->quantidade?>">
                                    <button type="button" class="btn btn-outline-dark btn-md rounded-0" id="decrease" <?php if($product->quantidade <= 0) echo "disabled" ?>>-</button>
                                    <input type="text" class="border-dark form-control rounded-0 h-100 fs-3 p-0 text-center" id="quantity" name="quantity" value="1" <?php if($product->quantidade <= 0) echo "disabled" ?>>
                                    <button type="button" class="btn btn-outline-dark btn-md rounded-0 border-left-0" id="increase" <?php if($product->quantidade <= 0) echo "disabled" ?>>+</button>
                                </div>
                            </div>
                            <div class="col-7 d-flex justify-content-end">
                                <button type="submit" class="btn btn-outline-<?php if($product->quantidade > 0) echo "success" ; else echo "secondary"; ?> rounded-0" <?php if($product->quantidade <= 0) echo "disabled" ?>>Adicionar ao Carrinho</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- SOBRE O PRODUTO -->
        <div class="row">
            <div class="col product-card shadow p-5">
                <h2 class="mb-4">Sobre o produto</h2>
                <p class="lead text-justify"><?= $product->descricao ?></p>
            </div>
        </div>

        <!-- OPINIOES -->
        <div class="row">
            <div class="col product-card shadow p-5">

                <h2 class="mb-4">Avaliação</h2>

                <!-- AVALIAÇÕES -->
                <div class="col-3 rounded p-3 mb-2 border shadow-sm" style="background-color: rgb(242,242,242);">
                    <div class="p-3 rounded text-center border" style="background-color: rgb(255,255,255);">

                        <?php if (isset($data['reviews']['average_grade'])) : ?>
                            <!-- NOTA -->
                            <h1 class="fw-bold"><?= $data['reviews']['average_grade'] ?></h1>
                        <?php else : ?>
                            <h1 class="fw-bold">0</h1>
                        <?php endif ?>

                        <!-- ESTRELAS -->
                        <?php if (isset($data['reviews']['average_grade']) && $data['reviews']['average_grade'] != null) : ?>
                            <?php for ($i = 0; $i < $data['reviews']['average_grade']; $i++) : ?>
                                <i class="fa-solid fa-star fa-xl" style="color: #FFD43B;"></i>
                            <?php endfor ?>
                            <?php for ($i; $i < 5; $i++) : ?>
                                <i class="fa-regular fa-star fa-xl" style="color: #FFD43B;"></i>
                            <?php endfor ?>
                        <?php else : ?>
                            <?php for ($i = 0; $i < 5; $i++) : ?>
                                <i class="fa-regular fa-star fa-xl" style="color: #FFD43B;"></i>
                            <?php endfor ?>
                        <?php endif ?>

                        <!-- QUANTIDADE DE AVALIAÇÕES -->
                        <?php if (isset($data['reviews']['average_grade'])) : ?>
                            <p class="m-0 mt-2 fs-5"><?= sizeof($reviews) ?> Avaliações</p>
                        <?php else : ?>
                            <p class="m-0 mt-2 fs-5"><?= 0 ?> Avaliações</p>
                        <?php endif ?>
                    </div>
                </div>

                <?php if ($reviews) : ?>
                    <h3 class="mt-5 mb-4">O que dizem nossos clientes</h3>
                    <!-- TEXTO REVIEWS -->
                    <?php for ($i = 0; $i < sizeof($reviews); $i++) : ?>
                        <div class="col-6 p-3 mb-2 rounded border shadow-sm" style="background-color: rgb(242,242,242);">
                            <p class="fs-5 m-0"><?= $reviews['reviews'][$i]->texto ?></p>
                        </div>
                    <?php endfor ?>
                <?php endif ?>
            </div>
        </div>

        <!-- PRODUTOS RELACIONADOS -->
        <div class="row">
            <div class="col py-5">
                <h2 class="mb-4">Produtos Relacionados</h2>

                <div class="row">
                    <?php if (!empty($related_products)) : ?>
                        <?php $limit = 0; ?>
                        <?php foreach ($related_products as $related_product) : ?>
                            <?php if($related_product->id != $product->id) : ?>
                                <div class="col-md-3 px-1">
                                    <div class="product-card shadow">
                                        <!-- IMAGEM -->
                                        <div class="product-image">
                                            <a href="?a=details&product-id=<?= $related_product->id ?>">
                                                <img src="assets/images/produtos/<?= substr($related_product->imagem, 0, strpos($related_product->imagem, "@")) ?>" class="img-fluid mb-3" alt="<? $related_product->nome ?>">
                                            </a>
                                        </div>
                                        <!-- DESCRICAO -->
                                        <div class="product-text">
                                            <h6 class="product-name mb-3"><?= $related_product->nome ?></h5>
                                                <p class="product-description fw-light"><?= $related_product->descricao_curta ?></p>
                                                <!-- AVALIAÇÃO -->
                                                <div class="product-reviews mb-2">
                                                    <?php if ($related_product->avaliacao_media != null) : ?>
                                                        <?php for ($i = 0; $i < $related_product->avaliacao_media; $i++) : ?>
                                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                                        <?php endfor ?>
                                                        <?php for ($i; $i < 5; $i++) : ?>
                                                            <i class="fa-regular fa-star" style="color: #FFD43B;"></i>
                                                        <?php endfor ?>
                                                        <span><?= '(' . $related_product->total_avaliacoes . ')' ?></span>
                                                    <?php else : ?>
                                                        <?php for ($i = 0; $i < 5; $i++) : ?>
                                                            <i class="fa-regular fa-star" style="color: #FFD43B;"></i>
                                                        <?php endfor ?>
                                                        <span>(0)</span>
                                                    <?php endif ?>
                                                </div>
                                                <!-- DISPONILIBIDADE -->
                                                <?php if ($related_product->quantidade > 10) : ?>
                                                    <div class="text-success product-availability">
                                                        <i class="fa-regular fa-circle-check"></i>
                                                        <span>Disponível</span>
                                                    </div>
                                                <?php elseif ($related_product->quantidade <= 10 && $related_product->quantidade > 0) : ?>
                                                    <div class="text-warning product-availability">
                                                        <i class="fa-regular fa-circle-check"></i>
                                                        <span>Poucas Unidades</span>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="text-danger product-availability">
                                                        <i class="fa-regular fa-circle-xmark"></i>
                                                        <span>Indisponível</span>
                                                    </div>
                                                <?php endif ?>
                                                <!-- PREÇO -->
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="product-price fs-4 fw-bold mb-0"><?= $related_product->preco ?> €</p>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $limit++; ?>
                                <?php if ($limit == 4) : ?>
                                    <?php break; ?>
                                <?php endif ?>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#increase').click(function() {
            var value = parseInt($('#quantity').val());
            var maxQuantity = parseInt($('#max-quantity').val());
                if(value < maxQuantity) {
                    $('#quantity').val(value + 1);
            }
        });

        $('#decrease').click(function() {
            var value = parseInt($('#quantity').val());
            if (value > 1) {
                $('#quantity').val(value - 1);
            }
        });
    });
</script>