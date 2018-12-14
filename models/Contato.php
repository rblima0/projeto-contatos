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
         
                // VERIFICAÇÃO DE IMAGEM
                if(!preg_match("/^image\/(jpeg|png)$/", $foto["type"])) {
                    $error[1] = "Isso não é uma imagem.";
                }
                
                // VERIFICAÇÃO DE ERROS
                if (count($error) == 0) {
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
            } else {
                $sql = "INSERT INTO contatos (nome, telefone, email) VALUES (:nome, :telefone, :email)";
                $sql = $this->db->prepare($sql);
                $sql->bindValue(':nome', $nome);
                $sql->bindValue(':telefone', $telefone);
                $sql->bindValue(':email', $email);
                $sql->execute();
            }
            return true;
        } else {
            return false;
        }
    }

    public function editar($nome, $telefone, $email, $foto, $id) {

        /* TESTA SE EMAIL JA EXISTE */
        if($this->existeEmail($email) == false) {
            $sql = "UPDATE contatos SET email = :email WHERE id = :id";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":id", $id);
            $sql->execute();
        }

        /* ALTERA OUTROS CAMPOS */
        $sql = "UPDATE contatos SET nome = :nome, telefone = :telefone WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":telefone", $telefone);
        $sql->bindValue(":id", $id);
        $sql->execute();

        /* VERIFICA SE ESTA SUBINDO NOVA IMAGEM */
        if (!empty($foto["name"])) {
            $this->excluirFoto($id);
            preg_match("/\.(png|jpg|jpeg){1}$/i", $foto["name"], $ext);
            $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
            $caminho_imagem = "assets/images/contatos/" . $nome_imagem;
            move_uploaded_file($foto["tmp_name"], $caminho_imagem);

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
        
            if(!preg_match("/^image\/(jpg|jpeg|png)$/", $foto["type"])) {
                $error[1] = "Isso não é uma imagem.";
            } 
        
            if (count($error) == 0) {
                $sql = "UPDATE contatos SET foto = :foto WHERE id = :id";
                $sql = $this->db->prepare($sql);
                $sql->bindValue(":foto", $nome_imagem);
                $sql->bindValue(":id", $id);
                $sql->execute();
            }
        
            if (count($error) != 0) {
                foreach ($error as $erro) {
                    echo $erro . "<br />";
                }
            }
        }
        return true;
    }

    public function excluir($id) {
        $this->excluirFoto($id);

        $sql = "DELETE FROM contatos WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    /* METODO PARA REMOVER IMAGEM DA PASTA */
    public function excluirFoto($id) {
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
    }

    /* METODO PARA VERIFICAR SE EXISTE EMAIL */
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