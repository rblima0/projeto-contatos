<?php
class homeController extends controller {
    
    public function index() {

        $dados = array(
            'nome' => 'Rodrigo',
            'idade' => 25
        );
        
        $this->loadTemplate('home', $dados);
    }

}