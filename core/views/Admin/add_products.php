  <div class="container my-5">
      <h2>Adicionar Produto</h2>
      <form action="?a=add_products" method="POST">
          <div class="d-flex flex-column gap-3 mt-5">
              <div class="form-group">
                  <label for="nome">Nome</label>
                  <input type="text" class="form-control" id="nome" name="nome" required>
              </div>
              <div class="form-group">
                  <label for="descricao">Descrição</label>
                  <input type="text" class="form-control" id="descricao" name="descricao">
              </div>
              <div class="form-group">
                  <label for="fabricante_id">Fabricante</label>
                  <select class="form-control" id="fabricante_id" name="fabricante_id" required>
                      <option value="">Selecione o fabricante</option>
                      <?php foreach ($fabricantes as $fabricante) : ?>
                          <option value="<?= $fabricante->id ?>"><?= $fabricante->nome ?></option>
                      <?php endforeach ?>
                  </select>
              </div>
              <div class="form-group">
                  <label for="preco">Preço</label>
                  <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
              </div>
              <div class="form-group">
                  <label for="quantidade">Quantidade</label>
                  <input type="number" class="form-control" id="quantidade" name="quantidade" required>
              </div>
              <div class="form-group">
                  <label for="categoria_id">Categoria</label>
                  <input type="number" class="form-control" id="categoria_id" name="categoria_id" required>
              </div>
              <div class="form-group">
                  <label for="imagem">Imagem</label>
                  <input type="file" class="form-control-file" id="imagem" name="imagem">
              </div>
              <div class="form-group form-check">
                  <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1" checked>
                  <label class="form-check-label" for="ativo">Ativo</label>
              </div>
              <button type="submit" class="btn btn-primary">Adicionar Produto</button>
            </div>
      </form>
  </div>
  </body>

  </html>