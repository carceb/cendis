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
    //AcceVent();
    ocultarIconos();
    $('#titulo').html('Listado de Proyectos');
    $('#haltoventana').val(parent.$('#ventana_actual').height());
    $('#iconImprimir').show();
    $('#iconGuardar').hide();
    $('#iconBuscar').hide();
    $('#icono').hide();
    llenaCombox('','tipo_proyecto');
    llenaCombox('','genero_musical');
    $('#iconImprimir').click(function(){			  
       criterio = false;
            sql_criterio = "";
            if ($('#sel_artista').val()){
                sql_criterio = "WHERE proyecto.artista_id = "+$('#sel_artista').val();
                criterio = true;
            }else if ($('#sel_tipo_artista').val()){
				sql_criterio = "WHERE artista.tipo_artista_id = "+$('#sel_tipo_artista').val();
                criterio = true;
            }
            if ($('#sel_tipo_proyecto').val()){
				sql_criterio += (criterio)? " AND": " WHERE";
				sql_criterio += " proyecto.tipo_proyecto_id = "+$('#sel_tipo_proyecto').val();
				criterio = true;
            }
			
            if ($('#sel_genero_musical').val()){
				sql_criterio += (criterio)? " AND": " WHERE";
				sql_criterio += " proyecto.genero_musical_id = "+$('#sel_genero_musical').val();
				criterio = true;
            }
        window.open('../reportes/lanzador_pdf.php?nombre_reporte=rpt_proyecto&TITULO=PRUEBA&SQL_WHERE='+sql_criterio,'','menubar=no,toolbar=no,directories=no,location=no, width=100, height=100, scrollbars=yes, top=0, left=0, estatus=no');
    });

    $('#iconLimpiar').click(function(){
        limpiar();
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
    
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            proyecto_id:$('#hid_proyecto').val()};
        return JSON.stringify(objeto);
    }
});// Fin---$(document).ready(function(). });

function limpiar(){
    $('#sel_tipo_artista').val('');
    $('#sel_artista').html('');
    $('#sel_tipo_proyecto').val('');
    $('#sel_genero_musical').val('');
}