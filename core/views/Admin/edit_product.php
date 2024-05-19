<div class="container">
    <form action="?edit_product" method="post">
        <div class="col-6 mx-auto d-flex flex-column gap-2">
            <label for="id" class="form-label m-0">ID do produto</label>
            <input class="form-control rounded-0 " type="text" id="id" value="<?= $product->id ?>" disabled>

            <label for="nome" class="form-label m-0">Nome</label>
            <input class="form-control rounded-0 " type="text" id="nome" value="<?= $product->nome ?>">

            <label for="descricao-curta" class="form-label m-0">Descrição Curta</label>
            <textarea class="form-control rounded-0 " type="text" id="descricao-curta" rows="5"><?= $product->descricao_curta ?></textarea>

            <label for="descricao" class="form-label m-0">Descrição</label>
            <textarea class="form-control rounded-0 " type="text" id="descricao" rows="5"><?= $product->descricao ?></textarea>

            <label for="fabricante" class="form-label m-0">Fabricante</label>
            <select class="form-control rounded-0" id="fabricante">
                <?php foreach($manufacturers as $manufacturer): ?>
                    <option value="<?= $manufacturer->id ?>" <?php if($product->fabricante_id == $manufacturer->id) echo 'selected'?>><?= $manufacturer->nome ?></option>
                <?php endforeach ?>
            </select>

            <label for="preco" class="form-label m-0">Preço</label>
            <input class="form-control rounded-0 " type="text" id="preco" value="<?= $product->preco ?>">

            <label for="quantidade" class="form-label m-0">Quantidade</label>
            <input class="form-control rounded-0 " type="number" id="quantidade" value="<?= $product->quantidade ?>">

            <label for="categoria" class="form-label m-0">Categoria</label>
            <select class="form-control rounded-0" id="fabricante">
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category->id ?>"<?php if($product->categoria_id == $category->id) echo 'selected'?>><?= $category->nome ?></option>
                <?php endforeach ?>
            </select>

            <label for="imagem">Imagem</label>
            <input type="file" class="form-control-file" id="imagem" name="imagens[]" multiple>
            <p class="mt-2 alert alert-warning">As imagens devem estar na pasta com o mesmo nome da categoria!</p>

            <div class="d-flex gap-2">
                <input type="checkbox" class="form-check-input rounded-0" id="ativo" name="ativo" checked>
                <label class="form-check-label" for="ativo">Ativo</label>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary rounded-0">Atualizar Produto</button>
                <a class="btn btn-secondary rounded-0" href="?a=management_panel">Retornar</a>
            </div>
        </div>
    </form>
</div>