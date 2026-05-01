<?php

class Turno extends Conectar{

    public function get_turno(){
        try{
            $conectar = parent::Conexion();

            $sql = "SELECT * FROM b_turno WHERE tur_est=1";
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

    public function insert_turno($usu_id, $ser_id, $n_turno){
        try{
            $conectar = parent::Conexion();

            $sql = "INSERT INTO b_turno (tur_usu_id, tur_ser_id, tur_n_tur, tur_est) VALUES (?, ?, ?, 1)";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $usu_id);
            $stmt->bindValue(2, $ser_id);
            $stmt->bindValue(3, $n_turno);
            $stmt->execute();

            return ["success" => true];

        } catch(Exception $e){
            return [
                "success" => false,
                "error" => $e->getMessage()
            ];
        }
    }

    public function update_turno($id, $usu_id, $ser_id, $n_turno){
        try{
            $conectar = parent::Conexion();

            $sql = "UPDATE b_turno SET tur_usu_id=?, tur_ser_id=?, tur_n_tur=? WHERE tur_id=?";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $usu_id);
            $stmt->bindValue(2, $ser_id);
            $stmt->bindValue(3, $n_turno);
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