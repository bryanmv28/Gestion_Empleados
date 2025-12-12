<?php
require_once('../config/conexion.php');

class Departamentos
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM departamentos WHERE estado = 1";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
    
    public function uno($idDepartamento)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM departamentos WHERE id_departamento = $idDepartamento AND estado = 1";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
    
    public function Insertar($nombre_departamento, $descripcion)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "INSERT INTO departamentos(nombre_departamento, descripcion, estado) 
                   VALUES ('$nombre_departamento', '$descripcion', 1)";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return 'Error al insertar en la base de datos';
        }
    }
    
    public function Actualizar($idDepartamento, $nombre_departamento, $descripcion, $estado)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "UPDATE departamentos SET 
                   nombre_departamento='$nombre_departamento', 
                   descripcion='$descripcion', 
                   estado=$estado 
                   WHERE id_departamento = $idDepartamento";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return 'Error al actualizar el registro';
        }
    }
    
    public function Eliminar($idDepartamento)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "DELETE FROM departamentos WHERE id_departamento = $idDepartamento";
        
        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $con->close();
            return false;
        }
    }
    
    public function Eliminarsuave($idDepartamento)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "UPDATE departamentos SET estado=0 WHERE id_departamento = $idDepartamento";
        
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