<a href="<?php echo BASE_URL; ?>">[PÁGINA PRINCIPAL]</a>

<h2>Formulário de Edição de Usuário</h2>
<form method="POST" action="<?php echo BASE_URL; ?>contato/editar_submit">
    <input type="hidden" name="id" value="<?php echo $info["id"]; ?>"/>
    <p>Nome: </p>
    <input type="text" name="nome" value="<?php echo $info["nome"]; ?>"/>
    <p>E-mail: </p>
    <input type="email" name="email" value="<?php echo $info["email"]; ?>"/><br>
    <input type="submit" value="Alterar">
</form>