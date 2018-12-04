
    <a href="<?php echo BASE_URL; ?>contato/adicionar" class="modal_ajax">[ADICIONAR NOVO USUÁRIO]</a>
    <h2>Lista de Contatos</h2>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>E-MAIL</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        
        <tbody>
            <?php 
            foreach ($lista as $item) : ?>
            <tr>
                <td><?php echo $item["id"] ?></td>
                <td><?php echo $item["nome"] ?></td>
                <td><?php echo $item["email"] ?></td>
                <td>
                    <a class="modal_ajax" href="<?php echo BASE_URL; ?>contato/editar/<?php echo $item["id"]; ?>">[EDITAR]</a>
                    <a href="<?php echo BASE_URL; ?>contato/excluir/<?php echo $item["id"]; ?>">[EXCLUIR]</a>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>

    </table>

    <!-- CRIANDO MODAL PARA USO COM JQUERY -->
    <div class="modal_bg">
        <div class="modal">
        
        </div>
    </div>