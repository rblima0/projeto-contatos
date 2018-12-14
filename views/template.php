<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de Contato - CRUD MVC</title>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <a href="<?php echo BASE_URL; ?>" class="navbar-brand">CONTATOS</a>
            </div>
            <div class="nav navbar-nav navbar-right">
                <li><a href="<?php echo BASE_URL; ?>contato/adicionar">Adicionar Contato</a></li>
            </div>
        </div>
    </nav>

    <?php $this->loadViewInTemplate($viewName, $viewData); ?>
    
</body>
    <script src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
</html>