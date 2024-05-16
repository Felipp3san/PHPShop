<style>
    .address {
        overflow: hidden;
        min-height: calc(1.2em * 2);
        /* 2 lines with a line height of 1.2em */
        line-height: 1.2em;
        /* Adjust line height according to your design */
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        /* Number of lines before the ellipsis */
    }
</style>

<?php

use core\models\User;
?>

<div class="container my-5">
    <h2 class="mb-4">Dados da Conta</h2>
    <div class="product-card shadow p-4">
        <div class="card-body d-flex flex-column gap-3">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label rounded-0">Nome Completo:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control rounded-0" value="<?= ucfirst($account_data->nome_completo) ?>" readonly>
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-outline-primary rounded-0">Editar</button>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label rounded-0">Email:</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control rounded-0" value="<?= $account_data->email ?>" readonly>
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-outline-primary rounded-0">Editar</button>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label rounded-0">Senha:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control rounded-0" value="**********" readonly>
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-outline-primary rounded-0">Editar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col pt-5">
            <h2 class="mb-4">Informações de Morada/Faturação</h2>
            <?php if (!User::address_quantity($_SESSION['customer_id']) > 0) : ?>
                <div class="product-card shadow p-4">
                    <div class="card-body d-flex flex-column gap-3">
                        <p class="lead mb-0">
                            Não há moradas para visualizar
                        </p>
                    </div>
                </div>

            <?php else : ?>

                <div class="row mb-3">
                    <?php if (isset($addresses) && !empty($addresses)) : ?>
                        <?php foreach ($addresses as $address) : ?>
                            <div class="col-4">
                                <div class="product-card border <?php if ($address->ativo == 1) echo "shadow border-dark-subtle"; ?>">
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
                                                <input type="hidden" name="address-id" value="<?= $address->id ?>">
                                                <button class="btn btn-outline-danger rounded-0">Eliminar</button>
                                            </form>
                                            <?php if ($address->ativo != 1) : ?>
                                                <form action="?a=define_default_address" method="post">
                                                    <input type="hidden" name="address-id" value="<?= $address->id ?>">
                                                    <button class="btn btn-outline-primary rounded-0">Definir padrão</button>
                                                </form>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            <?php endif ?>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <a class="btn btn-outline-dark rounded-0" href="?a=add_address"><i class="fa-solid fa-address-book fa-xl py-3"></i><span class="mx-2">Adicionar nova morada</span></a>
        </div>
    </div>

</div>