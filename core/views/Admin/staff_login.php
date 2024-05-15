<div class="container-fluid my-auto">
    <div class="col-4 mx-auto">
        <div class="card shadow-sm rounded-0">
            <div class="card-body p-5">
                <h3 class="text-center mb-5">Admin</h3>
                <form action="?a=admin" method="POST">
                    <div class="d-flex flex-column gap-3">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control rounded-0" id="username" name="username" placeholder="" required />
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="" required />
                            <label for="password">Senha</label>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary rounded-0 btn-lg px-4 py-2" type="submit">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>