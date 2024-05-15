<div class="container-fluid my-auto">
    <div class="d-flex justify-content-center">
        <form action="?a=recovery" method="POST">
            <div id="recovery" class="card shadow-sm rounded-0">
                <div class="card-body p-5 d-flex flex-column justify-content-between">
                    <h3 class="text-center mb-5">Recuperação de conta</h3>
                    <div class="d-flex flex-column gap-3">
                        <input type="hidden" name="purl" value="<?php echo $_GET['purl']; ?>">
                        <div class="d-grid gap-3">
                            <div class="form-floating overflow-hidden">
                                <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="" required />
                                <label for="password">Nova Senha</label>
                            </div>
                            <div class="form-floating overflow-hidden">
                                <input type="password" class="form-control rounded-0" id="confirm-password" name="confirm-password" placeholder="" required />
                                <label for="password">Confirmar senha</label>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-primary rounded-0 btn-lg px-4 py-2" type="submit">Confirmar</button>
                            <a class="btn btn-transparent rounded-0 btn-lg px-4 py-2" href="?a=index">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>