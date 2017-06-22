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
       //if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('grupo_catalogo','410','400','','div_form');
    });
    
    $('#iconLimpiar').click(function(){limpiar();});
	
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            grupo_id:$('#hid_grupo').val(),
            nombre_grupo:$('#txt_nombre_grupo').val(),
            descripcion_grupo:$('#txt_descripcion_grupo').val(),
            grupo_fechareg:fechaActual()};
        return JSON.stringify(objeto);
    }
    function validaIngreso(){
        //validar los datos requeridos
        retorna = true;
         if ($('#txt_nombre_grupo').val() == ''){
                jAlert('Debe ingresar el Nombre de Grupo.', 'Operación cancelada');
                retorna =false;
        }
        return retorna;

    }
    $('#iconGuardar').click(function(){
        if(!$('#hid_grupo').val()){
            //if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
            if(validaIngreso()){
                jConfirm('Desea guardar este Registro', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_grupo.php",{metodo:"ingresaGrupo",parametros:creaParametros()},function(resp_x){
                            if (resp_x.grupo_id){
                                //alert(resp_x.id_artista);
                                $('#hid_grupo').val(resp_x.grupo_id);
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
            //if($('#prms').data('pms_modificar')=='f'){msjAccss();return;}
            jConfirm('Desea Actualizar el Registro actual', 'Confirmación de Proceso', function(rx){
                if(rx){
                    $.post("../modelo/cls_grupo.php",{metodo:"actualizaGrupo",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                        jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                    },"json");
                }else{
                    jAlert('Operación Cancelada', 'Confirmación de Proceso');
                }
            });
        }
    });// fin $('#iconGuardar')
    $('#iconEliminar').click(function(){
        //if($('#prms').data('pms_eliminar')=='f'){msjAccss();return;}
        jConfirm('Se va Eliminar el registro actual', 'Confirmación de Proceso', function(rx){
            if(rx){
                $.post("../modelo/cls_grupo.php",{metodo:"eliminarGrupo",parametros:$('#hid_grupo').val()},function(resp_x){
                    limpiar();
                    jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                },"json");	// Fin $.getJSON.
            }else{
               jAlert('Operación Cancelada', 'Confirmación de Proceso');
            }
        });
    }).hide();// fin $('#iconEliminar')
});// Fin---$(document).ready(function().

function montarDatosGrupo(grupo_id,nombre_grupo,descripcion_grupo){
    limpiar();
    $('#hid_grupo').val(grupo_id);
    $('#txt_nombre_grupo').val(nombre_grupo);
    $('#txt_descripcion_grupo').val(descripcion_grupo);
    $('#iconEliminar').show();
    $('#iconImprimir').show();
    $('#titulo').html('::. Actualizar .::');
}

function limpiar(){
    ocultarIconos();
    $('#hid_artista').val('');
    $('#txt_nombre_grupo').val('');
    $('#txt_descripcion_grupo').val('');
    $('#titulo').html('::. Ingresar .::');
}