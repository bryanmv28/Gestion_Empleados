$().ready(() => {
  // Establecer mes y año actuales
  const fecha = new Date();
  document.getElementById("mes").value = fecha.getMonth() + 1;
  document.getElementById("anio").value = fecha.getFullYear();
});

const ruta = "../../controllers/asistencia.controller.php?op=";

var generarReporte = () => {
  const mes = document.getElementById("mes").value;
  const anio = document.getElementById("anio").value;
  
  if (!mes || !anio) {
    alert("Por favor seleccione mes y año");
    return;
  }
  
  var html = "";
  $.post(ruta + "reporteMensual", { mes: mes, anio: anio }, (reporte) => {
    reporte = JSON.parse(reporte);
    
    if (reporte.length === 0) {
      html = `<tr><td colspan="6" class="text-center">No hay registros para este período</td></tr>`;
    } else {
      $.each(reporte, (index, item) => {
        const diasAsistidos = item.dias_asistidos ? item.dias_asistidos : 0;
        const listaDias = item.dias ? item.dias : 'Sin asistencias';
        
        html += `<tr>
              <td>${index + 1}</td>
              <td>${item.nombre_completo}</td>
              <td>${item.cedula}</td>
              <td>${item.nombre_departamento}</td>
              <td class="text-center">
                  <span class="badge ${diasAsistidos > 0 ? 'bg-primary' : 'bg-secondary'}">
                      ${diasAsistidos}
                  </span>
              </td>
              <td>${listaDias}</td>
             </tr>`;
      });
    }
    
    $("#ListaReporte").html(html);
  }).fail(() => {
    $("#ListaReporte").html('<tr><td colspan="6" class="text-center text-danger">Error al generar el reporte</td></tr>');
  });
};

// Función para generar PDF con FPDF
var generarPDF = () => {
  const mes = document.getElementById("mes").value;
  const anio = document.getElementById("anio").value;
  
  if (!mes || !anio) {
    alert("Por favor seleccione mes y año");
    return;
  }
  
  // Abrir el archivo PHP que genera el PDF
  window.open(`imprimir_reporte_asistencia.php?mes=${mes}&anio=${anio}`, '_blank');
};

var imprimirReporte = () => {
  const mes = document.getElementById("mes").value;
  const anio = document.getElementById("anio").value;
  
  // Validar que haya datos en la tabla
  const filas = $("#ListaReporte tr").length;
  if (filas === 0 || $("#ListaReporte tr td").attr('colspan') === '6') {
    alert("Primero debe generar el reporte");
    return;
  }
  
  const nombresMeses = [
    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", 
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
  ];
  
  var ventana = window.open('', 'PRINT', 'height=600,width=800');
  
  ventana.document.write('<html><head><title>Reporte de Asistencia Mensual</title>');
  ventana.document.write('<style>');
  ventana.document.write('body { font-family: Arial, sans-serif; padding: 20px; }');
  ventana.document.write('h2 { text-align: center; color: #333; }');
  ventana.document.write('.info { text-align: center; margin-bottom: 20px; font-size: 14px; }');
  ventana.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
  ventana.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
  ventana.document.write('th { background-color: #4CAF50; color: white; font-weight: bold; }');
  ventana.document.write('tr:nth-child(even) { background-color: #f2f2f2; }');
  ventana.document.write('.badge { background-color: #2196F3; color: white; padding: 5px 10px; border-radius: 3px; font-weight: bold; }');
  ventana.document.write('.text-center { text-align: center; }');
  ventana.document.write('.footer { margin-top: 30px; text-align: right; font-size: 12px; color: #666; }');
  ventana.document.write('</style>');
  ventana.document.write('</head><body>');
  ventana.document.write('<h2>Reporte de Asistencia Mensual</h2>');
  ventana.document.write(`<div class="info"><strong>Período:</strong> ${nombresMeses[mes-1]} de ${anio}</div>`);
  ventana.document.write('<table>');
  
  // Encabezados
  ventana.document.write('<thead><tr>');
  ventana.document.write('<th style="width: 5%;">#</th>');
  ventana.document.write('<th style="width: 25%;">Empleado</th>');
  ventana.document.write('<th style="width: 12%;">Cédula</th>');
  ventana.document.write('<th style="width: 20%;">Departamento</th>');
  ventana.document.write('<th style="width: 13%;" class="text-center">Días Asistidos</th>');
  ventana.document.write('<th style="width: 25%;">Días</th>');
  ventana.document.write('</tr></thead>');
  
  // Datos
  ventana.document.write('<tbody>');
  $('#ListaReporte tr').each(function() {
    ventana.document.write('<tr>');
    $(this).find('td').each(function() {
      ventana.document.write('<td>' + $(this).html() + '</td>');
    });
    ventana.document.write('</tr>');
  });
  ventana.document.write('</tbody>');
  
  ventana.document.write('</table>');
  ventana.document.write('<div class="footer">');
  ventana.document.write('Generado el: ' + new Date().toLocaleString('es-ES'));
  ventana.document.write('</div>');
  ventana.document.write('</body></html>');
  
  ventana.document.close();
  ventana.focus();
  
  setTimeout(function() {
    ventana.print();
    ventana.close();
  }, 250);
};