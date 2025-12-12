<?php require_once('../html/head2.php');
require_once('../../config/sesiones.php');  ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Control /</span> Empleados</h4>

<div class="card">
    <button type="button" class="btn btn-outline-secondary" onclick="cargarDepartamentos()"
    data-bs-toggle="modal" data-bs-target="#ModalEmpleado">Nuevo Empleado</button>
    
    <h5 class="card-header">Lista de Empleados</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre Completo</th>
                    <th>Cédula</th>
                    <th>Departamento</th>
                    <th>Cargo</th>
                    <th>Fecha Ingreso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="ListaEmpleados">
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Empleado -->
<div class="modal" tabindex="-1" id="ModalEmpleado">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="form_empleado" method="post">
                <input type="hidden" name="idEmpleado" id="idEmpleado">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="apellido">Apellido</label>
                                <input type="text" name="apellido" id="apellido" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="cedula">Cédula</label>
                                <input type="text" name="cedula" id="cedula" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="id_departamento">Departamento</label>
                                <select name="id_departamento" id="id_departamento" class="form-control" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="cargo">Cargo</label>
                                <input type="text" name="cargo" id="cargo" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="fecha_ingreso">Fecha de Ingreso</label>
                                <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-check form-switch">
                        <input name="estado" id="estado" onchange="updateEstadoLabel()" 
                               class="form-check-input" type="checkbox" checked>
                        <label class="form-check-label" for="estado" id="lblEstado">Activo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once('../html/scripts2.php') ?>
<script src="./empleados.js"></script>