<div class="container">
    <h3 class="mb-4">Favoritos</h3>
    <div class="row">
        <?php foreach ($favorites as $favorite) : ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm rounded-0">
                    <img class="p-4" src="assets/images/produtos/<?= substr($favorite->imagem, 0, strpos($favorite->imagem, "@")) ?>" class="img-fluid mb-3" alt="<? $favorite->nome ?>">
                    <div class="card-body">
                        <h5 class="card-title favorite-card-text"><?= $favorite->nome ?></h5>
                        <p class="card-text favorite-card-text"><?= $favorite->descricao ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <form action="?a=remove_favorite" method="POST">
                                <input type="hidden" name="actual-url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                <input type="hidden" name="favorite-customer-id" value="<?= $_SESSION['customer_id'] ?>">
                                <input type="hidden" name="favorite-item-id" value="<?= $favorite->id ?>">
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-outline-secondary" href="?a=details&product-id=<?= $favorite->id ?>">Ver Detalhes</a>
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Remover dos Favoritos</button>
                                </div>
                            </form>
                            <small class="text-muted"><?= $favorite->preco ?> €</small>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>