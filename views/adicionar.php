 
<div class="container">
    <div class="row">

    <h2>Formulário de Contato</h2>

    <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL; ?>contato/adicionar_submit"  >

        <div class="form-group">
            <label for="nome">Nome: </label>
            <input type="text" name="nome" placeholder="Informe seu Nome..." class="form-control" required />
        </div>

        <div class="form-group">
            <label for="telefone">Telefone: </label>
            <input type="number" name="telefone" placeholder="Informe seu Telefone..." class="form-control" required />
        </div>

        <div class="form-group">
            <label for="email">E-mail: </label>
            <input type="mail" name="email" placeholder="Informe seu E-mail..." class="form-control" required />
        </div>

        <div class="form-group">
            <label for="foto">Foto: </label>
            <input type="file" name="foto" class="form-control" />
        </div>

        <input type="submit" value="Cadastrar" class="btn btn-default">
    </form>

    </div>
</div>