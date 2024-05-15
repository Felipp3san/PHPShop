<?php

use core\classes\Store;
use core\models\Favorite;
?>

<div class="container-fluid">
    <h3 class="mb-4"><?= $category_name ?></h3>
    <div class="row">
        <div class="col-3">
            <?php if (isset($_GET['a']) && $_GET['a'] != 'search_products') : ?>
                <div class="product-card shadow-sm p-2">
                    <h5>Filtros</h5>
                    <form id="filters" action="?a=products&category-name=<?= $category_name ?>&id=<?= $category_id ?>">
                        <!-- STOCK -->
                        <p class="m-0 fw-semibold">Stock</p>
                        <hr class="mx-0 my-1">
                        <input type="hidden" name="a" value="products">
                        <input type="hidden" name="category-name" value="<?= $category_name ?>">
                        <input type="hidden" name="id" value="<?= $category_id ?>">
                        <div>
                            <input class="form-check-input rounded-0" type="checkbox" id="in-stock" name="in-stock" onclick="submitForm()" <?php if (isset($_GET['in-stock'])) echo 'checked'; ?>>
                            <label class="form-check-label" for="in-stock">Disponível</label>
                        </div>
                        <div>
                            <input class="form-check-input rounded-0" type="checkbox" id="no-stock" name="no-stock" onclick="submitForm()" <?php if (isset($_GET['no-stock'])) echo 'checked'; ?>>
                            <label class="form-check-label" for="no-stock">Indisponível</label>
                        </div>
                        <!-- FABRICANTES  -->
                        <p class="m-0 mt-3 fw-semibold">Fabricante</p>
                        <hr class="mx-0 my-1">
                        <?php foreach ($filter_manufacturers as $manufacturer) : ?>
                            <div>
                                <input class="form-check-input rounded-0" type="checkbox" name="manufacturer[]" value=<?= $manufacturer['id_fabricante'] ?> onclick="submitForm()" <?php if (isset($_GET['manufacturer']) && in_array($manufacturer['id_fabricante'], $_GET['manufacturer'])) echo 'checked'; ?>>
                                <label class="form-check-label" for=""><?= $manufacturer['nome_fabricante'] ?></label>
                            </div>
                        <?php endforeach ?>
                    </form>
                </div>
            <?php endif ?>
        </div>
        <div class="col-9">
            <div class="row">
                <?php if (!empty($products)) : ?>
                    <?php foreach ($products as $product) : ?>
                        <div class="col-md-3 px-1">
                            <div class="product-card shadow-sm">
                                <!-- IMAGEM -->
                                <div class="product-image">
                                    <a href="?a=details&product-id=<?= $product->id ?>">
                                        <img src="assets/images/produtos/<?= substr($product->imagem, 0, strpos($product->imagem, "@")) ?>" class="img-fluid mb-3" alt="<? $product->nome ?>">
                                    </a>
                                </div>
                                <!-- DESCRICAO -->
                                <div class="product-text">
                                    <h6 class="product-name mb-3"><?= $product->nome ?></h5>
                                        <p class="product-description fw-light"><?= $product->descricao_curta ?></p>
                                        <!-- AVALIAÇÃO -->
                                        <div class="product-reviews mb-2">
                                            <?php if ($product->avaliacao_media != null) : ?>
                                                <?php for ($i = 0; $i < $product->avaliacao_media; $i++) : ?>
                                                    <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                                <?php endfor ?>
                                                <?php for ($i; $i < 5; $i++) : ?>
                                                    <i class="fa-regular fa-star" style="color: #FFD43B;"></i>
                                                <?php endfor ?>
                                                <span><?= '(' . $product->total_avaliacoes . ')' ?></span>
                                            <?php else : ?>
                                                <?php for ($i = 0; $i < 5; $i++) : ?>
                                                    <i class="fa-regular fa-star" style="color: #FFD43B;"></i>
                                                <?php endfor ?>
                                                <span>(0)</span>
                                            <?php endif ?>
                                        </div>
                                        <!-- DISPONILIBIDADE -->
                                        <?php if ($product->quantidade > 10) : ?>
                                            <div class="text-success product-availability">
                                                <i class="fa-regular fa-circle-check"></i>
                                                <span>Disponível</span>
                                            </div>
                                        <?php elseif ($product->quantidade <= 10 && $product->quantidade > 0) : ?>
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
                                            <p class="product-price fs-4 fw-bold mb-0"><?= $product->preco ?> €</p>

                                            <!-- FAVORITO -->
                                            <?php if (isset($_SESSION['customer_id'])) : ?>

                                                <?php if (Favorite::verify_favorite($_SESSION['customer_id'], $product->id)) : ?>
                                                    <form action="?a=remove_favorite" method="POST">
                                                        <input type="hidden" name="actual-url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                                        <input type="hidden" name="favorite-customer-id" value="<?= $_SESSION['customer_id'] ?>">
                                                        <input type="hidden" name="favorite-item-id" value="<?= $product->id ?>">
                                                        <button class="btn btn-link p-0" type="submit">
                                                            <i class="fa-solid fa-heart fa-xl" style="color: #ff0000;"></i>
                                                        </button>
                                                    </form>
                                                <?php else : ?>
                                                    <form action="?a=add_favorite" method="POST">
                                                        <input type="hidden" name="actual-url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                                        <input type="hidden" name="favorite-customer-id" value="<?= $_SESSION['customer_id'] ?>">
                                                        <input type="hidden" name="favorite-item-id" value="<?= $product->id ?>">
                                                        <input type="hidden" name="favorite-item-category" value="<?= $category_name ?>">
                                                        <button class="btn btn-link p-0" type="submit">
                                                            <i class="fa-regular fa-heart fa-xl" style="color: #ff0000;"></i>
                                                        </button>
                                                    </form>
                                                <?php endif ?>
                                            <?php endif ?>
                                        </div>
                                </div>
                                <!-- ADICIONAR CARRINHO -->
                                <form action="?a=add_to_cart" method="POST">
                                    <div class="d-flex justify-content-center">
                                        <input type="hidden" name="actual-url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                        <input type="hidden" name="item-id" value="<?= $product->id ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="item-price" value="<?= $product->preco ?>">

                                        <?php if (isset($_SESSION['customer_id'])) : ?>
                                            <input type="hidden" name="customer-id" value="<?= $_SESSION['customer_id'] ?>">
                                        <?php else : ?>
                                            <input type="hidden" name="session-id" value="<?= session_id() ?>">
                                        <?php endif ?>

                                        <button class="btn btn-outline-<?php if ($product->quantidade <= 0 || Store::is_admin_logged()) echo 'secondary';
                                                                        else echo 'success'; ?> w-100 mx-2 mb-2 rounded-0" type="submit" <?php if ($product->quantidade <= 0 || Store::is_admin_logged()) echo 'disabled' ?>>Adicionar ao carrinho</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<script>
    function submitForm() {
        document.getElementById("filters").submit();
    }
</script>