<?php
class contatoController extends controller {
    
    public function index() { }

    public function adicionar() {
        $dados = array();
        
        $this->loadTemplate('adicionar', $dados);
    }

    public function adicionar_submit() {
        if(!empty($_POST["email"])) {
            $nome = $_POST["nome"];
            $telefone = $_POST["telefone"];
            $email = $_POST["email"];
            $foto = $_FILES["foto"];
            
            $contato = new Contato();
            $contato->adicionar($email, $nome, $telefone, $foto);
        } else {
            header("Location: ".BASE_URL."contato/adicionar");
        }
        header("Location: ".BASE_URL);
    }

    public function editar($id) {
        $dados = array();

        if(!empty($id)) {
            $contato = new Contato();
            $dados['info'] = $contato->getInfo($id);
        } else {
            header("Location: ".BASE_URL);
            exit;
        }
        
        $this->loadTemplate('editar', $dados);
    }

    public function editar_submit() {
        if(!empty($_POST["id"]) && !empty($_POST["email"])) {
            $nome = $_POST["nome"];
            $telefone = $_POST["telefone"];
            $email = $_POST["email"];
            $id = $_POST["id"];

            if(isset($_FILES['foto'])) {
                $foto = $_FILES['foto'];
            } else {
                $foto = array();
            }

            $contato = new Contato();
            $contato->editar($nome, $telefone, $email, $foto, $id);
        } 
        header("Location: ".BASE_URL);
    }

    public function excluir($id) {
        if(!empty($id)) {
            $contato = new Contato();
            $contato->excluir($id);
        } 
        header("Location: ".BASE_URL);
    }

}