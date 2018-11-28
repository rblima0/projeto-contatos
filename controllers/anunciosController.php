<?php
class anunciosController extends controller {
    
    public function index() {

        $dados = array(
            'qt_anuncios' => 50
        );
        
        $this->loadTemplate('anuncios', $dados);
    }

}