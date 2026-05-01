<?php

    class Servicio extends Conectar{

        public function get_servicio(){
            try{
                $conectar = parent::Conexion();

                $sql = "SELECT ser_id, ser_nom, ser_dur_prom FROM b_servicio WHERE ser_est=1";
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

        public function insert_servicio($nombre, $duracion_promedio){
            try{         
                $conectar = parent::Conexion();

                $sql = "INSERT INTO b_servicio (ser_nom, ser_dur_prom) VALUES (?, ?)";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $nombre);
                $stmt->bindValue(2, $duracion_promedio);
                $stmt->execute();

                return ["success" => true];

            } catch (Exception $e){
                return [
                    "success" => false,
                    "error" => $e->getMessage()
                ];
            }
        }

        public function update_servicio($id, $nombre, $duracion_promedio){
            try{
                $conectar = parent::Conexion();

                $sql = "UPDATE b_servicio SET ser_nom=?, ser_dur_prom=? WHERE ser_id=?";
                $stmt = $conectar->prepare($sql);
                $stmt->bindValue(1, $nombre);
                $stmt->bindValue(2, $duracion_promedio);
                $stmt->bindValue(3, $id);
                $stmt->execute();

                return ["success" => true];

            } catch (Exception $e){
                return [
                    "success" => false,
                    "error" => $e->getMessage()
                ];
            }
        }
    }

?>