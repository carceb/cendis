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
    $('#titulo').html('Informe Discográfico');
    $('#haltoventana').val(parent.$('#ventana_actual').height());
    $('#iconImprimir').show();
    $('#iconGuardar').hide();
    $('#iconBuscar').hide();
    $('#icono').hide();
    $('#iconImprimir').click(function(){			  
        if ($('#hid_proyecto').val()){
            sql_criterio = "WHERE proyecto.proyecto_id = "+$('#hid_proyecto').val();
            window.open('../reportes/lanzador_pdf.php?nombre_reporte=rpt_informe_discografico&TITULO=PRUEBA&SQL_WHERE='+sql_criterio,'','menubar=no,toolbar=no,directories=no,location=no, width=100, height=100, scrollbars=yes, top=0, left=0, estatus=no');
        }
        
    });

    $('#iconLimpiar').click(function(){
		//
	});
    $('#iconSalir').click(function(){
        parent.$('#memup').show();
        parent.$('#ventana_actual').remove();
    });
    //FUNCIONES
    llenaCombox('','tipo_artista');
    $('#sel_tipo_artista').change(function(){
        var objeto = {
            dependencia:'tipo_artista',
            dependencia_id:$('#sel_tipo_artista').val()};
        llenaCombox('','artista','',objeto);
        $('#sel_proyecto').html('');
    });
    
    $('#sel_artista').change(function(){
        var objeto = {
            dependencia:'artista',
            dependencia_id:$('#sel_artista').val(),
            dependencia2:'estatus_proyecto',
            dependencia_id2:3};
        llenaCombox('','proyecto','',objeto);
    });
    
    $('#sel_proyecto').change(function(){
        if ($('#sel_proyecto').val() != ''){
            $('#lbl_nombre_proyecto').html(capturaNombreOpcion('sel_proyecto',$('#sel_proyecto').val()));
            $('#hid_proyecto').val($('#sel_proyecto').val());			
        }
    });
    
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            proyecto_id:$('#hid_proyecto').val()};
        return JSON.stringify(objeto);
    }
});// Fin---$(document).ready(function(). }); 