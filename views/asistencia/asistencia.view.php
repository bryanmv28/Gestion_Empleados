<?php require_once('../html/head2.php');
require_once('../../config/sesiones.php');  ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Control /</span> Asistencia</h4>

<div class="card">
    <button type="button" class="btn btn-outline-secondary" onclick="cargarEmpleados()"
    data-bs-toggle="modal" data-bs-target="#ModalAsistencia">Registrar Asistencia</button>
    
    <h5 class="card-header">Registro de Asistencia</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Empleado</th>
                    <th>Cédula</th>
                    <th>Departamento</th>
                    <th>Hora Entrada</th>
                    <th>Hora Salida</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="ListaAsistencia">
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Asistencia -->
<div class="modal" tabindex="-1" id="ModalAsistencia">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Asistencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="form_asistencia" method="post">
                <input type="hidden" name="idAsistencia" id="idAsistencia">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="id_empleado">Empleado</label>
                        <select name="id_empleado" id="id_empleado" class="form-control" required>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="fecha">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="hora_entrada">Hora Entrada</label>
                                <input type="time" name="hora_entrada" id="hora_entrada" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="hora_salida">Hora Salida</label>
                                <input type="time" name="hora_salida" id="hora_salida" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="observaciones">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control" rows="3"></textarea>
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
<script src="./asistencia.js"></script>