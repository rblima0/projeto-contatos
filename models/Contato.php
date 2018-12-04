<?php
class Contato extends model {

    public function getAll() {
        $array = array();

        $sql = "SELECT * FROM contatos";
        $sql = $this->db->query($sql);

        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function getInfo($id) {
        $array = array();

        $sql = "SELECT * FROM contatos WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0 ){
            $array = $sql->fetch();
        }
        return $array;     
    }

    public function adicionar($email, $nome = '') {
        if($this->existeEmail($email) == false) {
            $sql = "INSERT INTO contatos (nome, email) VALUES (:nome, :email)";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':email', $email);
            $sql->execute();
            
            return true;
        } else {
            return false;
        }
    }

    public function editar($nome, $email, $id) {
        if($this->existeEmail($email) == false) {
            $sql = "UPDATE contatos SET nome = :nome, email = :email WHERE id = :id";
            /* $sql = "UPDATE contatos SET nome = ?, email = ? WHERE id = ?"; */
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":id", $id);
            $sql->execute();
            /* $sql->execute(array($nome, $email, $id)); */
            
            return true;
        } else {
            $sql = "UPDATE contatos SET nome =:nome WHERE id=:id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":id", $id);
            $sql->execute();
            
            return true;
        }
    }

    public function excluir($id) {
        $sql = "DELETE FROM contatos WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    /* METODO AUXILIAR PARA VERIFICAR EMAIL */
    private function existeEmail($email) {
        $sql = "SELECT * FROM contatos WHERE email = :email";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

}