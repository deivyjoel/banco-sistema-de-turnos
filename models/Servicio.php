<?php

class Servicio extends Conectar {

    public function get_servicios() {
        try {
            $conectar = parent::Conexion();
            $sql = "SELECT ser_id, ser_nom, ser_dur_prom, ser_est FROM b_servicio";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            error_log("ERROR en get_servicios: " . $e->getMessage());
            return [];
        }
    }

    public function get_servicios_activos() {
        try {
            $conectar = parent::Conexion();
            $sql = "SELECT ser_id, ser_nom, ser_dur_prom FROM b_servicio WHERE ser_est = 1";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            error_log("ERROR en get_servicios_activos: " . $e->getMessage());
            return [];
        }
    }

    public function get_servicio_x_id($ser_id) {
        try {
            $conectar = parent::Conexion();
            $sql = "SELECT ser_id, ser_nom, ser_dur_prom, ser_est FROM b_servicio WHERE ser_id = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $ser_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            error_log("ERROR en get_servicio_x_id: " . $e->getMessage());
            return [];
        }
    }

    public function get_servicio_x_nombre($ser_nom) {
        try {
            $conectar = parent::Conexion();
            $sql = "SELECT ser_id FROM b_servicio WHERE ser_nom = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $ser_nom);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            error_log("ERROR en get_servicio_x_nombre: " . $e->getMessage());
            return [];
        }
    }

    public function insert_servicio($ser_nom, $ser_dur_prom) {
        try {
            $conectar = parent::Conexion();
            $sql = "INSERT INTO b_servicio (ser_nom, ser_dur_prom, ser_est) VALUES (?, ?, 1)";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $ser_nom);
            $stmt->bindValue(2, $ser_dur_prom);
            $stmt->execute();
            return ["success" => true];
        } catch (Throwable $e) {
            error_log("ERROR en insert_servicio: " . $e->getMessage());
            return ["success" => false, "error" => "Error al insertar servicio"];
        }
    }

    public function update_servicio($ser_id, $ser_nom, $ser_dur_prom, $ser_est) {
        try {
            $conectar = parent::Conexion();
            $sql = "UPDATE b_servicio SET ser_nom = ?, ser_dur_prom = ?, ser_est = ? WHERE ser_id = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $ser_nom);
            $stmt->bindValue(2, $ser_dur_prom);
            $stmt->bindValue(3, $ser_est);
            $stmt->bindValue(4, $ser_id);
            $stmt->execute();
            return ["success" => true];
        } catch (Throwable $e) {
            error_log("ERROR en update_servicio: " . $e->getMessage());
            return ["success" => false, "error" => "Error al actualizar servicio"];
        }
    }

    public function delete_servicio($ser_id) {
        try {
            $conectar = parent::Conexion();

            $sql = "UPDATE b_servicio SET ser_est = 0 WHERE ser_id = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $ser_id);
            $stmt->execute();
            return ["success" => true];
        } catch (Throwable $e) {
            error_log("ERROR en delete_servicio: " . $e->getMessage());
            return ["success" => false, "error" => "Error al eliminar servicio"];
        }
    }
}
?>