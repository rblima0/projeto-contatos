<?php
namespace Models;
use \Core\Model;

/* CLASSE DE TESTE */
class Usuario extends Model
{

    /* PROPRIEDADES */
    private $id;
    private $nome;
    private $email;
    private $senha;

    /* CONSTRUTOR */
    public function __construct($i = null)
    {
        if(!empty($i)) {
            $sql = "SELECT * FROM usuarios WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($i));

            if($sql->rowCount() > 0) {
                $data = $sql->fetch();
                $this->id = $data["id"];
                $this->nome = $data["nome"];
                $this->email = $data["email"];
                $this->senha = $data["senha"];
            }
        }
    }

    /* GETTERS AND SETTERS */
    public function getId()
    {
        return $this->id;
    }

    public function setNome($n)
    {
        $this->nome = $n;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setEmail($e)
    {
        $this->email = $e;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setSenha($s)
    {
        $this->senha = md5($s);
    }

    /* METODOS */
    public function salvar()
    {
        if(!empty($this->id)) {
            $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($this->nome, $this->email, $this->senha, $this->id));
        } else {
            $sql = "INSERT INTO usuarios SET nome = ?, email = ?, senha = ?";
            $sql = $this->db->prepare($sql);
            $sql->execute(array($this->nome, $this->email, $this->senha));
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $sql = $this->db->prepare($sql);
        $sql->execute(array($this->id));
    }
}