function init() {
  $("#form_empleado").on("submit", (e) => {
    GuardarEditar(e);
  });
}

const ruta = "../../controllers/empleados.controller.php?op=";
const rutaDepartamentos = "../../controllers/departamentos.controller.php?op=";

$().ready(() => {
  CargaLista();
  // Establecer fecha actual por defecto
  const fechaActual = new Date().toISOString().split('T')[0];
  document.getElementById("fecha_ingreso").value = fechaActual;
});

var CargaLista = () => {
  var html = "";
  $.get(ruta + "todos", (ListaEmpleados) => {
    if (!ListaEmpleados) {
      $("#ListaEmpleados").html('<tr><td colspan="7" class="text-center">No hay empleados registrados</td></tr>');
      return;
    }
    
    ListaEmpleados = JSON.parse(ListaEmpleados);
    $.each(ListaEmpleados, (index, empleado) => {
      html += `<tr>
            <td>${index + 1}</td>
            <td>${empleado.nombre} ${empleado.apellido}</td>
            <td>${empleado.cedula}</td>
            <td>${empleado.nombre_departamento}</td>
            <td>${empleado.cargo}</td>
            <td>${empleado.fecha_ingreso}</td>
            <td>
                <button class='btn btn-primary btn-sm' data-bs-toggle="modal" 
                        data-bs-target="#ModalEmpleado" 
                        onclick='editarEmpleado(${empleado.id_empleado})'>
                    <i class='bx bx-edit'></i> Editar
                </button>
                <button class='btn btn-danger btn-sm' onclick='eliminar(${empleado.id_empleado})'>
                    <i class='bx bx-trash'></i> Eliminar
                </button>
            </td>
           </tr>`;
    });
    $("#ListaEmpleados").html(html);
  }).fail(() => {
    $("#ListaEmpleados").html('<tr><td colspan="7" class="text-center text-danger">Error al cargar empleados</td></tr>');
  });
};

var cargarDepartamentos = () => {
  return new Promise((resolve, reject) => {
    var html = `<option value="">Seleccione un departamento</option>`;
    $.get(rutaDepartamentos + "todos", (ListaDepartamentos) => {
      ListaDepartamentos = JSON.parse(ListaDepartamentos);
      $.each(ListaDepartamentos, (index, depto) => {
        html += `<option value="${depto.id_departamento}">${depto.nombre_departamento}</option>`;
      });
      $("#id_departamento").html(html);
      resolve();
    }).fail((error) => {
      reject(error);
    });
  });
};

var GuardarEditar = (e) => {
  e.preventDefault();
  var DatosFormularioEmpleado = new FormData($("#form_empleado")[0]);
  var accion = "";
  var idEmpleado = document.getElementById("idEmpleado").value;

  if (idEmpleado > 0) {
    accion = ruta + "actualizar";
    DatosFormularioEmpleado.append("idEmpleado", idEmpleado);
  } else {
    accion = ruta + "insertar";
  }

  $.ajax({
    url: accion,
    type: "post",
    data: DatosFormularioEmpleado,
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

var editarEmpleado = async (idEmpleado) => {
  await cargarDepartamentos();
  $.post(ruta + "uno", { idEmpleado: idEmpleado }, (empleado) => {
    empleado = JSON.parse(empleado);
    document.getElementById("idEmpleado").value = empleado.id_empleado;
    document.getElementById("nombre").value = empleado.nombre;
    document.getElementById("apellido").value = empleado.apellido;
    document.getElementById("cedula").value = empleado.cedula;
    document.getElementById("id_departamento").value = empleado.id_departamento;
    document.getElementById("cargo").value = empleado.cargo;
    document.getElementById("fecha_ingreso").value = empleado.fecha_ingreso;
    
    if (empleado.estado == 1) {
      document.getElementById("estado").checked = true;
    } else {
      document.getElementById("estado").checked = false;
    }
    updateEstadoLabel();
  });
};

var eliminar = (idEmpleado) => {
  if (confirm("¿Está seguro de eliminar este empleado?")) {
    $.post(ruta + "eliminarsuave", { idEmpleado: idEmpleado }, (respuesta) => {
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
  document.getElementById("idEmpleado").value = "";
  document.getElementById("nombre").value = "";
  document.getElementById("apellido").value = "";
  document.getElementById("cedula").value = "";
  document.getElementById("id_departamento").value = "";
  document.getElementById("cargo").value = "";
  document.getElementById("fecha_ingreso").value = new Date().toISOString().split('T')[0];
  document.getElementById("estado").checked = true;
  updateEstadoLabel();
  $("#ModalEmpleado").modal("hide");
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