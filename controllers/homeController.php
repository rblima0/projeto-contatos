<?php
namespace Controllers;

use \Core\Controller;
use \Models\Contato;
use \Models\Usuario;

class HomeController extends Controller 
{
    
    public function index()
    {
        $dados = array();

        $contato = new Contato();
        $usuario = new Usuario();

        $page = 1;
        $perPage = 7;

        if(isset($_GET['p']) && !empty($_GET['p'])) {
            $page = addslashes($_GET['p']);
        }

        $total_contatos = $contato->getTotal();
        $total_paginas = ceil($total_contatos / $perPage);

        $dados['total_paginas'] = $total_paginas;
        $dados['lista'] = $contato->getAll($page, $perPage);
        
        $this->loadTemplate('home', $dados);
    }

}