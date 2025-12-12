<?php
error_reporting(0);
require_once('../config/sesiones.php');
require_once("../models/asistencia.models.php");

$Asistencia = new Asistencia;

switch ($_GET["op"]) {
    case 'todos':
        $datos = array();
        $datos = $Asistencia->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
        
    case 'uno':
        $idAsistencia = $_POST["idAsistencia"];
        $datos = array();
        $datos = $Asistencia->uno($idAsistencia);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
        
    case 'insertar':
        $id_empleado = $_POST["id_empleado"];
        $fecha = $_POST["fecha"];
        $hora_entrada = $_POST["hora_entrada"];
        $hora_salida = isset($_POST["hora_salida"]) ? $_POST["hora_salida"] : null;
        $observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : null;
        
        $datos = array();
        $datos = $Asistencia->Insertar($id_empleado, $fecha, $hora_entrada, $hora_salida, $observaciones);
        echo json_encode($datos);
        break;
        
    case 'actualizar':
        $idAsistencia = $_POST["idAsistencia"];
        $id_empleado = $_POST["id_empleado"];
        $fecha = $_POST["fecha"];
        $hora_entrada = $_POST["hora_entrada"];
        $hora_salida = isset($_POST["hora_salida"]) ? $_POST["hora_salida"] : null;
        $observaciones = isset($_POST["observaciones"]) ? $_POST["observaciones"] : null;
        
        $datos = array();
        $datos = $Asistencia->Actualizar($idAsistencia, $id_empleado, $fecha, $hora_entrada, $hora_salida, $observaciones);
        echo json_encode($datos);
        break;
        
    case 'eliminar':
        $idAsistencia = $_POST["idAsistencia"];
        $datos = array();
        $datos = $Asistencia->Eliminar($idAsistencia);
        echo json_encode($datos);
        break;
        
    case 'reporteMensual':
        $mes = $_POST["mes"];
        $anio = $_POST["anio"];
        
        $datos = array();
        $datos = $Asistencia->reporteMensual($mes, $anio);
        while ($row = mysqli_fetch_assoc($datos)) {
            $reporte[] = $row;
        }
        echo json_encode($reporte);
        break;
        
    default:
        break;
}
?>