$(document).ready(function(){
//=========================================================================================================================
// Copyright 2011 AsociaciÃ³n Cooperativa Servicios y Bienes Kabuna R.L.
//
// This file is part of SISCENDIS.

// SISCENDIS is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// SISCENDIS is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with SISCENDIS. If not, see <http://www.gnu.org/licenses/>.
//=========================================================================================================================
//AcceVent();
ocultarIconos();
$('#titulo').html('Reporte GestiÃ³n Cendis');
$('#haltoventana').val(parent.$('#ventana_actual').height());
$('#iconImprimir').show();
$('#iconGuardar').hide();
$('#iconNuevo').hide();
$('#iconLimpiar').hide();
$('#iconBuscar').hide();
$('#icono').hide();
$('#txt_fecha_desde').datepicker({changeMonth: true,changeYear: true});//Calendario
$('#txt_fecha_hasta').datepicker({changeMonth: true,changeYear: true});//Calendario
$('#iconImprimir').click(function(){
mostrarReporte();
});


function mostrarReporte(){
criterio = false;
sql_criterio = "";
var fechaDesde;
var fechaHasta;
fechaDesde = dividirFecha($('#txt_fecha_desde').val())
fechaHasta = dividirFecha($('#txt_fecha_hasta').val())
switch($('#sel_tipo_reporte').val())
{
case '1':
sql_criterio ="WHERE proyecto.fecha_proyecto >= '" + fechaDesde + "' AND proyecto.fecha_proyecto <= '" + fechaHasta + "'"; 
window.open('../reportes/lanzador_pdf.php?nombre_reporte=rpt_proyectos_genero&SQL_WHERE='+sql_criterio,'','menubar=no,toolbar=no,directories=no,location=no, width=100, height=100, scrollbars=yes, top=0, left=0, estatus=no');
break;
case '2':
sql_criterio ="WHERE proyecto.fecha_proyecto >= '" + fechaDesde + "' AND proyecto.fecha_proyecto <= '" + fechaHasta + "'"; 
window.open('../reportes/lanzador_pdf.php?nombre_reporte=rpt_proyectos_estado&SQL_WHERE='+sql_criterio,'','menubar=no,toolbar=no,directories=no,location=no, width=100, height=100, scrollbars=yes, top=0, left=0, estatus=no');
break;
case '3':
sql_criterio ="WHERE proyecto.fecha_proyecto >= '" + fechaDesde + "' AND proyecto.fecha_proyecto <= '" + fechaHasta + "'"; 
window.open('../reportes/lanzador_pdf.php?nombre_reporte=rpt_proyectos_municipio&SQL_WHERE='+sql_criterio,'','menubar=no,toolbar=no,directories=no,location=no, width=100, height=100, scrollbars=yes, top=0, left=0, estatus=no');
break;
case '4':
sql_criterio ="WHERE proyecto.fecha_proyecto >= '" + fechaDesde + "' AND proyecto.fecha_proyecto <= '" + fechaHasta + "'"; 
window.open('../reportes/lanzador_pdf.php?nombre_reporte=rpt_proyectos_femenino&SQL_WHERE='+sql_criterio,'','menubar=no,toolbar=no,directories=no,location=no, width=100, height=100, scrollbars=yes, top=0, left=0, estatus=no');
break;
case '5':
sql_criterio ="WHERE proyecto.fecha_proyecto >= '" + fechaDesde + "' AND proyecto.fecha_proyecto <= '" + fechaHasta + "'"; 
window.open('../reportes/lanzador_pdf.php?nombre_reporte=rpt_proyectos_linea_editorial&SQL_WHERE='+sql_criterio,'','menubar=no,toolbar=no,directories=no,location=no, width=100, height=100, scrollbars=yes, top=0, left=0, estatus=no');
break;
case '6':
sql_criterio ="WHERE proyecto.fecha_proyecto >= '" + fechaDesde + "' AND proyecto.fecha_proyecto <= '" + fechaHasta + "'"; 
window.open('../reportes/lanzador_pdf.php?nombre_reporte=rpt_proyectos_tipo_estuche&SQL_WHERE='+sql_criterio,'','menubar=no,toolbar=no,directories=no,location=no, width=100, height=100, scrollbars=yes, top=0, left=0, estatus=no');
break;
case '8':
sql_criterio ="WHERE proyecto.fecha_proyecto >= '" + fechaDesde + "' AND proyecto.fecha_proyecto <= '" + fechaHasta + "' AND (proyecto.estatus_proyecto_id >= 2)"; 
window.open('../reportes/lanzador_pdf.php?nombre_reporte=rpt_proyectos_aprobado_comision&SQL_WHERE='+sql_criterio,'','menubar=no,toolbar=no,directories=no,location=no, width=100, height=100, scrollbars=yes, top=0, left=0, estatus=no');
break;
case '9':
sql_criterio ="WHERE proyecto.fecha_proyecto >= '" + fechaDesde + "' AND proyecto.fecha_proyecto <= '" + fechaHasta + "'AND (proyecto.estatus_proyecto_id = 0)"; 
window.open('../reportes/lanzador_pdf.php?nombre_reporte=rpt_rechazado_comision&SQL_WHERE='+sql_criterio,'','menubar=no,toolbar=no,directories=no,location=no, width=100, height=100, scrollbars=yes, top=0, left=0, estatus=no');
break;
}
}

function dividirFecha(valorFecha){

fechaOriginal ="";
var fechaOriginal = valorFecha;
var resultadoSplit = fechaOriginal.split('/');
var dia = resultadoSplit[0];
var mes = resultadoSplit[1];
var ano = resultadoSplit[2];

return ano + '-' + mes + '-' + dia;
}

$('#iconLimpiar').click(function(){
//
});
$('#iconSalir').click(function(){
parent.$('#memup').show();
parent.$('#ventana_actual').remove();
});
//FUNCIONES

function creaParametros(){
//Retorna los parÃ¡rametros en notaciÃ³n JSON.
var objeto = {
proyecto_id:$('#hid_proyecto').val()};
return JSON.stringify(objeto);
}
});// Fin---$(document).ready(function(). }); 