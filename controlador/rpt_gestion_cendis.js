$(document).ready(function(){
    //=========================================================================================================================
    //    Copyright 2011 Asociación Cooperativa Servicios y Bienes Kabuna R.L.
    //
    //    This file is part of SISCENDIS.

    //    SISCENDIS is free software: you can redistribute it and/or modify
    //    it under the terms of the GNU General Public License as published by
    //    the Free Software Foundation, either version 3 of the License, or
    //    (at your option) any later version.

    //    SISCENDIS is distributed in the hope that it will be useful,
    //    but WITHOUT ANY WARRANTY; without even the implied warranty of
    //    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    //    GNU General Public License for more details.

    //    You should have received a copy of the GNU General Public License
    //    along with SISCENDIS.  If not, see <http://www.gnu.org/licenses/>.
    //=========================================================================================================================    
    AcceVent();
    ocultarIconos();
    $('#titulo').html('Reporte Gestión Cendis');
    $('#haltoventana').val(parent.$('#ventana_actual').height());
    $('#iconImprimir').show();
    $('#iconGuardar').hide();
    $('#iconBuscar').hide();
    $('#icono').hide();
    $('#iconImprimir').click(function(){
        criterio = false;
        sql_criterio = "";
        if ($('#sel_estado').val() != ''){
            sql_criterio = "WHERE reporte_gestion_cendis.estado_id = "+$('#sel_estado').val();
            criterio = true;
        }
        if ($('#sel_municipio').val() != ''){
            sql_criterio += (criterio)? " AND": " WHERE";
            sql_criterio += " reporte_gestion_cendis.municipo_id = "+$('#sel_municipio').val();
            criterio = true;
        }
        window.open('../reportes/lanzador_pdf.php?nombre_reporte=rpt_gestion_cendis&TITULO=PRUEBA&SQL_WHERE='+sql_criterio,'','menubar=no,toolbar=no,directories=no,location=no, width=100, height=100, scrollbars=yes, top=0, left=0, estatus=no');
        
    });

    $('#iconLimpiar').click(function(){
		//
	});
    $('#iconSalir').click(function(){
        parent.$('#memup').show();
        parent.$('#ventana_actual').remove();
    });
    //FUNCIONES
    llenaCombox('','estado');
    $('#sel_estado').change(function(){
        var objeto = {
            dependencia:'estado',
            dependencia_id:$('#sel_estado').val()};
        llenaCombox('','municipio','',objeto);
    });
    
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            proyecto_id:$('#hid_proyecto').val()};
        return JSON.stringify(objeto);
    }
});// Fin---$(document).ready(function(). }); 