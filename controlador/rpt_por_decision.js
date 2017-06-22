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
    ocultarIconos();
    $('#haltoventana').val(parent.$('#ventana_actual').height());
    $('#imprimir').hide();//Oculta el �cono de imprimir
	$('#iconGuardar').hide();
    $('#icono').hide();
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
            /*criterio = false;
            sql_criterio = "";
            if ($('#sel_tipo_punto').val() != ''){
                sql_criterio = "WHERE punto.punto_idtipo_punto = "+$('#sel_tipo_punto').val();
                criterio = true;
            }
            if ($('#sel_tipo_documento').val() != ''){
                    sql_criterio += (criterio)? " AND": " WHERE";
                    sql_criterio += " punto.punto_idtipo_documento = "+$('#sel_tipo_documento').val();
                    criterio = true;
            }
            if ($('#sel_anho_punto').val() != ''){
                    sql_criterio += (criterio)? " AND": " WHERE";
                    sql_criterio += " cast(date_part('year'::text,punto.punto_fecha_punto) AS text) = '"+$('#sel_anho_punto').val()+"'";
                    criterio = true;
            }
            if ($('#sel_decision').val() != ''){
                    sql_criterio += (criterio)? " AND": " WHERE";
                    sql_criterio += " propuesta.propuesta_iddecision = "+$('#sel_decision').val();
                    criterio = true;
            }*/
        window.open('../reportes/lanzador_pdf.php?nombre_reporte=report1&TITULO=PRUEBA&SQL_WHERE=','','menubar=no,toolbar=no,directories=no,location=no, width=100, height=100, scrollbars=yes, top=0, left=0, estatus=no');
    });
    $('#iconLimpiar').click(function(){
		//
	});
    $('#iconSalir').click(function(){
        parent.$('#memup').show();
        parent.$('#ventana_actual').remove();
    });
    //FUNCIONES
    function listaTipoPunto(id){
        llenaCombox('sel_tipo_punto','por_tipo_punto',id,'');
    }
    function listaTipoDocumento(id){
        llenaCombox('sel_tipo_documento','por_tipo_documento',id,'');
    }
    function listaDecision(){
        llenaCombox('sel_decision','por_decision','','');
    }

	function listaAnhoCorrelativo(){
		llenaCombox('sel_anho_punto','por_anho_correlativo','','');
	}
});// Fin---$(document).ready(function(). }); 