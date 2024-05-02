<div class="container">
    <h3 class="mt-5 mb-4"><?= $category_name ?></h1>
        <div class="row">
            <?php foreach($data as $produto): ?>
                <div class="col-md-3">
                    <div class="product-card">
                        <!-- IMAGEM -->
                        <div class="product-image">
                            <img src="assets/images/produtos/<?= $produto->imagem?>" class="img-fluid mb-3" alt="<? $produto->nome ?>">
                        </div>
                        <!-- DESCRICAO -->
                        <div class="product-text">
                            <h6 class="product-name mb-3"><?= $produto->nome ?></h5>
                            <p class="product-description fw-light"><?= $produto->descricao ?></p>
                            <!-- AVALIAÇÃO -->
                            <div class="product-reviews mb-2">
                                <?php if($produto->avaliacao_media != null):?>
                                    <?php for ($i=0; $i < $produto->avaliacao_media; $i++): ?>
                                        <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                    <?php endfor ?>
                                    <?php for ($i; $i < 5; $i++): ?>
                                        <i class="fa-regular fa-star" style="color: #FFD43B;"></i>
                                    <?php endfor ?>
                                    <span><?='(' . $produto->total_avaliacoes . ')'?></span>
                                <?php else: ?>
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fa-regular fa-star" style="color: #FFD43B;"></i>
                                    <?php endfor ?>
                                    <span>(0)</span>
                                <?php endif ?>
                            </div>
                            <!-- DISPONILIBIDADE -->
                            <?php if($produto->quantidade > 0): ?>
                                <div class="text-success">
                                    <i class="fa-regular fa-circle-check"></i>
                                    <span>Disponível</span>
                                </div>
                            <?php else: ?>
                                <div class="text-danger">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                    <span>Indisponível</span>
                                </div>
                            <?php endif ?>
                            <!-- PREÇO -->
                            <p class="fs-4 fw-bold mb-0"><?= $produto->preco ?> €</p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
</div>