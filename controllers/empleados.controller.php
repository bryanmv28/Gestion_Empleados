<?php
error_reporting(0);
require_once('../config/sesiones.php');
require_once("../models/empleados.models.php");

$Empleados = new Empleados;

switch ($_GET["op"]) {
    case 'todos':
        $datos = array();
        $datos = $Empleados->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
        
    case 'uno':
        $idEmpleado = $_POST["idEmpleado"];
        $datos = array();
        $datos = $Empleados->uno($idEmpleado);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
        
    case 'insertar':
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $cedula = $_POST["cedula"];
        $id_departamento = $_POST["id_departamento"];
        $cargo = $_POST["cargo"];
        $fecha_ingreso = $_POST["fecha_ingreso"];
        
        $datos = array();
        $datos = $Empleados->Insertar($nombre, $apellido, $cedula, $id_departamento, $cargo, $fecha_ingreso);
        echo json_encode($datos);
        break;
        
    case 'actualizar':
        $idEmpleado = $_POST["idEmpleado"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $cedula = $_POST["cedula"];
        $id_departamento = $_POST["id_departamento"];
        $cargo = $_POST["cargo"];
        $fecha_ingreso = $_POST["fecha_ingreso"];
        $estado = $_POST["estado"];
        
        $datos = array();
        $datos = $Empleados->Actualizar($idEmpleado, $nombre, $apellido, $cedula, $id_departamento, $cargo, $fecha_ingreso, $estado=="on"?1:0);
        echo json_encode($datos);
        break;
        
    case 'eliminar':
        $idEmpleado = $_POST["idEmpleado"];
        $datos = array();
        $datos = $Empleados->Eliminar($idEmpleado);
        echo json_encode($datos);
        break;
        
    case 'eliminarsuave':
        $idEmpleado = $_POST["idEmpleado"];
        $datos = array();
        $datos = $Empleados->Eliminarsuave($idEmpleado);
        echo json_encode($datos);
        break;
        
    default:
        break;
}
?>