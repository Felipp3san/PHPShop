<div class="container my-5 col-4">
    <h2>Adicionar Gestor</h2>
    <form action="?a=add_staff" method="POST">
        <div class="d-flex flex-column gap-3 mt-5">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control rounded-0" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="nome">Senha</label>
                <input type="password" class="form-control rounded-0" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="nome">Confirmar Senha</label>
                <input type="password" class="form-control rounded-0" id="confirm-password" name="confirm-password" required>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary rounded-0">Adicionar Gestor</button>
                <a class="btn btn-secondary rounded-0" href="?a=management_panel">Retornar</a>
            </div>
        </div>
    </form>
</div>