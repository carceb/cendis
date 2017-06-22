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
    $('#titulo').html('Actualizar Genero Musical');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
        if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('genero_musical_catalogo','410','400','','div_form');
    });
    
    $('#iconLimpiar').click(function(){limpiar();});
    
	
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            genero_musical_id:$('#hid_genero_musical').val(),
            nombre_genero_musical:$('#txt_genero_musical').val()};
        return JSON.stringify(objeto);
    }
    function validaIngreso(){
        //validar los datos requeridos
        retorna = true;
        if ($('#txt_genero_musical').val() == ''){
            jAlert('Debe ingresar el nombre del genero musical.', 'Operación cancelada');
            retorna =false;
        }   
        return retorna;

    }
    $('#iconGuardar').click(function(){
        if(!$('#hid_genero_musical').val()){
            if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
            if(validaIngreso()){
                jConfirm('Desea guardar este Registro', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_genero_musical.php",{metodo:"ingresaGeneroMusical",parametros:creaParametros()},function(resp_x){
                            if (resp_x.id_genero_musical){
                                $('#hid_genero_musical').val(resp_x.id_genero_musical);
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
                    $.post("../modelo/cls_genero_musical.php",{metodo:"actualizaGeneroMusical",parametros:creaParametros()},function(resp_x){//alert(resp_x);                    
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
                $.post("../modelo/cls_genero_musical.php",{metodo:"eliminarGeneroMusical",parametros:$('#hid_genero_musical').val()},function(resp_x){
                    limpiar();
                    jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                },"json");	// Fin $.getJSON.
            }else{
               jAlert('Operación Cancelada', 'Confirmación de Proceso');
            }
        });
    }).hide();// fin $('#iconEliminar')
});// Fin---$(document).ready(function().

function montarGeneroMusical(genero_musical_id,nombre_genero_musical){
    limpiar();
    $('#hid_genero_musical').val(genero_musical_id); 
    $('#txt_genero_musical').val(nombre_genero_musical);
    $('#iconEliminar').show();
    $('#iconImprimir').show();
}

function limpiar(){
    ocultarIconos();
    $('#hid_genero_musical').val('');
    $('#txt_genero_musical').val('');
}

$(function() {
    var availableTags = [];
    $.post("../modelo/cls_genero_musical.php",{metodo:"availableTags",parametros:''},function(data){
        if(data.filas){//si trae resultado, entra.
            $.each(data.filas, function(cant_reg,detalle){//se recorre el json.
                availableTags[cant_reg] = detalle.nombre_genero_musical;
            });
        }
        $('#txt_genero_musical').autocomplete({
                source: availableTags
        });
    },"json");    
});