<?php
class homeController extends controller {
    
    public function index() {
        $dados = array();

        $contato = new Contato();
        $usuario = new Usuario();

        $dados['lista'] = $contato->getAll();
        
        $this->loadTemplate('home', $dados);
    }

}