<?php

class Turno extends Conectar {

    public function get_all() {
        try {
            $conectar = parent::Conexion();
            $sql = "SELECT t.*, s.ser_nom, u.usu_nom
                    FROM b_turno t
                    INNER JOIN b_servicio s ON t.tur_ser_id = s.ser_id
                    INNER JOIN b_usuario u  ON t.tur_usu_id = u.usu_id
                    ORDER BY t.tur_id DESC";
            $stmt = $conectar->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            error_log("ERROR en get_all: " . $e->getMessage());
            return [];
        }
    }

    public function get_turno_activo($usu_id) {
        try {
            $conectar = parent::Conexion();
            $sql = "SELECT t.*, s.ser_nom, s.ser_dur_prom
                    FROM b_turno t
                    INNER JOIN b_servicio s ON t.tur_ser_id = s.ser_id
                    WHERE t.tur_usu_id = ?
                    AND t.tur_est IN ('pendiente', 'en_atencion')
                    LIMIT 1";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $usu_id);
            $stmt->execute();
            return [
                "success" => true,
                "object"  => $stmt->fetch(PDO::FETCH_ASSOC) ?: null
            ];
        } catch (Throwable $e) {
            error_log("ERROR en get_turno_activo: " . $e->getMessage());
            return ["success" => false, "object" => null, "error" => "Error al obtener turno activo"];
        }
    }

    public function get_turnos_by_usuario($usu_id) {
        try {
            $conectar = parent::Conexion();
            $sql = "SELECT t.*, s.ser_nom
                    FROM b_turno t
                    INNER JOIN b_servicio s ON t.tur_ser_id = s.ser_id
                    WHERE t.tur_usu_id = ?
                    ORDER BY t.tur_id DESC";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $usu_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            error_log("ERROR en get_turnos_by_usuario: " . $e->getMessage());
            return [];
        }
    }

    public function usuario_tiene_turno_activo($usu_id) {
        try {
            $conectar = parent::Conexion();
            $sql  = "SELECT tur_id FROM b_turno WHERE tur_usu_id = ? AND tur_est IN ('pendiente', 'en_atencion') LIMIT 1";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $usu_id);
            $stmt->execute();
            return $stmt->fetch() !== false;
        } catch (Throwable $e) {
            error_log("ERROR en usuario_tiene_turno_activo: " . $e->getMessage());
            return true;
        }
    }

    public function usuario_tiene_turno_en_servicio($usu_id, $ser_id) {
        try {
            $conectar = parent::Conexion();
            $sql  = "SELECT tur_id FROM b_turno WHERE tur_usu_id = ? AND tur_ser_id = ? AND tur_est IN ('pendiente', 'en_atencion') LIMIT 1";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $usu_id);
            $stmt->bindValue(2, $ser_id);
            $stmt->execute();
            return $stmt->fetch() !== false;
        } catch (Throwable $e) {
            error_log("ERROR en usuario_tiene_turno_en_servicio: " . $e->getMessage());
            return true;
        }
    }

    public function insert_turno($usu_id, $ser_id) {
        try {
            $conectar = parent::Conexion();

            $stmt = $conectar->prepare("SELECT ser_nom FROM b_servicio WHERE ser_id = ?");
            $stmt->bindValue(1, $ser_id);
            $stmt->execute();
            $ser_nom = $stmt->fetchColumn();

            $ser_nom = strtr($ser_nom, [
                'á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u',
                'Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U',
            ]);
            $prefijo = strtoupper(substr($ser_nom, 0, 3));

            $stmt = $conectar->prepare("SELECT COALESCE(MAX(tur_n_tur), 0) + 1 FROM b_turno WHERE tur_ser_id = ?");
            $stmt->bindValue(1, $ser_id);
            $stmt->execute();
            $siguiente = $stmt->fetchColumn();

            $n_turno = $prefijo . str_pad($siguiente, 3, '0', STR_PAD_LEFT);

            $stmt = $conectar->prepare("INSERT INTO b_turno (tur_usu_id, tur_ser_id, tur_n_tur, tur_pre, tur_est) VALUES (?, ?, ?, ?, 'pendiente')");
            $stmt->bindValue(1, $usu_id);
            $stmt->bindValue(2, $ser_id);
            $stmt->bindValue(3, $siguiente);
            $stmt->bindValue(4, $prefijo);
            $stmt->execute();

            $id = $conectar->lastInsertId();

            return ["success" => true, "id" => $id, "n_turno" => $siguiente, "cod_turno" => $n_turno];
        } catch (Throwable $e) {
            error_log("ERROR en insert_turno: " . $e->getMessage());
            return ["success" => false, "error" => "Error al insertar turno"];
        }
    }



    public function cancelar_turno($tur_id, $usu_id) {
        try {
            $conectar = parent::Conexion();
            $sql  = "UPDATE b_turno SET tur_est = 'cancelado' WHERE tur_id = ? AND tur_usu_id = ? AND tur_est = 'pendiente'";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $tur_id);
            $stmt->bindValue(2, $usu_id);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                return ["success" => false, "error" => "No se pudo cancelar el turno"];
            }

            return ["success" => true];
        } catch (Throwable $e) {
            error_log("ERROR en cancelar_turno: " . $e->getMessage());
            return ["success" => false, "error" => "Error al cancelar turno"];
        }
    }
}
?>