<?php
error_reporting(0);
require_once('../config/sesiones.php');
require_once("../models/departamentos.models.php");

$Departamentos = new Departamentos;

switch ($_GET["op"]) {
    case 'todos':
        $datos = array();
        $datos = $Departamentos->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
        
    case 'uno':
        $idDepartamento = $_POST["idDepartamento"];
        $datos = array();
        $datos = $Departamentos->uno($idDepartamento);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
        
    case 'insertar':
        $nombre_departamento = $_POST["nombre_departamento"];
        $descripcion = $_POST["descripcion"];
        
        $datos = array();
        $datos = $Departamentos->Insertar($nombre_departamento, $descripcion);
        echo json_encode($datos);
        break;
        
    case 'actualizar':
        $idDepartamento = $_POST["idDepartamento"];
        $nombre_departamento = $_POST["nombre_departamento"];
        $descripcion = $_POST["descripcion"];
        $estado = $_POST["estado"];
        
        $datos = array();
        $datos = $Departamentos->Actualizar($idDepartamento, $nombre_departamento, $descripcion, $estado=="on"?1:0);
        echo json_encode($datos);
        break;
        
    case 'eliminar':
        $idDepartamento = $_POST["idDepartamento"];
        $datos = array();
        $datos = $Departamentos->Eliminar($idDepartamento);
        echo json_encode($datos);
        break;
        
    case 'eliminarsuave':
        $idDepartamento = $_POST["idDepartamento"];
        $datos = array();
        $datos = $Departamentos->Eliminarsuave($idDepartamento);
        echo json_encode($datos);
        break;
        
    default:
        break;
}
?>