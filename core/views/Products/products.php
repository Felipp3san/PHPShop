<?php
use core\models\Favorite;
?>

<div class="container-fluid">
    <h3 class="mb-4"><?= $category_name ?></h3>
    <div class="row">
        <div class="col-3">
            <div class="product-card p-2">
                <h5>Filtros</h5>
                <form id="filters" action="?a=products&category-name=<?= $category_name ?>&id=<?= $category_id ?>" method="POST">
                    <p class="m-0">Stock</p>
                    <hr class="mx-0 my-1">
                    <div>
                        <input class="form-check-input rounded-0" type="checkbox" id="in-stock" name="in-stock" onclick="submitForm()" value="1" <?php if (isset($_POST['in-stock'])) echo 'checked'; ?>>
                        <label class="form-check-label" for="in-stock">Disponível</label>
                    </div>
                    <div>
                        <input class="form-check-input rounded-0" type="checkbox" id="no-stock" name="no-stock" onclick="submitForm()" value="1" <?php if (isset($_POST['no-stock'])) echo 'checked'; ?>>
                        <label class="form-check-label" for="no-stock">Indisponível</label>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-9">
            <div class="row">
                <?php foreach ($data as $produto) : ?>
                    <div class="col-md-3 px-1">
                        <div class="product-card">
                            <!-- IMAGEM -->
                            <div class="product-image">
                                <img src="assets/images/produtos/<?= $category_name . '/' . $produto->imagem ?>" class="img-fluid mb-3" alt="<? $produto->nome ?>">
                            </div>
                            <!-- DESCRICAO -->
                            <div class="product-text">
                                <h6 class="product-name mb-3"><?= $produto->nome ?></h5>
                                    <p class="product-description fw-light"><?= $produto->descricao ?></p>
                                    <!-- AVALIAÇÃO -->
                                    <div class="product-reviews mb-2">
                                        <?php if ($produto->avaliacao_media != null) : ?>
                                            <?php for ($i = 0; $i < $produto->avaliacao_media; $i++) : ?>
                                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            <?php endfor ?>
                                            <?php for ($i; $i < 5; $i++) : ?>
                                                <i class="fa-regular fa-star" style="color: #FFD43B;"></i>
                                            <?php endfor ?>
                                            <span><?= '(' . $produto->total_avaliacoes . ')' ?></span>
                                        <?php else : ?>
                                            <?php for ($i = 0; $i < 5; $i++) : ?>
                                                <i class="fa-regular fa-star" style="color: #FFD43B;"></i>
                                            <?php endfor ?>
                                            <span>(0)</span>
                                        <?php endif ?>
                                    </div>
                                    <!-- DISPONILIBIDADE -->
                                    <?php if ($produto->quantidade > 10) : ?>
                                        <div class="text-success product-availability">
                                            <i class="fa-regular fa-circle-check"></i>
                                            <span>Disponível</span>
                                        </div>
                                    <?php elseif ($produto->quantidade <= 10 && $produto->quantidade > 0) : ?>
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
                                        <p class="product-price fs-4 fw-bold mb-0"><?= $produto->preco ?> €</p>

                                        <?php if(isset($_SESSION['customer_id'])):?>

                                            <?php if(Favorite::verify_favorite($_SESSION['customer_id'], $produto->id)):?>
                                                <form action="?a=remove_favorite" method="POST">
                                                    <input type="hidden" name="actual-url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                                    <input type="hidden" name="favorite-customer-id" value="<?= $_SESSION['customer_id'] ?>">
                                                    <input type="hidden" name="favorite-item-id" value="<?= $produto->id ?>">
                                                    <button class="btn btn-link p-0" type="submit">
                                                        <i class="fa-solid fa-heart fa-xl" style="color: #ff0000;"></i>
                                                    </button>
                                                </form>
                                            <?php else:?>
                                                <form action="?a=add_favorite" method="POST">
                                                    <input type="hidden" name="actual-url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                                    <input type="hidden" name="favorite-customer-id" value="<?= $_SESSION['customer_id'] ?>">
                                                    <input type="hidden" name="favorite-item-id" value="<?= $produto->id ?>">
                                                    <button class="btn btn-link p-0" type="submit">
                                                        <i class="fa-regular fa-heart fa-xl" style="color: #ff0000;"></i>
                                                    </button>
                                                </form>
                                            <?php endif ?>
                                        <?php endif ?>
                                    </div>
                            </div>
                            <!-- ADICIONAR CARRINHO -->
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-outline-success w-100 rounded-0" href="">Adicionar ao carrinho</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    function submitForm() {
        document.getElementById("filters").submit();
    }
</script>