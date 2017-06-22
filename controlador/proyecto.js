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
$(document).ready(function(){ 
    AcceVent();
    ocultarIconos();
    llenaCombox('','tipo_artista');
    llenaCombox('','tipo_proyecto');
    llenaCombox('','genero_musical');
    llenaCombox('','tipo_formato');
    $('#titulo').html('Registro Datos del Proyecto');
    $('#txt_fecha_proyecto').datepicker({changeMonth: true,changeYear: true});//Calendario
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
        if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('proyecto_catalogo','410','400','','div_form');
    });
    
    $('#iconLimpiar').click(function(){limpiar();});
    
    $('#sel_tipo_artista').change(function(){
        var objeto = {
            dependencia:'tipo_artista',
            dependencia_id:$('#sel_tipo_artista').val()};
            llenaCombox('','artista','',objeto);
    });
    
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        //alert(valorCheck('ckb_carta_solicitud'));
        var objeto = {
		proyecto_id:$('#hid_proyecto').val(),
		artista_id:$('#sel_artista').val(),
		tipo_proyecto_id:$('#sel_tipo_proyecto').val(),
		genero_musical_id:$('#sel_genero_musical').val(),
		nombre_proyecto:$('#txt_nombre_proyecto').val(),
		fecha_proyecto:$('#txt_fecha_proyecto').val(),
		carta_solicitud:valorCheck('ckb_carta_solicitud'),//valorCheck('')
		dossier:valorCheck('ckb_dossier'),
		canciones_proyecto:valorCheck('ckb_canciones_proyecto'),
        tipo_formato_id:$('#sel_tipo_formato').val()};
        return JSON.stringify(objeto);
    }
    function valida(){
		//validar los datos requeridos
		if ($('#sel_tipo_artista').val() == ''){
            jAlert('Debe ingresar el tipo de artista', 'Operación cancelada');
            return false;
        }
		
		if ($('#sel_artista').val() == ''){
            jAlert('Debe ingresar el artista', 'Operación cancelada');
            return false;
        }
		
		if ($('#sel_tipo_proyecto').val() == ''){
            jAlert('Debe ingresar el tipo de proyecto', 'Operación cancelada');
            return false;
		}
		
		if ($('#sel_genero_musical').val() == ''){
            jAlert('Debe ingresar el genero musical', 'Operación cancelada');
            return false;
        }
		
		if ($('#txt_nombre_proyecto').val() == ''){
            jAlert('Debe ingresar el nombre del proyecto', 'Operación cancelada');
            retorna =false;
        }
		
		if ($('#txt_fecha_proyecto').val() == ''){
			jAlert('Debe ingresar la Fecha.', 'Operación cancelada');
			return false;
        }else{
			if(!isDate($('#txt_fecha_proyecto').val())){
				jAlert('Debe ingresar la Fecha valida.', 'Operación cancelada');
                return false;
			}
		}
		
		if ($('#sel_tipo_formato').val() == ''){
            jAlert('Debe seleccionar un Tipo Formato', 'Operación cancelada');
            return false;
		}	
		return true;
    }
    $('#iconGuardar').click(function(){
         if(!$('#hid_proyecto').val()){
             if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
             if(valida()){
                jConfirm('¿Desea guardar este Registro?', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_proyecto.php",{metodo:"ingresaProyecto",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                           if (resp_x.proyecto_id){
                                $('#hid_proyecto').val(resp_x.proyecto_id);
                                $('#iconEliminar').show();
                                $('#iconImprimir').show();
                                
                           }
						   jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                        },"json");//
                    }else{
                        jAlert('Operación Cancelada', 'Confirmación de Proceso');
                    }
                });
             }
         }else{
             if($('#prms').data('pms_modificar')=='f'){msjAccss();return;}
             jConfirm('¿Desea Actualizar el Registro actual?', 'Confirmación de Proceso', function(rx){
                if(rx){
                    $.post("../modelo/cls_proyecto.php",{metodo:"actualizaProyecto",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                        //$('#txt_nombre_proyecto').val($('#txt_nombre_proyecto').val().toUpperCase());
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
                $.post("../modelo/cls_proyecto.php",{metodo:"eliminarProyecto",parametros:$('#hid_proyecto').val()},function(resp_x){
                    limpiar();
                    jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                },"json");	// Fin $.getJSON.
            }else{
               jAlert('Operación Cancelada', 'Confirmación de Proceso');
            }
        });
    }).hide();// fin $('#iconEliminar')
});// Fin---$(document).ready(function().

function montarDatosProyecto(proyecto_id, tipo_artista_id, artista_id, tipo_proyecto_id, genero_musical_id, nombre_proyecto, fecha_proyecto, carta_solicitud, canciones_proyecto, dossier, tipo_formato_id,nombre_estatus_proyecto, nombre_siguiente_estatus_proyecto){
    limpiar();
    $('#sel_tipo_artista').val(tipo_artista_id);
    var objeto = {
        dependencia:'tipo_artista',
        dependencia_id:tipo_artista_id};
    llenaCombox('','artista',artista_id,objeto);
    $('#hid_proyecto').val(proyecto_id);
    $('#sel_tipo_proyecto').val(tipo_proyecto_id);
    $('#sel_genero_musical').val(genero_musical_id);
    $('#txt_nombre_proyecto').val(nombre_proyecto);
    $('#txt_fecha_proyecto').val(fecha_proyecto);
    $('#sel_tipo_formato').val(tipo_formato_id);
    $('#lbl_estatus_proyecto').html('Estatus Actual: ' + nombre_estatus_proyecto);
    $('#lbl_siguiente_estatus_proyecto').html('Próximo Paso: ' + nombre_siguiente_estatus_proyecto);
    $.post("../modelo/cls_proyecto.php",{metodo:"cantidadEntregadaEnDistribucionFinalizada",parametros:$('#hid_proyecto').val()},function(resp_x){
            if(resp_x.total_distribuido != '')
                $('#lbl_cantidad_entregada').html('[Cantidad asignada al artista: ' + formateaMonto(resp_x.total_distribuido,'') +']');
        
    },"json");    
    if (carta_solicitud == 't') checkar('ckb_carta_solicitud');
    if (dossier == 't') checkar('ckb_dossier');
    if (canciones_proyecto == 't') checkar('ckb_canciones_proyecto');
    $('#iconEliminar').show();
    $('#iconImprimir').show();
}

function limpiar(){
    ocultarIconos();
    $('#sel_tipo_artista').val('');
    $('#sel_artista').html('');
    $('#hid_proyecto').val('');
    $('#sel_tipo_proyecto').val('');
    $('#sel_genero_musical').val('');
    $('#txt_nombre_proyecto').val('');
    $('#txt_fecha_proyecto').val('');
    $('#sel_tipo_formato').val('');
    $('#lbl_estatus_proyecto').html('');
    $('#lbl_siguiente_estatus_proyecto').html('')
    $('#lbl_cantidad_entregada').html('')
    desChecked('ckb_carta_solicitud');
    desChecked('ckb_dossier');
    desChecked('ckb_canciones_proyecto');
}

