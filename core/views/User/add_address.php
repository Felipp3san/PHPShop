<div class="container my-5">
    <div class="product-card col-6 mx-auto shadow p-5">
        <div class="card-header">
            <h2 class="mb-4">Adicionar nova morada</h2>
        </div>
        <form action="?a=add_address" method="post">
            <div class="card-body d-flex flex-column gap-3">
                <div class="form-group">
                    <div class="form-floating">
                        <input type="text" class="form-control rounded-0" id="nome" name="nome" placeholder=" " required>
                        <label for="nome">Nome</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-floating">
                        <input type="text" class="form-control rounded-0" id="apelido" name="apelido" placeholder=" " required>
                        <label for="apelido">Apelido</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-floating">
                        <input type="text" class="form-control rounded-0" id="morada" name="morada" placeholder=" " required>
                        <label for="morada">Morada</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-floating">
                        <input type="text" class="form-control rounded-0" id="cidade" name="cidade" placeholder=" " required>
                        <label for="cidade">Cidade</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-floating">
                        <input type="text" class="form-control rounded-0" id="cod_postal" name="cod_postal" placeholder=" " required>
                        <label for="cod_postal">Código Postal</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-floating">
                        <input type="text" class="form-control rounded-0" id="telefone" name="telefone" placeholder=" ">
                        <label for="telefone">Telefone</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-floating">
                        <input type="text" class="form-control rounded-0" id="nif" name="nif" placeholder=" " required>
                        <label for="nif">NIF</label>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-center">
                    <button type="submit" class="btn btn-primary btn-lg rounded-0">Adicionar</button>
                    <a class="btn btn-secondary rounded-0 btn-lg px-5" href="?a=account">Retornar</a>
                </div>
            </div>
        </form>
    </div>
</div>