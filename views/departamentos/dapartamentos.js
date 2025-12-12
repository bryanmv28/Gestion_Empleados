function init() {
  $("#form_departamento").on("submit", (e) => {
    GuardarEditar(e);
  });
}

const ruta = "../../controllers/departamentos.controller.php?op=";

$().ready(() => {
  CargaLista();
});

var CargaLista = () => {
  var html = "";
  $.get(ruta + "todos", (ListaDepartamentos) => {
    if (!ListaDepartamentos) {
      $("#ListaDepartamentos").html('<tr><td colspan="5" class="text-center">No hay departamentos registrados</td></tr>');
      return;
    }
    
    ListaDepartamentos = JSON.parse(ListaDepartamentos);
    $.each(ListaDepartamentos, (index, depto) => {
      const estadoBadge = depto.estado == 1 
        ? '<span class="badge bg-success">Activo</span>' 
        : '<span class="badge bg-danger">Inactivo</span>';
      
      html += `<tr>
            <td>${index + 1}</td>
            <td>${depto.nombre_departamento}</td>
            <td>${depto.descripcion || '-'}</td>
            <td>${estadoBadge}</td>
            <td>
                <button class='btn btn-primary btn-sm' data-bs-toggle="modal" 
                        data-bs-target="#ModalDepartamento" 
                        onclick='editarDepartamento(${depto.id_departamento})'>
                    <i class='bx bx-edit'></i> Editar
                </button>
                <button class='btn btn-danger btn-sm' onclick='eliminar(${depto.id_departamento})'>
                    <i class='bx bx-trash'></i> Eliminar
                </button>
            </td>
           </tr>`;
    });
    $("#ListaDepartamentos").html(html);
  }).fail(() => {
    $("#ListaDepartamentos").html('<tr><td colspan="5" class="text-center text-danger">Error al cargar departamentos</td></tr>');
  });
};

var GuardarEditar = (e) => {
  e.preventDefault();
  var DatosFormularioDepartamento = new FormData($("#form_departamento")[0]);
  var accion = "";
  var idDepartamento = document.getElementById("idDepartamento").value;

  if (idDepartamento > 0) {
    accion = ruta + "actualizar";
    DatosFormularioDepartamento.append("idDepartamento", idDepartamento);
  } else {
    accion = ruta + "insertar";
  }

  $.ajax({
    url: accion,
    type: "post",
    data: DatosFormularioDepartamento,
    processData: false,
    contentType: false,
    cache: false,
    success: (respuesta) => {
      respuesta = JSON.parse(respuesta);
      if (respuesta == "ok") {
        alert("Se guardó con éxito");
        CargaLista();
        LimpiarCajas();
      } else {
        alert("Error al guardar: " + respuesta);
      }
    },
    error: () => {
      alert("Error en la comunicación con el servidor");
    }
  });
};

var editarDepartamento = (idDepartamento) => {
  $.post(ruta + "uno", { idDepartamento: idDepartamento }, (departamento) => {
    departamento = JSON.parse(departamento);
    document.getElementById("idDepartamento").value = departamento.id_departamento;
    document.getElementById("nombre_departamento").value = departamento.nombre_departamento;
    document.getElementById("descripcion").value = departamento.descripcion || ''; 
    if (departamento.estado == 1) {
  document.getElementById("estado").checked = true;
} else {
  document.getElementById("estado").checked = false;
}
updateEstadoLabel();
});
};
var eliminar = (idDepartamento) => {
if (confirm("¿Está seguro de eliminar este departamento?")) {
$.post(ruta + "eliminarsuave", { idDepartamento: idDepartamento }, (respuesta) => {
respuesta = JSON.parse(respuesta);
if (respuesta == "ok") {
alert("Se eliminó con éxito");
CargaLista();
} else {
alert("Error al eliminar");
}
});
}
};
var LimpiarCajas = () => {
document.getElementById("idDepartamento").value = "";
document.getElementById("nombre_departamento").value = "";
document.getElementById("descripcion").value = "";
document.getElementById("estado").checked = true;
updateEstadoLabel();
$("#ModalDepartamento").modal("hide");
};
var updateEstadoLabel = () => {
const estadoCheckbox = document.getElementById("estado");
const estadoLabel = document.getElementById("lblEstado");
if (estadoCheckbox.checked) {
estadoLabel.textContent = "Activo";
} else {
estadoLabel.textContent = "Inactivo";
}
}
init();