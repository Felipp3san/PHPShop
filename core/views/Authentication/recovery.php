<div class="container-fluid">
    <div class="row my-5">
        <div class="col-12">
            <h3 class="text-center">Recuperação de conta</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-3 mx-auto">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger mb-3 py-3 text-center" role="alert">
                    <?= $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']);?>
            <?php endif ?>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success mb-3 py-3 text-center" role="alert">
                    <?= $_SESSION['success'] ?>
                </div>
            <?php endif ?>
        </div>
    </div>
    <?php if(!isset($_SESSION['success'])):  ?>
        <div class="row">
            <div class="col-3 mx-auto">
                <form action="?a=recovery" method="POST">
                    <div class="d-flex flex-column gap-3">
                        <input type="hidden" name="purl" value="<?php echo $_GET['purl'];?>">
                        <div>
                            <label class="form-label" for="password">Nova senha</label>
                            <input class="form-control p-2" type="password" id="password" name="password" required />
                        </div>
                        <div>
                            <label class="form-label" for="confirm-password">Confirme a nova senha</label>
                            <input class="form-control p-2" type="password" id="confirm-password" name="confirm-password" required />
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg px-4 py-2" type="submit">Confirmar</button>
                            <a class="btn btn-transparent btn-lg px-4 py-2" href="?a=index">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-3 mx-auto">
                <a class="btn btn-primary btn-lg w-100 py-2" href="?a=index">Página Inicial</a>
            </div> 
        </div> 
        <?php unset($_SESSION['success']);?>
    <?php endif ?>
    </div>