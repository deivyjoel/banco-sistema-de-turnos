<?php

class Usuario extends Conectar{

    public function register($nombre, $email, $password){
        $conectar = parent::Conexion();
        $sql = "
        INSERT INTO b_usuario(usu_nom, usu_email, usu_rol)
        VALUES (?, ?, ?, 'usuario')
        ";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $nombre);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, password_hash($password, PASSWORD_BCRYPT));
        $stmt->execute();

        return ["success" => true];
    }

    public function login($email, $password){
        $conectar = parent::Conexion();

        $sql = "SELECT * FROM usuarios WHERE usu_email = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["usu_password"])) {
            return [
                "success" => true,
                "user" => $user
            ];
        }

        return ["success" => false];
    }
    public function get_usuario(){
        try{
            $conectar = parent::Conexion();

            $sql = "SELECT * FROM b_usuario WHERE usu_est=1";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();

            return [
                "success" => true,
                "object" => $stmt->fetchAll(PDO::FETCH_ASSOC)
            ];

        } catch(Exception $e){
            return [
                "success" => false,
                "error" => $e->getMessage()
            ];
        }
    }

    public function insert_usuario($nombre, $email, $rol){
        try{
            $conectar = parent::Conexion();

            $sql = "INSERT INTO b_usuario (usu_nom, usu_email, usu_rol, usu_est) VALUES (?, ?, ?, 1)";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $nombre);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $rol);
            $stmt->execute();

            return ["success" => true];

        } catch(Exception $e){
            return [
                "success" => false,
                "error" => $e->getMessage()
            ];
        }
    }

    public function update_usuario($id, $nombre, $email, $rol){
        try{
            $conectar = parent::Conexion();

            $sql = "UPDATE b_usuario SET usu_nom=?, usu_email=?, usu_rol=? WHERE usu_id=?";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $nombre);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $rol);
            $stmt->bindValue(4, $id);
            $stmt->execute();

            return ["success" => true];

        } catch(Exception $e){
            return [
                "success" => false,
                "error" => $e->getMessage()
            ];
        }
    }
}

?>