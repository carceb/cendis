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
    llenaCombox('','tipo_artista');
    llenaCombox('','genero_musical');
    $('.fila_temas').remove();
    $('#titulo').html('Asignar Créditos Adicionales a la Producción Musical');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconLimpiar').click(function(){limpiar();});
    
    $('#sel_tipo_artista').change(function(){
        var objeto = {
            dependencia:'tipo_artista',
            dependencia_id:$('#sel_tipo_artista').val()};
        llenaCombox('','artista','',objeto);
        $('#sel_proyecto').html('');
    });
    
    $('#sel_artista').change(function(){
        var objeto = {
            dependencia:'artista',
            dependencia_id:$('#sel_artista').val(),
	    dependencia2:'estatus_proyecto',
            dependencia_id2:3};
        llenaCombox('','proyecto','',objeto);
    });
    
    $('#sel_proyecto').change(function(){
        if ($('#sel_proyecto').val() != ''){
            $.post("../modelo/cls_credito.php",{metodo:"SeleccionarProyecto",parametros:$('#sel_proyecto').val()},function(resp_x){
                limpiarAlNoEncontrarCreditos();
                if(resp_x){
                    $('#hid_proyecto').val(resp_x.proyecto_id);
                    $('#hid_credito').val(resp_x.credito_id);
                    $('#lbl_nombre_proyecto').html(resp_x.nombre_proyecto);                    
                    montarDatosCredito(resp_x.productor_musical, resp_x.productor_ejecutivo, resp_x.arreglista, resp_x.ing_grabacion, resp_x.ing_mezcla, resp_x.ing_masterizacion, resp_x.otros, resp_x.credito_interpretes);                                                            
                }else{
                    limpiarAlNoEncontrarCreditos();
                    $('#hid_proyecto').val($('#sel_proyecto').val());
                    $('#lbl_nombre_proyecto').html(capturaNombreOpcion('sel_proyecto',$('#sel_proyecto').val()));                    
                }
             }
             ,"json");//
        }
        else
        {
            limpiar();
        }
    });
    
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            proyecto_id:$('#hid_proyecto').val(),
            credito_id:$('#hid_credito').val(),
            productor_musical:$('#txt_productor_musical').val(),
            productor_ejecutivo:$('#txt_productor_ejecutivo').val(),
            arreglista:$('#txt_arreglista').val(),
            ing_grabacion:$('#txt_ing_grabacion').val(),
            ing_mezcla:$('#txt_ing_mezcla').val(),
            ing_masterizacion:$('#txt_ing_masterizacion').val(),
            otros:$('#txt_otros').val(),
            credito_interpretes:$('#txt_credito_interpretes').val()};
        return JSON.stringify(objeto);
    }
    
    function validaIngreso(){
        retorna = true;
	//validar los datos requeridos
        
        if ($('#txt_productor_musical').val() == '')
        {
            jAlert('Debe ingresar el nombre de productor musical.', 'Operación cancelada');
            retorna =false;
        }
        if ($('#txt_productor_ejecutivo').val() == '')
        {
            jAlert('Debe ingresar el nombre de productor ejecutivo.', 'Operación cancelada');
            retorna =false;
        }        
	if ($('#hid_proyecto').val() == '')
        {
            jAlert('Debe Seleccionar un proyecto', 'Operación cancelada');
            retorna =false;
        }
	return retorna;
    }
    $('#iconGuardar').click(function(){
        if(!$('#hid_credito').val()){
            if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
            if(validaIngreso()){
                jConfirm('Desea guardar este Registro', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_credito.php",{metodo:"ingresaCredito",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                            $('#hid_credito').val(resp_x.credito_id),
                            jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                        },"json");
                    }else{
                        jAlert('Operación Cancelada', 'Confirmación de Proceso');
                    }
                });
            }
        }else{
            if($('#prms').data('pms_modificar')=='f'){msjAccss();return;}
            if(validaIngreso()){
                jConfirm('Desea Actualizar el Registro actual', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_credito.php",{metodo:"actualizaCredito",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                            jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                        },"json");
                    }else{
                        jAlert('Operación Cancelada', 'Confirmación de Proceso');
                    }
                });
             }
        }
    });// fin $('#iconGuardar')
    $('#iconEliminar').click(function(){
        if($('#prms').data('pms_eliminar')=='f'){msjAccss();return;}
        jConfirm('Se va Eliminar el registro actual', 'Confirmación de Proceso', function(rx){
            if(rx){
                $.post("../modelo/cls_credito.php",{metodo:"eliminarCredito",parametros:$('#hid_credito').val()},function(resp_x){
                    limpiar();
                    jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                },"json");	// Fin $.getJSON.
            }else{
               jAlert('Operación Cancelada', 'Confirmación de Proceso');
            }
        });
    }).hide();// fin $('#iconEliminar')
});// Fin---$(document).ready(function().

function montarDatosCredito(productor_musical,productor_ejecutivo,arreglista,ing_grabacion,ing_mezcla,ing_masterizacion,otros,credito_interpretes){
    $('#txt_productor_musical').val(productor_musical);
    $('#txt_productor_ejecutivo').val(productor_ejecutivo);
    $('#txt_arreglista').val(arreglista);
    $('#txt_ing_grabacion').val(ing_grabacion);
    $('#txt_ing_mezcla').val(ing_mezcla);
    $('#txt_ing_masterizacion').val(ing_masterizacion);
    $('#txt_otros').val(remplaceEnter(otros));
    $('#txt_credito_interpretes').val(remplaceEnter(credito_interpretes));
    $('#iconEliminar').show();
    $('#iconImprimir').show();
}

function limpiar(){
    ocultarIconos();
    $('#sel_tipo_artista').val('');
    $('#sel_artista').html('');
    $('#sel_proyecto').html('');
    $('#hid_proyecto').val('');
    $('#hid_credito').val('');
    $('#lbl_nombre_proyecto').html('')
    $('#txt_productor_musical').val('');
    $('#txt_productor_ejecutivo').val('');
    $('#txt_arreglista').val('');
    $('#txt_ing_grabacion').val('');
    $('#txt_ing_mezcla').val('');
    $('#txt_ing_masterizacion').val('');
    $('#txt_otros').val('');
    $('#txt_credito_interpretes').val('');
}
function limpiarAlNoEncontrarCreditos(){
    $('#hid_credito').val('');
    $('#txt_productor_musical').val('');
    $('#txt_productor_ejecutivo').val('');
    $('#txt_arreglista').val('');
    $('#txt_ing_grabacion').val('');
    $('#txt_ing_mezcla').val('');
    $('#txt_ing_masterizacion').val('');
    $('#txt_otros').val('');
    $('#txt_credito_interpretes').val('');
}