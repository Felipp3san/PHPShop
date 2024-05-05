<div class="container my-5">
    <h2>Adicionar Produto</h2>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger mb-3 p-3 text-center" role="alert">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif ?>
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="alert alert-success mb-3 p-3 text-center" role="alert">
            <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif ?>
    <form action="?a=add_products" method="POST">
        <div class="d-flex flex-column gap-3 mt-4">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control rounded-0" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <input type="text" class="form-control rounded-0" id="descricao" name="descricao">
            </div>
            <div class="form-group">
                <label for="fabricante_id">Fabricante</label>
                <select class="form-control rounded-0" id="fabricante_id" name="fabricante_id" required>
                    <option value="">Selecione o fabricante</option>
                    <?php foreach ($fabricantes as $fabricante) : ?>
                        <option value="<?= $fabricante->id ?>"><?= $fabricante->nome ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label for="preco">Preço</label>
                <input type="number" step="0.01" class="form-control rounded-0" id="preco" name="preco" required>
            </div>
            <div class="form-group">
                <label for="quantidade">Quantidade</label>
                <input type="number" class="form-control rounded-0" id="quantidade" name="quantidade" required>
            </div>
            <div class="form-group">
                <label for="categoria_id">Categoria</label>
                <select class="form-control rounded-0" id="categoria_id" name="categoria_id" required>
                    <option value="">Selecione a categoria</option>
                    <?php foreach ($categorias as $categoria) : ?>
                        <option value="<?= $categoria->id ?>"><?= $categoria->nome ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <label for="imagem">Imagem</label>
                <input type="file" class="form-control-file" id="imagem" name="imagem">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input rounded-0" id="ativo" name="ativo" checked>
                <label class="form-check-label" for="ativo">Ativo</label>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary rounded-0">Adicionar Produto</button>
                <a class="btn btn-secondary rounded-0" href="?a=management_panel">Retornar</a>
            </div>
        </div>
    </form>
</div>