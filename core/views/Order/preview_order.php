<?php

use core\models\User;
?>

<style>
	.address-card,
	.payment-card {
		transition-duration: 0.5s;
		transform: scale(0.9);
	}

	.address-card:hover,
	.payment-card:hover {
		cursor: pointer;
	}

	.label-discreto {
    font-weight: normal; /* ou um valor como 300 */
    font-size: 0.875rem; /* tamanho de fonte menor, ajuste conforme necessário */
}
</style>

<div class="container-fluid">
	<form action="?a=checkout" method="post">
		<h2 class="mb-4">Finalizar pedido</h2>

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

							<div class="row px-2">
								<?php if (isset($addresses) && !empty($addresses)) : ?>
									<?php foreach ($addresses as $address) : ?>
										<div class="col-4 p-0">
											<div class="product-card address-card border <?php if ($address->ativo == 1) echo "shadow";
																							else echo "shadow-sm"; ?>" <?php if ($address->ativo == 1) echo "style='transform: scale(0.975);'"; ?>>
												
												<input type="radio" name="address" value="<?= $address->id ?>" hidden <?php if ($address->ativo == 1) echo "checked";?>>
												<div class="card-body">
													<ul class="list-group rounded-0">
														<li class="list-group-item border-0 pb-1 border-bottom">
															<div class="row">
																<label class="label-discreto fw-semibold" for="nome">Nome</label>
																<span class="text-muted" id="nome"><?= ucwords($address->nome) ?></span>
															</div>
														</li>
														<li class="list-group-item border-0 pt-0 pb-1 border-bottom">
															<div class="row">
																<label class="label-discreto fw-semibold" for="apelido">Apelido</label>
																<span class="text-muted" id="apelido"><?= ucwords($address->apelido) ?></span>
															</div>
														</li>
														<li class="list-group-item border-0 pt-0 pb-1 border-bottom">
															<div class="row">
																<label class="label-discreto fw-semibold" for="morada">Morada</label>
																<span class="text-muted text-truncate" id="morada"><?= ucwords($address->morada) ?></span>
															</div>
														</li>
														<li class="list-group-item border-0 pt-0 pb-1 border-bottom">
															<div class="row">
																<label class="label-discreto fw-semibold" for="cidade">Cidade</label>
																<span class="text-muted" id="cidade"><?= ucwords($address->cidade) ?></span>
															</div>
														</li>
														<li class="list-group-item border-0 pt-0 pb-1 border-bottom">
															<div class="row">
																<label class="label-discreto fw-semibold" for="cod-postal">Código Postal</label>
																<span class="text-muted" id="cod-postal"><?= substr($address->cod_postal, 0, 4) . '-' . substr($address->cod_postal, 4) ?></span>
															</div>
														</li>
														<li class="list-group-item border-0 pt-0 pb-1 border-bottom">
															<div class="row">
																<label class="label-discreto fw-semibold" for="telefone">Telefone</label>
																<span class="text-muted" id="telefone"><?= $address->telefone ?></span>
															</div>
														</li>
														<li class="list-group-item border-0 pt-0">
															<div class="row">
																<label class="label-discreto fw-semibold" for="nif">NIF</label>
																<span class="text-muted" id="nif"><?= $address->nif ?></span>
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
				<div class="product-card shadow p-3">
					<div class="card-body">
						<h5 class="card-title mb-3">Forma de pagamento</h5>
						<div class="product-card p-3 payment-card shadow-sm border">
							<input type="radio" name="payment" id="paypal" value="4" hidden>
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-4">
										<img src="assets/images/pagamentos/paypal.png" alt="PayPal" style="max-width: 200px;">
									</div>
									<div class="col">
										<strong class="fs-5">PayPal</strong>
									</div>
								</div>
							</div>
						</div>
						<div class="product-card p-3 payment-card shadow-sm border">
							<input type="radio" name="payment" id="transfer" value="3" hidden>
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-4">
										<img src="assets/images/pagamentos/mbway.png" alt="Transferência Bancária" style="max-width: 200px;">
									</div>
									<div class="col">
										<strong class="fs-5">Transferência Bancária</strong>
									</div>
								</div>
							</div>
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
									<input type="hidden" name="cart-items-ids[]" value="<?= $item->item_id ?>">
									<input type="hidden" name="cart-items-quantities[]" value="<?= $item->quantidade ?>">
									<input type="hidden" name="cart-items-prices[]" value="<?= $item->preco * $item->quantidade ?>">
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
				<div class="product-card shadow p-3">
					<div class="card-body">
						<!-- Resumo do carrinho -->
						<h5 class="card-title mb-3">Resumo do Pedido</h5>
						<ul class="list-group rounded-0">
							<li class="list-group-item d-flex justify-content-between align-items-center">
								Subtotal
								<span><?php echo number_format($total = (!isset($total)) ? 0 : $total, 2) ?> €</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								Frete
								<span>Grátis</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<strong>Total</strong>
								<strong><?php echo number_format($total = (!isset($total)) ? 0 : $total, 2) ?> €</strong>
							</li>
						</ul>
						<!-- Botões de ação -->
						<div class="d-grid mt-3">
							<button type="submit" class="btn btn-primary btn-block rounded-0">Finalizar Compra</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	const addressCard = document.getElementsByClassName("address-card");
	const paymentCard = document.getElementsByClassName("payment-card");

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

			let input = card.querySelector("input");
			input.checked = true;
		})

	});

	Array.from(paymentCard).forEach((card) => {

		card.addEventListener("click", (e) => {

			Array.from(paymentCard).forEach((card) => {
				card.classList.remove("shadow");
				card.style.transform = "scale(0.9)";
				card.classList.add("shadow-sm");
			});

			card.classList.remove("shadow-sm");
			card.classList.add("shadow");
			card.style.transform = "scale(0.975)";

			let input = card.querySelector("input");
			input.checked = true;
		})

	});
</script>