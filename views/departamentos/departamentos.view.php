<?php require_once('../html/head2.php');
require_once('../../config/sesiones.php');  ?>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Control /</span> Departamentos</h4>

<div class="card">
    <button type="button" class="btn btn-outline-secondary"
    data-bs-toggle="modal" data-bs-target="#ModalDepartamento">Nuevo Departamento</button>
    
    <h5 class="card-header">Lista de Departamentos</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="ListaDepartamentos">
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Departamento -->
<div class="modal" tabindex="-1" id="ModalDepartamento">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Departamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="form_departamento" method="post">
                <input type="hidden" name="idDepartamento" id="idDepartamento">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="nombre_departamento">Nombre del Departamento</label>
                        <input type="text" name="nombre_departamento" id="nombre_departamento" 
                               class="form-control" placeholder="Ej: Recursos Humanos" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" 
                                  rows="3" placeholder="Descripción del departamento"></textarea>
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
<script src="./departamentos.js"></script>