<?php
    class Conectar{
        protected $dbh;

        protected function Conexion(){
            try{
                $conectar = $this->dbh = new PDO(
                    "mysql:host=localhost;dbname=banco_sistema_atc;charset=utf8mb4", 
                    "root", 
                    "",
                    // Permite que PDO lance errores
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]
                    );
                    return $conectar;
            }catch(Exception $e){
                print "Error en DB! ". $e->getMessage();
                die();
            }
        }
    }



?>