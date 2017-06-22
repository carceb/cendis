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
    $('#titulo').html('::. Ingresar .::');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
        if($('#prms').data('pms_buscar')){msjAccss();return;}
        open_form('tipo_formato_catalogo','410','400','','div_form');
    });
    
    $('#iconLimpiar').click(function(){limpiar();});
    
	
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            tipo_formato_id:$('#hid_tipo_formato_id').val(),
            nombre_tipo_formato:$('#txt_tipo_formato').val()};
        return JSON.stringify(objeto);
    }
    function validaIngreso(){
        //validar los datos requeridos
        retorna = true;

         if ($('#txt_tipo_formato').val() == ''){
                jAlert('Debe ingresar el tipo de formato.', 'Operación cancelada');
                retorna =false;
        }
 
        return retorna;

    }
    $('#iconGuardar').click(function(){
        if(!$('#hid_tipo_formato_id').val()){
            if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
            if(validaIngreso()){
                jConfirm('Desea guardar este Registro', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_tipo_formato.php",{metodo:"ingresaTipoFormato",parametros:creaParametros()},function(resp_x){
                            if (resp_x.id_tipo_formato){
                                $('#hid_tipo_formato_id').val(resp_x.id_tipo_formato);
                                $('#titulo').html('::. Actualizar .::');
                                $('#iconEliminar').show();
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
            if($('#prms').data('pms_modificar')=='f'){msjAccss();return;}
            jConfirm('Desea Actualizar el Registro actual', 'Confirmación de Proceso', function(rx){
                if(rx){
                    $.post("../modelo/cls_tipo_formato.php",{metodo:"actualizaTipoFormato",parametros:creaParametros()},function(resp_x){                
                        jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                    },"json");
                }else{
                    jAlert('Operación Cancelada', 'Confirmación de Proceso');
                }
            });
        }
    });// fin $('#iconGuardar')
    $('#iconEliminar').click(function(){
        if($('#prms').data('pms_eliminar')=='f'){msjAccss();return;}
        jConfirm('Se va Eliminar el registro actual', 'Confirmación de Proceso', function(rx){
            if(rx){
                $.post("../modelo/cls_tipo_formato.php",{metodo:"eliminarTipoFormato",parametros:$('#hid_tipo_formato_id').val()},function(resp_x){
                    limpiar();
                    jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                },"json");
            }else{
               jAlert('Operación Cancelada', 'Confirmación de Proceso');
            }
        });
    }).hide();
});

function montarTipoFormato(tipo_formato_id,nombre_tipo_formato){
    limpiar();
    $('#hid_tipo_formato_id').val(tipo_formato_id); 
    $('#txt_tipo_formato').val(nombre_tipo_formato);
    $('#iconEliminar').show();
    $('#iconImprimir').show();
    $('#titulo').html('::. Actualizar .::');
}

function limpiar(){
    ocultarIconos();
    $('#hid_tipo_formato_id').val('');
    $('#txt_tipo_formato').val('');
    $('#titulo').html('::. Ingresar .::');
}

$(function() {
    var availableTags = [];
    $.post("../modelo/cls_tipo_formato.php",{metodo:"availableTags",parametros:''},function(data){
        if(data.filas){//si trae resultado, entra.
            $.each(data.filas, function(cant_reg,detalle){//se recorre el json.
                availableTags[cant_reg] = detalle.nombre_tipo_formato;
            });
        }
        $('#txt_genero_musical').autocomplete({
                source: availableTags
        });
    },"json");    
});