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
    LlenarSolicitudes();
    $('#titulo').html('Asignar Línea Editorial');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
       if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('linea_editorial_catalogo','410','400','','div_form');
    });
    
    $('#iconBuscar').hide();
    $('#iconLimpiar').click(function(){LlenarSolicitudes();});
	
    $('#iconGuardar').click(function(){
		if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
		if(valida()){
			jConfirm('¿Desea guardar este Registro?', 'Confirmación de Proceso', function(rx){
				if(rx){
					$('.fila_linea_editorial').each(function () {
						id = (this.id);
						if ($('#sel_linea_editorial_'+id).val() != '' || $('#txt_cantidad_copias_'+id).val() != ''){
							var cantidad_copias = $('#txt_cantidad_copias_'+id).val();
							if (cantidad_copias.match(/^\d+$/) != null){
								var objeto = {proyecto_id:id,linea_editorial:$('#sel_linea_editorial_'+id).val(),cantidad_copias:$('#txt_cantidad_copias_'+id).val(),estatus_proyecto_id:3};
								objeto = JSON.stringify(objeto)
								$.post("../modelo/cls_linea_editorial.php",{metodo:"ActualizarEstatusProyecto",parametros:objeto},function(){},"json");//
							}
						}
					});
					jAlert('La operación se efectuó exitosamente', 'Confirmación de Proceso');
					LlenarSolicitudes();
				}else{
					jAlert('Operación Cancelada', 'Confirmación de Proceso');
				}
			});
		}
    });
	
    //FUNCIONES
    function valida(){
        retorna = true;
        /*
        $('.fila_linea_editorial').each(function () {
            id = (this.id);
            if ($('#sel_linea_editorial_'+id).val() == ''){
                    jAlert('Debe indicar la linea editorial.', 'Operación cancelada');
                    retorna = false;
            }
         }); 
        $('.fila_linea_editorial').each(function () {
            id = (this.id);
            if ($('#txt_cantidad_copias_'+id).val() == ''){
                    jAlert('Debe indicar la cantidad de copias.', 'Operación cancelada');
                    retorna = false;
            }
         });
         */
        return retorna;
    }
});// Fin---$(document).ready(function().

function ActualizarEstatusProyecto(){
    
}

function LlenarSolicitudes(){
    $('.fila_linea_editorial').remove();
    var objeto = {caso:'listar_proyectos'};
    objeto = JSON.stringify(objeto);
    $.post("../modelo/cls_linea_editorial.php",{metodo:"LlenarSolicitudes",parametros:objeto},function(data){
        if(data.filas){//si trae resultado, entra.
            var i = 1;
            var background = '';
            var resto;
            $.each(data.filas, function(cant_reg,detalle){//se recorre el json.
                resto = i % 2;
                if (resto == 0){
                    background = '';
                }else{
                    background = 'background-color:#CCCCCC';
                }
                var html = '<tr id="'+detalle.proyecto_id+'" style="'+background+'"class="fila_linea_editorial">'
                    html += '    <td id="tipo_artista_'+detalle.proyecto_id+'">&nbsp;'+detalle.nombre_tipo_artista+'</td>'
                    html += '    <td id="artista_'+detalle.proyecto_id+'">&nbsp;'+detalle.nombre_artista+'</td>'
                    html += '    <td id="proyecto_'+detalle.proyecto_id+'">&nbsp;'+detalle.nombre_proyecto+'</td>'
		    html += '    <td><select id="sel_linea_editorial_'+detalle.proyecto_id+'" name="sel_linea_editorial_'+detalle.proyecto_id+'" class="select">'
                    html += '    </select>'
                    html += '    </td>'
                    html += '    <td><input type="text" id="txt_cantidad_copias_'+detalle.proyecto_id+'"  style="width:50px;margin-left:5px;" class="input" /></td>'
                    html += '</tr>';
                $('#linea_editorial tbody').append(html);
                llenaCombox('sel_linea_editorial_'+detalle.proyecto_id,'linea_editorial');
                i++;
            });//Fin $.each
        }
    },"json");//
}