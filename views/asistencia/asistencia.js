function init() {
  $("#form_asistencia").on("submit", (e) => {
    GuardarEditar(e);
  });
}

const ruta = "../../controllers/asistencia.controller.php?op=";
const rutaEmpleados = "../../controllers/empleados.controller.php?op=";

$().ready(() => {
  CargaLista();
  // Establecer fecha y hora actual por defecto
  const fechaActual = new Date().toISOString().split('T')[0];
  const horaActual = new Date().toTimeString().slice(0,5);
  document.getElementById("fecha").value = fechaActual;
  document.getElementById("hora_entrada").value = horaActual;
});

var CargaLista = () => {
  var html = "";
  $.get(ruta + "todos", (ListaAsistencia) => {
    if (!ListaAsistencia) {
      $("#ListaAsistencia").html('<tr><td colspan="9" class="text-center">No hay registros de asistencia</td></tr>');
      return;
    }
    
    ListaAsistencia = JSON.parse(ListaAsistencia);
    $.each(ListaAsistencia, (index, asistencia) => {
      const horaSalida = asistencia.hora_salida ? asistencia.hora_salida : '<span class="badge bg-warning">Pendiente</span>';
      const observaciones = asistencia.observaciones ? asistencia.observaciones : '-';
      
      html += `<tr>
            <td>${index + 1}</td>
            <td>${asistencia.fecha}</td>
            <td>${asistencia.nombre_completo}</td>
            <td>${asistencia.cedula}</td>
            <td>${asistencia.nombre_departamento}</td>
            <td><span class="badge bg-success">${asistencia.hora_entrada}</span></td>
            <td>${horaSalida}</td>
            <td>${observaciones}</td>
            <td>
                <button class='btn btn-primary btn-sm' data-bs-toggle="modal" 
                        data-bs-target="#ModalAsistencia" 
                        onclick='editarAsistencia(${asistencia.id_asistencia})'>
                    <i class='bx bx-edit'></i> Editar
                </button>
                <button class='btn btn-danger btn-sm' onclick='eliminar(${asistencia.id_asistencia})'>
                    <i class='bx bx-trash'></i> Eliminar
                </button>
            </td>
           </tr>`;
    });
    $("#ListaAsistencia").html(html);
  }).fail(() => {
    $("#ListaAsistencia").html('<tr><td colspan="9" class="text-center text-danger">Error al cargar asistencias</td></tr>');
  });
};

var cargarEmpleados = () => {
  return new Promise((resolve, reject) => {
    var html = `<option value="">Seleccione un empleado</option>`;
    $.get(rutaEmpleados + "todos", (ListaEmpleados) => {
      ListaEmpleados = JSON.parse(ListaEmpleados);
      $.each(ListaEmpleados, (index, emp) => {
        html += `<option value="${emp.id_empleado}">${emp.nombre} ${emp.apellido} - ${emp.cedula}</option>`;
      });
      $("#id_empleado").html(html);
      resolve();
    }).fail((error) => {
      reject(error);
    });
  });
};

var GuardarEditar = (e) => {
  e.preventDefault();
  var DatosFormularioAsistencia = new FormData($("#form_asistencia")[0]);
  var accion = "";
  var idAsistencia = document.getElementById("idAsistencia").value;

  if (idAsistencia > 0) {
    accion = ruta + "actualizar";
    DatosFormularioAsistencia.append("idAsistencia", idAsistencia);
  } else {
    accion = ruta + "insertar";
  }

  $.ajax({
    url: accion,
    type: "post",
    data: DatosFormularioAsistencia,
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

var editarAsistencia = async (idAsistencia) => {
  await cargarEmpleados();
  $.post(ruta + "uno", { idAsistencia: idAsistencia }, (asistencia) => {
    asistencia = JSON.parse(asistencia);
    document.getElementById("idAsistencia").value = asistencia.id_asistencia;
    document.getElementById("id_empleado").value = asistencia.id_empleado;
    document.getElementById("fecha").value = asistencia.fecha;
    document.getElementById("hora_entrada").value = asistencia.hora_entrada;
    document.getElementById("hora_salida").value = asistencia.hora_salida || '';
    document.getElementById("observaciones").value = asistencia.observaciones || '';
  });
};

var eliminar = (idAsistencia) => {
  if (confirm("¿Está seguro de eliminar este registro de asistencia?")) {
    $.post(ruta + "eliminar", { idAsistencia: idAsistencia }, (respuesta) => {
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
  document.getElementById("idAsistencia").value = "";
  document.getElementById("id_empleado").value = "";
  document.getElementById("fecha").value = new Date().toISOString().split('T')[0];
  document.getElementById("hora_entrada").value = new Date().toTimeString().slice(0,5);
  document.getElementById("hora_salida").value = "";
  document.getElementById("observaciones").value = "";
  $("#ModalAsistencia").modal("hide");
};

init();