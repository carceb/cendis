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
    $('#titulo').html('Motivo de Rechazo');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
        if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('motivo_rechazo_catalogo','410','400','','div_form');
    });
    
    $('#iconLimpiar').click(function(){limpiar();});
    
	
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            motivo_rechazo_id:$('#hid_motivo_rechazo').val(),
            nombre_motivo_rechazo:$('#txt_motivo_rechazo').val()};
        return JSON.stringify(objeto);
    }
    function validaIngreso(){
        //validar los datos requeridos
        retorna = true;
        if ($('#txt_motivo_rechazo').val() == ''){
            jAlert('Debe ingresar el motivo del rechazo.', 'Operación cancelada');
            retorna =false;
        }   
        return retorna;

    }
    $('#iconGuardar').click(function(){
        if(!$('#hid_motivo_rechazo').val()){
            if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
            if(validaIngreso()){
                jConfirm('¿Desea guardar este Registro?', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_motivo_rechazo.php",{metodo:"ingresaMotivoRechazo",parametros:creaParametros()},function(resp_x){
                            if (resp_x.motivo_rechazo_id){
                                $('#hid_motivo_rechazo').val(resp_x.motivo_rechazo_id);
                                $('#iconEliminar').show();
                                $('#iconImprimir').show();
                                jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                            }else{
                                jAlert('No se guardó el Registro', 'Confirmación de Proceso');
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
                    $.post("../modelo/cls_motivo_rechazo.php",{metodo:"actualizaMotivoRechazo",parametros:creaParametros()},function(resp_x){//alert(resp_x);                    
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
                $.post("../modelo/cls_motivo_rechazo.php",{metodo:"eliminarMotivoRechazo",parametros:$('#hid_motivo_rechazo').val()},function(resp_x){
                    limpiar();
                    jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                },"json");	// Fin $.getJSON.
            }else{
               jAlert('Operación Cancelada', 'Confirmación de Proceso');
            }
        });
    }).hide();// fin $('#iconEliminar')
});// Fin---$(document).ready(function().

function montarMotivoRechazo(motivo_rechazo_id,nombre_motivo_rechazo){
    limpiar();
    $('#hid_motivo_rechazo').val(motivo_rechazo_id); 
    $('#txt_motivo_rechazo').val(nombre_motivo_rechazo);
    $('#iconEliminar').show();
    $('#iconImprimir').show();
}

function limpiar(){
    ocultarIconos();
    $('#hid_motivo_rechazo').val('');
    $('#txt_motivo_rechazo').val('');
}

$(function() {
    var availableTags = [];
    $.post("../modelo/cls_motivo_rechazo.php",{metodo:"availableTags",parametros:''},function(data){
        if(data.filas){//si trae resultado, entra.
            $.each(data.filas, function(cant_reg,detalle){//se recorre el json.
                availableTags[cant_reg] = detalle.nombre_motivo_rechazo;
            });
        }
        $('#txt_motivo_rechazo').autocomplete({
                source: availableTags
        });
    },"json");    
});