 
<a href="<?php echo BASE_URL; ?>">[PÁGINA PRINCIPAL]</a>

<h2>Formulário de Contato</h2>
<form method="POST" action="<?php echo BASE_URL; ?>contato/adicionar_submit">
    <p>Nome: </p>
    <input type="text" name="nome" placeholder="Informe seu Nome...">
    <p>E-mail: </p>
    <input type="email" name="email" placeholder="Informe seu E-mail..."/><br>
    <input type="submit" value="Cadastrar">
</form>