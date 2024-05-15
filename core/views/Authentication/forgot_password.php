<div class="container-fluid my-auto">
    <div class="d-flex justify-content-center">
        <!-- RECUPERAR ACESSO -->
        <form action="?a=forgot_password" method="POST">
            <div id="recovery" class="card shadow-sm rounded-0">
                <div class="card-body p-5">
                    <div class="d-flex flex-column gap-3">
                        <h3 class="text-center">Recuperar acesso</h3>
                        <div class="d-grid">
                            <p class="text-center">Informe o email associado a conta</p>
                            <div class="form-floating">
                                <input type="email" class="form-control rounded-0" id="email" name="email" placeholder="name@example.com" required />
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-primary rounded-0 btn-lg px-4 py-2" type="submit">Enviar email</button>
                            <a class="btn btn-transparent rounded-0 btn-lg px-4 py-2" href="?a=<?= $_SESSION['previous-action'] ?>">Retornar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>