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
    llenaCombox('','seguridad.grupo');
    $('#titulo').html('::. Actualizar .::');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
        //if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('permisos_catalogo','410','400','','div_form');
    });
    
    $('#iconLimpiar').click(function(){limpiar();});
    
    $('#sel_grupo').change(function(){
		//if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        if ($('#sel_grupo').val() != ''){
			$('#hid_grupo').val($('#sel_grupo').val());
			$('#lbl_nombre_grupo').html(capturaNombreOpcion('sel_grupo',$('#sel_grupo').val()));
    		$('.fila_permisos').remove();
			cargaGrilla($('#sel_grupo').val());
        }
    });
	
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
				grupo_id:$('#hid_grupo').val(),
				permisos_ventana:creaArrayPermisos('chk_permisos_ventana'),
				permisos_ingresar:creaArrayPermisos('chk_permisos_ingresar'),
				permisos_buscar:creaArrayPermisos('chk_permisos_buscar'),
				permisos_modificar:creaArrayPermisos('chk_permisos_modificar'),
				permisos_eliminar:creaArrayPermisos('chk_permisos_eliminar'),
				permisos_imprimir:creaArrayPermisos('chk_permisos_imprimir'),
				permisos_listar:creaArrayPermisos('chk_permisos_listar')};
        return JSON.stringify(objeto);
    }
	
	function creaArrayPermisos(nomb_checkbox){
        //crea un array con los permisos otorgados por tipo de permiso según el nombre de checkbos pasado.
        var array_permiso = new Array();
        $('input[id='+nomb_checkbox+']').each( function(i){
            if($(this).attr('checked')){
                array_permiso[i]=$(this).val()+':t';
            }else{
                array_permiso[i]=$(this).val()+':f';
            }
        });
        return array_permiso;
    }
	
	function buscaVentanas(){
        //if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        $('#grilla').remove();
        
    }
	
    function valida(){
        retorna = true;
		//validar los datos requeridos
		if ($('#hid_grupo').val() == ''){
            jAlert('Debe Seleccionar un Grupo', 'Operación cancelada');
            retorna =false;
        }
	return retorna;
    }
    $('#iconGuardar').click(function(){
		//if($('#prms').data('pms_modificar')=='f'){msjAccss();return;}
        if(valida()){
			jConfirm('Desea Actualizar el Registro actual', 'Confirmación de Proceso', function(rx){
				if(rx){
					$.post("../modelo/cls_permisos.php",{metodo:"actualizaPermisos",parametros:creaParametros()},function(resp_x){alert(resp_x);
						jAlert(resp_x, 'Confirmación de Proceso');
					},"json");
				}else{
					jAlert('Operación Cancelada', 'Confirmación de Proceso');
				}
			});
		}
    });
});// Fin---$(document).ready(function().

function montarDatosGrupo(grupo_id,nombre_grupo){
    limpiar()
    $('#hid_grupo').val(grupo_id);
	$('#sel_grupo').val(grupo_id)
    $('#lbl_nombre_grupo').html(nombre_grupo);
	cargaGrilla(grupo_id);
}

function limpiar(){
    ocultarIconos();
    $('#hid_grupo').val('');
    $('#sel_grupo').val('');
    $('#lbl_nombre_grupo').html('');
    $('.fila_permisos').remove();
    $('#titulo').html('::. Ingresar .::');
}

function cargaGrilla(grupo_id){
	$.post("../modelo/cls_permisos.php",{metodo:"cargaPermisos",parametros:grupo_id},function(data){//se ejecula la b�squeda.
		if(data.filas){//si trae resultado, entra.
			var background,a=0;
			$.each(data.filas, function(cant_reg,detalle){//se recorre el json.grilla.
				background = a%2==0?'background-color:#CCCCCC':'';
				$('#grilla_permisos tbody').append('<tr style="'+background+'" class="fila_permisos">'+
						'<td>&nbsp;'+detalle.ventana_titulo+'</td>'+
						'<td style="text-align:center;"><input id="chk_permisos_ventana" name="lista_permisos" type="checkbox" value="'+detalle.permisos_id+'"'+checked(detalle.permisos_ventana)+' /></td>'+
						'<td style="text-align:center;"><input id="chk_permisos_ingresar" name="lista_permisos" type="checkbox" value="'+detalle.permisos_id+'"'+checked(detalle.permisos_ingresar)+' /></td>'+
						'<td style="text-align:center;"><input id="chk_permisos_buscar" name="lista_permisos" type="checkbox" value="'+detalle.permisos_id+'"'+checked(detalle.permisos_buscar)+' /></td>'+
						'<td style="text-align:center;"><input id="chk_permisos_modificar" name="lista_permisos" type="checkbox" value="'+detalle.permisos_id+'"'+checked(detalle.permisos_modificar)+' /></td>'+
						'<td style="text-align:center;"><input id="chk_permisos_eliminar" name="lista_permisos" type="checkbox" value="'+detalle.permisos_id+'"'+checked(detalle.permisos_eliminar)+' /></td>'+
						'<td style="text-align:center;"><input id="chk_permisos_imprimir" name="lista_permisos" type="checkbox" value="'+detalle.permisos_id+'"'+checked(detalle.permisos_imprimir)+' /></td>'+
						'<td style="text-align:center;"><input id="chk_permisos_listar" name="lista_permisos" type="checkbox" value="'+detalle.permisos_id+'"'+checked(detalle.permisos_listar)+' /></td>'+
					'</tr>');
				a++;
			});//Fin $.each
		}
	}, "json");
}