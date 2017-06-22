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
	$('#iconBuscar').hide();
    $('.fila_usuarios').remove();
    llenaCombox('','seguridad.grupo');
	
	$.post("../modelo/cls_usuario_grupo.php",{metodo:"cargaGrilla",parametros:''},function(data){	
		var nombre_combo = 'sel_usuario';
        if(data.filas){//si trae resultado, entra.
            $('#'+nombre_combo).append('<option value="">--Seleccione--</option>');
            $.each(data.filas, function(i,fila){//se recorre el json.
            	$('#'+nombre_combo).append('<option value="'+fila.id+'">'+fila.nombre+'</option>');              
            });//Fin $.each
        }else{
            $('#'+nombre_combo).append('<option value="">--No hay--</option>');
        }
    },"json");//
	
	$('#titulo').html('::. Actualizar .::');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconLimpiar').click(function(){limpiar();});
	
	$('#sel_grupo').change(function(){
        if ($('#sel_grupo').val() != ''){
			$('#hid_grupo').val($('#sel_grupo').val());
			$('#lbl_nombre_grupo').html(capturaNombreOpcion('sel_grupo',$('#sel_grupo').val()));
			LlenarUsuario($('#sel_grupo').val());
        }else{
            limpiar();
        }
    });
	
	$('#sel_usuario').change(function(){
        if ($('#sel_usuario').val() != ''){
			$('#hid_usuario').val($('#sel_usuario').val());
			$('#lbl_nombre_usuario').html(capturaNombreOpcion('sel_usuario',$('#sel_usuario').val()));
        }else{
            limpiar();
        }
    });
	
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            grupo_id:$('#hid_grupo').val(),
            usuario_id:$('#hid_usuario').val(),
			usuario_grupo_fechareg:fechaActual()};
        return JSON.stringify(objeto);
    }
    function validaIngreso(){
		//validar los datos requeridos
		retorna = true;
		if ($('#sel_grupo').val() == ''){
			jAlert('Debe ingresar el Grupo.', 'Operación cancelada');
			retorna =false;
		}
		if ($('#sel_usuario').val() == ''){
			jAlert('Debe ingresar el Usuario.', 'Operación cancelada');
			retorna =false;
		}
		return retorna;

    }
    $('#iconGuardar').click(function(){
		//if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
		if(validaIngreso()){
			jConfirm('Desea guardar este Registro', 'Confirmación de Proceso', function(rx){
				if(rx){
					$.post("../modelo/cls_usuario_grupo.php",{metodo:"ingresaUsuario_Grupo",parametros:creaParametros()},function(resp_x){
						if (resp_x.usuario_grupo_id){
							LlenarUsuario($('#sel_grupo').val());
							jAlert(resp_x.mensaje, 'Confirmación de Proceso');
						}else{
							jAlert(resp_x.mensaje, 'Confirmación de Proceso');
						} 
					},"json");//,"json"
				}else{
					jAlert('Operación Cancelada', 'Confirmación de Proceso');
				}
			});
		}
    });// fin $('#iconGuardar')
});// Fin---$(document).ready(function().

function limpiar(){
    ocultarIconos();
    $('.fila_usuarios').remove();
    $('#hid_grupo').val('');
    $('#lbl_nombre_grupo').html('');   
    $('#hid_usuario').val('');
    $('#lbl_nombre_usuario').html('');   
    $('#sel_grupo').val('');
    $('#sel_usuario').val('');
}

function LlenarUsuario(grupo_id){
    $('.fila_usuarios').remove();
    var objeto = {caso:'listar_usuarios',grupo_id:grupo_id};
    objeto = JSON.stringify(objeto);
    $.post("../modelo/cls_usuario_grupo.php",{metodo:"LlenarUsuarios",parametros:objeto},function(resp_x){
        $('#usuarios tbody').append(resp_x.html);
    },"json");//
}

function eliminar(usuario_id){
    jConfirm('Se va Eliminar el registro Seleccionado', 'Confirmación de Proceso', function(rx){
        if(rx){
    		var objeto = {usuario_id:usuario_id,grupo_id:$('#hid_grupo').val()};
            $.post("../modelo/cls_capitulo.php",{metodo:"eliminarUsuario_Grupo",parametros:objeto},function(resp_x){
                limpiar()
                jAlert(resp_x.mensaje, 'Confirmación de Proceso');
            },"json");	// Fin $.getJSON.
        }else{
           jAlert('Operación Cancelada', 'Confirmación de Proceso');
        }
    });
}
