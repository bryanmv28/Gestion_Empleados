<?php
require_once('../config/conexion.php');

class Empleados
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT e.*, d.nombre_departamento 
                   FROM empleados e 
                   INNER JOIN departamentos d ON e.id_departamento = d.id_departamento 
                   WHERE e.estado = 1";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
    
    public function uno($idEmpleado)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM empleados WHERE id_empleado = $idEmpleado AND estado = 1";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
    
    public function Insertar($nombre, $apellido, $cedula, $id_departamento, $cargo, $fecha_ingreso)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "INSERT INTO empleados(nombre, apellido, cedula, id_departamento, cargo, fecha_ingreso, estado) 
                   VALUES ('$nombre', '$apellido', '$cedula', $id_departamento, '$cargo', '$fecha_ingreso', 1)";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return 'Error al insertar en la base de datos';
        }
    }
    
    public function Actualizar($idEmpleado, $nombre, $apellido, $cedula, $id_departamento, $cargo, $fecha_ingreso, $estado)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "UPDATE empleados SET 
                   nombre='$nombre', 
                   apellido='$apellido', 
                   cedula='$cedula', 
                   id_departamento=$id_departamento, 
                   cargo='$cargo', 
                   fecha_ingreso='$fecha_ingreso', 
                   estado=$estado 
                   WHERE id_empleado = $idEmpleado";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return 'Error al actualizar el registro';
        }
    }
    
    public function Eliminar($idEmpleado)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "DELETE FROM empleados WHERE id_empleado = $idEmpleado";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return false;
        }
    }
    
    public function Eliminarsuave($idEmpleado)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "UPDATE empleados SET estado=0 WHERE id_empleado = $idEmpleado";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return false;
        }
    }
}
?>