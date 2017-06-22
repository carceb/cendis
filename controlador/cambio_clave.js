
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
    $('#iconBuscar').hide();
    $('#titulo').html('::. Ingresar .::');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
	
    $('#iconLimpiar').click(function(){limpiar();});
	
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            usuario_pws_old:$('#txt_usuario_pws_old').val(),
			usuario_pws:$('#txt_usuario_pws').val(),
            usuario_fechareg:fechaActual()};
        return JSON.stringify(objeto);
    }
    function validaIngreso(){
        //validar los datos requeridos
        retorna = true;
		if ($('#txt_usuario_pws_old').val() == ''){
			jAlert('Debe ingresar la Contraseña anterior.', 'Operación cancelada');
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
		if(validaIngreso()){
			jConfirm('Desea guardar este Registro', 'Confirmación de Proceso', function(rx){
				if(rx){
					$.post("../modelo/cls_usuario.php",{metodo:"cambioClave",parametros:creaParametros()},function(resp_x){
						jAlert(resp_x.mensaje, 'Confirmación de Proceso');
					},"json");//,"json"
				}else{
					jAlert('Operación Cancelada', 'Confirmación de Proceso');
				}
			});
		}
    });
});// Fin---$(document).ready(function().

function limpiar(){
    ocultarIconos();
    $('#txt_usuario_pws_old').val('');
	$('#txt_usuario_pws').val('');
	$('#txt_confirme_usuario_pws').val('');
    $('#titulo').html('::. Ingresar .::');
}