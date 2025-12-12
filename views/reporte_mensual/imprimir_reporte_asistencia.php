<?php
// Deshabilitar la visualización de errores para que no interfiera con el PDF
error_reporting(0);
ini_set('display_errors', 0);

// Definir la ruta base del proyecto
define('BASE_PATH', dirname(dirname(__DIR__)));

// Incluir archivos usando rutas absolutas
require_once(__DIR__ . '/fpdf/fpdf.php');
require_once(BASE_PATH . '/config/conexion.php');
require_once(BASE_PATH . '/models/asistencia.models.php');

try {
    $Asistencia = new Asistencia();

    // Obtener parámetros del mes y año (por GET o POST)
    $mes = isset($_GET['mes']) ? $_GET['mes'] : date('m');
    $anio = isset($_GET['anio']) ? $_GET['anio'] : date('Y');

    // Nombres de los meses
    $nombresMeses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

    // Crear instancia de FPDF
    $pdf = new FPDF('L', 'mm', 'A4'); // L = Landscape (horizontal)
    $pdf->AddPage();

    // Título
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(0, 10, 'REPORTE DE ASISTENCIA MENSUAL', 0, 1, 'C');
    $pdf->Ln(5);

    // Subtítulo con período
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 8, 'Periodo: ' . $nombresMeses[$mes] . ' de ' . $anio, 0, 1, 'C');
    $pdf->Ln(10);

    // Encabezados de tabla
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(76, 175, 80); // Color verde
    $pdf->SetTextColor(255, 255, 255); // Texto blanco
    
    $pdf->Cell(10, 10, '#', 1, 0, 'C', true);
    $pdf->Cell(60, 10, 'Empleado', 1, 0, 'C', true);
    $pdf->Cell(30, 10, utf8_decode('Cédula'), 1, 0, 'C', true);
    $pdf->Cell(60, 10, 'Departamento', 1, 0, 'C', true);
    $pdf->Cell(30, 10, utf8_decode('Días Asistidos'), 1, 0, 'C', true);
    $pdf->Cell(87, 10, utf8_decode('Días'), 1, 1, 'C', true);

    // Obtener datos del reporte
    $datos = $Asistencia->reporteMensual($mes, $anio);

    if (mysqli_num_rows($datos) == 0) {
        $pdf->SetFont('Arial', 'I', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 10, 'No hay registros para mostrar en este periodo', 1, 1, 'C');
    } else {
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 0);
        $fill = false;
        $contador = 1;

        while ($row = mysqli_fetch_assoc($datos)) {
            $pdf->SetFillColor(242, 242, 242);
            
            // Número
            $pdf->Cell(10, 8, $contador, 1, 0, 'C', $fill);
            
            // Nombre completo
            $pdf->Cell(60, 8, utf8_decode($row["nombre_completo"]), 1, 0, 'L', $fill);
            
            // Cédula
            $pdf->Cell(30, 8, $row["cedula"], 1, 0, 'C', $fill);
            
            // Departamento
            $pdf->Cell(60, 8, utf8_decode($row["nombre_departamento"]), 1, 0, 'L', $fill);
            
            // Días asistidos
            $diasAsistidos = $row["dias_asistidos"] ? $row["dias_asistidos"] : 0;
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(30, 8, $diasAsistidos, 1, 0, 'C', $fill);
            $pdf->SetFont('Arial', '', 10);
            
            // Lista de días
            $listaDias = $row["dias"] ? $row["dias"] : 'Sin asistencias';
            $pdf->Cell(87, 8, utf8_decode($listaDias), 1, 1, 'L', $fill);
            
            $fill = !$fill;
            $contador++;
        }
    }

    // Pie de página con estadísticas
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, 'Total de empleados: ' . ($contador - 1), 0, 1, 'L');

    // Información de generación
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell(0, 5, utf8_decode('Generado el: ') . date('d/m/Y H:i:s'), 0, 0, 'R');

    // Limpiar cualquier salida previa
    if (ob_get_length()) {
        ob_end_clean();
    }

    // Salida del PDF
    $nombreArchivo = 'reporte_asistencia_' . $nombresMeses[$mes] . '_' . $anio . '.pdf';
    $pdf->Output('I', $nombreArchivo);

} catch (Exception $e) {
    // Si hay error, mostrar en HTML
    if (ob_get_length()) {
        ob_end_clean();
    }
    
    echo "<!DOCTYPE html><html><head><title>Error</title>";
    echo "<style>body{font-family:Arial;padding:20px;background:#f5f5f5;} ";
    echo ".error{background:#ffebee;border-left:4px solid #f44336;padding:15px;margin:20px 0;border-radius:4px;} ";
    echo ".info{background:#e3f2fd;border-left:4px solid #2196f3;padding:15px;margin:20px 0;border-radius:4px;} ";
    echo ".btn{display:inline-block;padding:10px 20px;background:#2196f3;color:white;text-decoration:none;border-radius:4px;margin-top:10px;}</style>";
    echo "</head><body>";
    echo "<h2>Error al generar el PDF</h2>";
    echo "<div class='error'><strong>Mensaje:</strong> " . $e->getMessage() . "</div>";
    echo "<div class='info'><strong>Ruta Base:</strong> " . BASE_PATH . "</div>";
    echo "<p><a href='reporte_mensual.view.php' class='btn'>← Volver</a></p>";
    echo "</body></html>";
}
?>