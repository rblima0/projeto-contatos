<?php
class Contato extends model {

    public function getAll() {
        $array = array();

        $sql = "SELECT * FROM contatos ORDER BY id";
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

    public function adicionar($email, $nome, $telefone, $foto) {
        if($this->existeEmail($email) == false) {
            if (!empty($foto["name"])) {
                preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);
                $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
                $caminho_imagem = "assets/images/contatos/" . $nome_imagem;
                move_uploaded_file($foto["tmp_name"], $caminho_imagem);

                /* REDIMENSIONA A IMAGEM */
                list($width_orig, $height_orig) = getimagesize("assets/images/contatos/".$nome_imagem);
                $ratio = $width_orig/$height_orig;
                $width = 60;
                $height = 60;

                if($width/$height > $ratio) {
                    $width = $height*$ratio;
                } else {
                    $height = $width/$ratio;
                }

                $img = imagecreatetruecolor($width, $height);

                if($foto["type"] == 'image/jpeg') {
                    $orig = imagecreatefromjpeg("assets/images/contatos/".$nome_imagem);
                } else if($foto["type"] == 'image/png') {
                    $orig = imagecreatefrompng("assets/images/contatos/".$nome_imagem);
                }

                imagecopyresampled($img, $orig, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                imagejpeg($img, "assets/images/contatos/".$nome_imagem, 80);
         
                $error = array();
         
                // Verifica se o arquivo é uma imagem
                if(!preg_match("/^image\/(jpeg|png)$/", $foto["type"])) {
                    $error[1] = "Isso não é uma imagem.";
                } 
         
                // Se não houver nenhum erro
                if (count($error) == 0) {
                   
         
                    // INSERE DADOS NO BANCO
                    $sql = "INSERT INTO contatos (nome, telefone, email, foto) VALUES (:nome, :telefone, :email, :foto)";
                    $sql = $this->db->prepare($sql);
                    $sql->bindValue(':nome', $nome);
                    $sql->bindValue(':telefone', $telefone);
                    $sql->bindValue(':email', $email);
                    $sql->bindValue(":foto", $nome_imagem);
                    $sql->execute();
                }
            
                // CASO TENHA ERROS
                if (count($error) != 0) {
                    foreach ($error as $erro) {
                        echo $erro . "<br />";
                    }
                }
            }
            
            return true;
        } else {
            return false;
        }
    }

    public function editar($nome, $telefone, $email, $id) {
        if($this->existeEmail($email) == false) {
            $sql = "UPDATE contatos SET nome = :nome, telefone = :telefone, email = :email WHERE id = :id";
            /* $sql = "UPDATE contatos SET nome = ?, email = ? WHERE id = ?"; */
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":telefone", $telefone);
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
        $sql = "SELECT foto FROM contatos WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $item = $sql->fetch();
            if (is_file("assets/images/contatos/".$item['foto'])) {
                unlink("assets/images/contatos/".$item['foto']);
            }
        }

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