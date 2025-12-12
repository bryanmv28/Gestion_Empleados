<?php require_once('../html/head2.php');
require_once('../../config/sesiones.php');  ?>

<style>
    @media print {
        button, .btn {
            display: none !important;
        }
        
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-size: 0.9rem;
        }

        .table th,
        .table td {
            padding: 0.5rem 0.75rem;
            border-top: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            background-color: #f8f9fa;
            font-weight: 600;
            text-align: left;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }
    }
</style>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reportes /</span> Asistencia Mensual</h4>

<div class="card">
    <div class="card-header">
        <h5 class="mb-3">Reporte de Asistencia Mensual</h5>
        <div class="row">
            <div class="col-md-2">
                <label for="mes">Mes</label>
                <select id="mes" class="form-control">
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="anio">Año</label>
                <input type="number" id="anio" class="form-control" value="2024" min="2020" max="2030">
            </div>
            <div class="col-md-2">
                <label>&nbsp;</label>
                <button class="btn btn-primary d-block w-100" onclick="generarReporte()">
                    <i class="bx bx-search"></i> Generar
                </button>
            </div>
            <div class="col-md-2">
                <label>&nbsp;</label>
                <button class="btn btn-success d-block w-100" onclick="imprimirReporte()">
                    <i class="bx bx-printer"></i> Imprimir
                </button>
            </div>
            <div class="col-md-2">
                <label>&nbsp;</label>
                <button class="btn btn-danger d-block w-100" onclick="generarPDF()">
                    <i class="bx bxs-file-pdf"></i> PDF
                </button>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-striped" id="tablaReporte">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Empleado</th>
                        <th>Cédula</th>
                        <th>Departamento</th>
                        <th>Días Asistidos</th>
                        <th>Días</th>
                    </tr>
                </thead>
                <tbody id="ListaReporte">
                    <tr>
                        <td colspan="6" class="text-center">Seleccione un mes y año para generar el reporte</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once('../html/scripts2.php') ?>
<script src="./reporte_mensual.js"></script>