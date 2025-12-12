<?php
require_once('../config/conexion.php');

class Asistencia
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT a.*, 
                   CONCAT(e.nombre, ' ', e.apellido) as nombre_completo,
                   e.cedula,
                   d.nombre_departamento
                   FROM asistencia a
                   INNER JOIN empleados e ON a.id_empleado = e.id_empleado
                   INNER JOIN departamentos d ON e.id_departamento = d.id_departamento
                   ORDER BY a.fecha DESC, a.hora_entrada DESC";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
    
    public function uno($idAsistencia)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM asistencia WHERE id_asistencia = $idAsistencia";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
    
    public function Insertar($id_empleado, $fecha, $hora_entrada, $hora_salida, $observaciones)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        
        $hora_salida_sql = $hora_salida ? "'$hora_salida'" : "NULL";
        $observaciones_sql = $observaciones ? "'$observaciones'" : "NULL";
        
        $cadena = "INSERT INTO asistencia(id_empleado, fecha, hora_entrada, hora_salida, observaciones) 
                   VALUES ($id_empleado, '$fecha', '$hora_entrada', $hora_salida_sql, $observaciones_sql)";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return 'Error al insertar en la base de datos';
        }
    }
    
    public function Actualizar($idAsistencia, $id_empleado, $fecha, $hora_entrada, $hora_salida, $observaciones)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        
        $hora_salida_sql = $hora_salida ? "'$hora_salida'" : "NULL";
        $observaciones_sql = $observaciones ? "'$observaciones'" : "NULL";
        
        $cadena = "UPDATE asistencia SET 
                   id_empleado=$id_empleado, 
                   fecha='$fecha', 
                   hora_entrada='$hora_entrada', 
                   hora_salida=$hora_salida_sql, 
                   observaciones=$observaciones_sql 
                   WHERE id_asistencia = $idAsistencia";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return 'Error al actualizar el registro';
        }
    }
    
    public function Eliminar($idAsistencia)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "DELETE FROM asistencia WHERE id_asistencia = $idAsistencia";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return false;
        }
    }
    
    // Reporte mensual de asistencia
    public function reporteMensual($mes, $anio)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT 
                   e.id_empleado,
                   CONCAT(e.nombre, ' ', e.apellido) as nombre_completo,
                   e.cedula,
                   d.nombre_departamento,
                   COUNT(a.id_asistencia) as dias_asistidos,
                   GROUP_CONCAT(DATE_FORMAT(a.fecha, '%d') ORDER BY a.fecha SEPARATOR ', ') as dias
                   FROM empleados e
                   INNER JOIN departamentos d ON e.id_departamento = d.id_departamento
                   LEFT JOIN asistencia a ON e.id_empleado = a.id_empleado 
                   AND MONTH(a.fecha) = $mes 
                   AND YEAR(a.fecha) = $anio
                   WHERE e.estado = 1
                   GROUP BY e.id_empleado, e.nombre, e.apellido, e.cedula, d.nombre_departamento
                   ORDER BY d.nombre_departamento, e.apellido, e.nombre";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
}
?>