<?php

use core\models\User;
?>

<style>
  .address-card {
    transition-duration: 0.5s;
    transform: scale(0.9);
  }

  .address-card:hover {
    cursor: pointer;
  }
</style>

<div class="container-fluid">
  <h2 class="mt-4 mb-4">Finalizar pedido</h2>

  <div class="row">
    <div class="col-md-8">
      <div class="product-card shadow p-3">
        <div class="card-body">
          <h5 class="card-title mb-3">Selecione a morada de entrega</h5>

          <?php if (!User::address_quantity($_SESSION['customer_id']) > 0) : ?>
            <div class="product-card shadow p-4">
              <div class="card-body d-flex flex-column gap-3">
                <p class="lead mb-0">
                  Não há moradas para visualizar
                </p>
              </div>
            </div>

          <?php else : ?>

            <div class="row">
              <?php if (isset($addresses) && !empty($addresses)) : ?>
                <?php foreach ($addresses as $address) : ?>
                  <div class="col-4">
                    <div class="product-card address-card border <?php if ($address->ativo == 1) echo "shadow"; ?>" <?php if ($address->ativo == 1) echo "style='transform: scale(0.975);'"; ?>>
                      <div class="card-body">
                        <ul class="list-group rounded-0">
                          <li class="list-group-item border-0 border-bottom">
                            <div class="row">
                              <div class="col-5">
                                <strong>Nome:</strong>
                              </div>
                              <div class="col">
                                <span class="text-muted"><?= ucfirst($address->nome) ?></span>
                              </div>
                            </div>
                          </li>
                          <li class="list-group-item border-0 border-bottom">
                            <div class="row">
                              <div class="col-5">
                                <strong>Apelido:</strong>
                              </div>
                              <div class="col">
                                <span class="text-muted"><?= ucfirst($address->apelido) ?></span>
                              </div>
                            </div>
                          </li>
                          <li class="list-group-item border-0 border-bottom">
                            <div class="row">
                              <div class="col-5">
                                <strong>Morada:</strong>
                              </div>
                              <div class="col">
                                <span class="text-muted address"><?= ucfirst($address->morada) ?></span>
                              </div>
                            </div>
                          </li>
                          <li class="list-group-item border-0 border-bottom">
                            <div class="row">
                              <div class="col-5">
                                <strong>Cidade:</strong>
                              </div>
                              <div class="col">
                                <span class="text-muted"><?= ucfirst($address->cidade) ?></span>
                              </div>
                            </div>
                          </li>
                          <li class="list-group-item border-0 border-bottom">
                            <div class="row">
                              <div class="col-5">
                                <strong>Código Postal:</strong>
                              </div>
                              <div class="col">
                                <span class="text-muted"><?= $address->cod_postal ?></span>
                              </div>
                            </div>
                          </li>
                          <li class="list-group-item border-0 border-bottom">
                            <div class="row">
                              <div class="col-5">
                                <strong>Telefone:</strong>
                              </div>
                              <div class="col">
                                <span class="text-muted"><?= $address->telefone ?></span>
                              </div>
                            </div>
                          </li>
                          <li class="list-group-item border-0 border-bottom">
                            <div class="row">
                              <div class="col-5">
                                <strong>NIF:</strong>
                              </div>
                              <div class="col">
                                <span class="text-muted"><?= $address->nif ?></span>
                              </div>
                            </div>
                          </li>
                        </ul>
                        <div class="d-flex justify-content-center gap-2 my-3">
                          <form action="?a=remove_address" method="post">
                            <input type="hidden" name="actual-url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                            <input type="hidden" name="address-id" value="<?= $address->id ?>">
                            <button class="btn btn-outline-danger rounded-0">Eliminar</button>
                          </form>
                          <form action="?a=edit_address" method="post">
                            <input type="hidden" name="address-id" value="<?= $address->id ?>">
                            <button class="btn btn-outline-success rounded-0">Editar</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach ?>
              <?php endif ?>
            </div>
          <?php endif ?>
        </div>
        <div class="row">
          <div class="col-6">
            <a class="btn btn-transparent rounded-0" href="?a=add_address&actual-url=<?= substr(htmlspecialchars($_SERVER['REQUEST_URI']), 4) ?>"><i class="fa-solid fa-address-book fa-xl py-3"></i><span class="mx-2">Adicionar nova morada</span></a>
          </div>
        </div>
      </div>
    </div>
    <!-- DETALHES DO CARRINHO  -->
    <div class="col-md-4">
      <div class="product-card shadow p-3">
        <div class="card-body">
          <h5 class="card-title mb-3">Detalhes do pedido</h5>
          <ul class="list-group rounded-0">
            <!-- ITENS CARRINHO -->
            <?php if (isset($data['cart_items']) && $data['cart_items'] != false) : ?>
              <li class="list-group-item">
                <div class="row text-center">
                  <div class="col"><span>Produtos</span></div>
                </div>
              </li>
              <?php foreach ($data['cart_items'] as $item) : ?>
                <li class="list-group-item">
                  <div class="row d-flex justify-content-between align-items-center">
                    <!-- IMAGEM -->
                    <div class="col-4">
                      <a href="?a=details&product-id=<?= $item->item_id ?>">
                        <img src="assets/images/produtos/<?= substr($item->imagem, 0, strpos($item->imagem, "@")) ?>" class="img-thumbnail border-0" width="150" height="150" alt="<? $product->nome ?>">
                      </a>
                    </div>
                    <div class="col-8 d-flex flex-column gap-2">
                      <!-- TITULO -->
                      <div class="row">
                        <span class="fw-semibold"><?= $item->nome ?></span>
                      </div>
                      <!-- QUANTIDADE -->
                      <div class="row d-inline-flex">
                        <span class="fs-6">Quantidade: <?= $item->quantidade ?></span>
                      </div>
                      <!-- PRECO TOTAL -->
                      <div class="row">
                        <span class="lead fw-medium fs-4"><?= number_format($item->preco * $item->quantidade, 2) ?> €</span>
                      </div>
                    </div>
                    <!-- SOMAR TOTAL DOS PRODUTOS -->
                    <?php $total = (!isset($total)) ? $item->preco * $item->quantidade : $total + $item->preco * $item->quantidade ?>
                  </div>
                </li>
              <?php endforeach ?>
            <?php endif ?>
          </ul>
        </div>
      </div>
      <button class="btn btn-primary w-100 rounded-0">Finalizar Pedido</button>
    </div>
  </div>
</div>

<script>
  const addressCard = document.getElementsByClassName("address-card");

  Array.from(addressCard).forEach((card) => {

    card.addEventListener("click", (e) => {

      Array.from(addressCard).forEach((card) => {
        card.classList.remove("shadow");
        card.style.transform = "scale(0.9)";
        card.classList.add("shadow-sm");
      });

      card.classList.remove("shadow-sm");
      card.classList.add("shadow");
      card.style.transform = "scale(0.975)";
    })

  });
</script>