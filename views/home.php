<?php
    function mask($val, $mask) {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++) {
            if($mask[$i] == '#') {
                if(isset($val[$k]))
                $maskared .= $val[$k++];
            } else {
                if(isset($mask[$i]))
                $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
?>

    <div class="container">
        <div class="row">

        <h2>Lista de Contatos</h2>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            
            <tbody>
                <?php 
                foreach ($lista as $item) : ?>
                <tr>
                    <td><?php echo $item["id"] ?></td>
                    <td>
                        <?php if(!empty($item['foto'])): ?>
                            <img class="skin" src="<?php echo BASE_URL; ?>assets/images/contatos/<?php echo $item['foto']?>" alt="<?php echo $item['nome'] ?>">
                        <?php else: ?>
                            <img class="skin" src="<?php echo BASE_URL; ?>assets/images/contatos/picture.png" alt="Contato sem imagem." />
                        <?php endif; ?>
                    </td>
                    <td><?php echo $item["nome"] ?></td>
                    <td><?php echo mask($item["telefone"], '(##) # ####-####') ?></td>
                    <td><?php echo $item["email"] ?></td>
                    <td>
                        <a class="btn btn-warning" href="<?php echo BASE_URL; ?>contato/editar/<?php echo $item["id"]; ?>">EDITAR</a>
                        <a class="btn btn-danger" href="<?php echo BASE_URL; ?>contato/excluir/<?php echo $item["id"]; ?>">EXCLUIR</a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>

        </table>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php $p = isset($_GET['p']) ? $_GET['p'] : 0; ?>
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <li class="page-item <?php echo ($p == $i) ? 'active': ''; ?>"><a class="page-link" href="<?php echo BASE_URL; ?>?<?php $w = $_GET; $w['p'] = $i; echo http_build_query($w); ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>
            </ul>
        </nav>

        </div>
    </div>