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
    $('.psw').show();
    llenaCombox('','seguridad.usuario_estatus');
    $('#titulo').html('::. Ingresar .::');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
       //if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('usuario_catalogo','410','400','','div_form');
    });
    
    $('#iconLimpiar').click(function(){limpiar();});
	
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            usuario_id:$('#hid_usuario').val(),
            usuario_nombre:$('#txt_usuario_nombre').val(),
            usuario_apellido:$('#txt_usuario_apellido').val(),
			usuario_cedula:$('#txt_usuario_cedula').val(),
			usuario_user:$('#txt_usuario_user').val(),
			usuario_pws:$('#txt_usuario_pws').val(),
            usuario_estatus_id:$('#sel_usuario_estatus').val(),
            usuario_fechareg:fechaActual()};
        return JSON.stringify(objeto);
    }
    function validaIngreso(){
        //validar los datos requeridos
        retorna = true;
		if ($('#txt_usuario_nombre').val() == ''){
			jAlert('Debe ingresar el Nombre de Usuario.', 'Operación cancelada');
			retorna =false;
		}
		if ($('#txt_usuario_apellido').val() == ''){
			jAlert('Debe ingresar el Apellido de Usuario.', 'Operación cancelada');
			retorna =false;
		}
		if ($('#txt_usuario_cedula').val() == ''){
			jAlert('Debe ingresar el Numero de Cedula o Pasaporte del Usuario.', 'Operación cancelada');
			retorna =false;
		}
		if ($('#txt_usuario_user').val() == ''){
			jAlert('Debe ingresar el Usuario.', 'Operación cancelada');
			retorna =false;
		}
		if ($('#txt_usuario_pws').val() == ''){
			jAlert('Debe ingresar la Contraseña del Usuario.', 'Operación cancelada');
			retorna =false;
		}
		if ($('#txt_confirme_usuario_pws').val() == ''){
			jAlert('Debe ingresar la Confirmacion de la Contraseña del Usuario.', 'Operación cancelada');
			retorna =false;
		}
		if ($('#txt_confirme_usuario_pws').val() != $('#txt_usuario_pws').val()){
			jAlert('No coinciden las Contraseña del Usuario.', 'Operación cancelada');
			retorna =false;
		}
        return retorna;

    }
    $('#iconGuardar').click(function(){
        if(!$('#hid_usuario').val()){
            //if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
            if(validaIngreso()){
                jConfirm('Desea guardar este Registro', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_usuario.php",{metodo:"ingresaUsuario",parametros:creaParametros()},function(resp_x){
                            if (resp_x.usuario_id){
                                //alert(resp_x.id_artista);
                                $('#hid_usuario').val(resp_x.usuario_id);
                                $('#titulo').html('::. Actualizar .::');
                                $('#iconImprimir').show();
                                jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                            }else{
                                jAlert('No se guardo el Registro', 'Confirmación de Proceso');
                            } 
                        },"json");//,"json"
                    }else{
                        jAlert('Operación Cancelada', 'Confirmación de Proceso');
                    }
                });
            }
        }else{
            //if($('#prms').data('pms_modificar')=='f'){msjAccss();return;}
            jConfirm('Desea Actualizar el Registro actual', 'Confirmación de Proceso', function(rx){
                if(rx){
                    $.post("../modelo/cls_usuario.php",{metodo:"actualizaUsuario",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                        jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                    },"json");
                }else{
                    jAlert('Operación Cancelada', 'Confirmación de Proceso');
                }
            });
        }
    });
});// Fin---$(document).ready(function().

function montarDatosUsuario(usuario_id,usuario_nombre,usuario_apellido,usuario_cedula,usuario_user,usuario_pws,usuario_estatus_id){
    limpiar();
	$('#hid_usuario').val(usuario_id);
	$('#txt_usuario_nombre').val(usuario_nombre);
	$('#txt_usuario_apellido').val(usuario_apellido);
	$('#txt_usuario_cedula').val(usuario_cedula);
	$('#txt_usuario_user').val(usuario_user);
	$('#sel_usuario_estatus').val(usuario_estatus_id);
    $('.psw').hide();
    $('#iconImprimir').show();
    $('#titulo').html('::. Actualizar .::');
}

function limpiar(){
    ocultarIconos();
    $('#hid_usuario').val('');
    $('#txt_usuario_nombre').val('');
	$('#txt_usuario_apellido').val('');
	$('#txt_usuario_cedula').val('');
	$('#txt_usuario_user').val('');
	$('#txt_usuario_pws').val('');
	$('#txt_confirme_usuario_pws').val('');
	$('#sel_usuario_estatus').val('');
    $('.psw').show();
    $('#titulo').html('::. Ingresar .::');
}