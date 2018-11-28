<?php
class homeController extends controller {
    
    public function index() {
        $anuncios = new Anuncios();
        $usuarios = new Usuarios();

        $dados = array(
            'nome' => $usuarios->getNome(),
            'idade' => $usuarios->getIdade(),
            'quantidade_anuncios' => $anuncios->getQuantidade()
        );
        
        $this->loadTemplate('home', $dados);
    }

}