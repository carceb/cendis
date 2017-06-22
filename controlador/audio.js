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
    $('.Replicacion').hide();
    $('.Grabacion').hide();
    $('#iconBuscar').hide();
    $('#iconListar').show();
    $('#titulo').html('Fases del Proceso de Audio');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
       if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('audio_catalogo','410','400','','div_form');
    });
    
    $('#iconListar').click(function(){//Visualiza el catalogo de ocupaciones.
       if($('#prms').data('pms_listar')=='f'){msjAccss();return;}
        open_form('audio_listar','800','500','','div_form');
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
			dependencia_id2:4};
        llenaCombox('','proyecto','',objeto);
    });
    
    $('#sel_proyecto').change(function(){
         if ($('#sel_proyecto').val() != ''){
            SeleccionarProyecto($('#sel_proyecto').val());
         }else{
             limpiarAlNoEncontrarProyecto();
         }
    });
    
    $('#ckb_todos').change(function(){
	if (valorCheck('ckb_todos') == 't'){
            checkAll(document.frm_audio.lista_audio);
        }else{
            uncheckAll(document.frm_audio.lista_audio);
        }
    });
    
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            proyecto_id:$('#hid_proyecto').val(),
            audio_id:$('#audio_id').val(),
            tipo_proyecto_id:$('#hid_tipo_proyecto').val(),
            revision_tecnica_replicacion:valorCheck('ckb_revision_tecnica_replicacion'),
            ddp_replicacion:valorCheck('ckb_ddp_replicacion'),
            envio_fabrica_replicacion:valorCheck('ckb_envio_fabrica_replicacion'),
            reunion_produccion_grabacion:valorCheck('ckb_reunion_produccion_grabacion'),
            grabacion_grabacion:valorCheck('ckb_grabacion_grabacion'),
            post_produccion_grabacion:valorCheck('ckb_post_produccion_grabacion'),
            envio_fabrica_grabacion:valorCheck('ckb_envio_fabrica_grabacion'),
            fecha_sistema_estatus_audio:fechaActual()};
        return JSON.stringify(objeto);
    }
    function valida(){
		if ($('#hid_proyecto').val() == ''){
			jAlert('Debe Seleccionar un proyecto', 'Operación cancelada');
			return false;
		}
		return true;
    }
    $('#iconGuardar').click(function(){
        if(!$('#hid_audio').val()){
            if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
            if(valida()){
                jConfirm('¿Desea guardar este Registro?', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_audio.php",{metodo:"ingresaAudio",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                            if (resp_x.mensaje){
                                $('#hid_audio').val(true)
                                $('#iconImprimir').show();
                                jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                            }else{
                                jAlert('No se Actualizo el Registro', 'Confirmación de Proceso');
                            }
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
                    $.post("../modelo/cls_audio.php",{metodo:"actualizaAudio",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                        jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                    },"json");
                }else{
                    jAlert('Operación Cancelada', 'Confirmación de Proceso');
                }
            }); 
        }   
    });
});// Fin---$(document).ready(function().

function SeleccionarProyecto(proyecto_id){
    var nombre_proyecto,artista_id,tipo_artista_id,tipo_proyecto_id,revision_tecnica_replicacion = 'f',revision_tecnica_replicacion_fecha = '',
    ddp_replicacion = 'f',ddp_replicacion_fecha = '',envio_fabrica_replicacion = 'f',envio_fabrica_replicacion_fecha = '',
    reunion_produccion_grabacion = 'f',reunion_produccion_grabacion_fecha = '',grabacion_grabacion = 'f',grabacion_grabacion_fecha = '',
    post_produccion_grabacion = 'f',post_produccion_grabacion_fecha = '',envio_fabrica_grabacion = 'f',envio_fabrica_grabacion_fecha = '', numero_deposito_legal ='', numero_produccion='', cantidad_copias='';
    
    $.post("../modelo/cls_proyecto.php",{metodo:"DatosProyecto",parametros:proyecto_id},function(resp_x){
        proyecto_id = resp_x.proyecto_id;
        nombre_proyecto = resp_x.nombre_proyecto;
        numero_deposito_legal = resp_x.numero_deposito_legal;
        numero_produccion = resp_x.numero_produccion;
        cantidad_copias = resp_x.cantidad_copias;        
        artista_id = resp_x.artista_id;
        tipo_artista_id = resp_x.tipo_artista_id;
        tipo_proyecto_id = resp_x.tipo_proyecto_id;
        montarDatosAudio(proyecto_id,nombre_proyecto,artista_id,tipo_artista_id, numero_deposito_legal, numero_produccion, cantidad_copias);
    },"json");//
        
    $.post("../modelo/cls_audio.php",{metodo:"SeleccionarProyecto",parametros:proyecto_id},function(resp_x){
        if(resp_x){
            $('#hid_audio').val(true);
            revision_tecnica_replicacion = resp_x.revision_tecnica_replicacion;
            revision_tecnica_replicacion_fecha = resp_x.revision_tecnica_replicacion_fecha;
            ddp_replicacion = resp_x.ddp_replicacion;
            ddp_replicacion_fecha = resp_x.ddp_replicacion_fecha;
            envio_fabrica_replicacion = resp_x.envio_fabrica_replicacion;
            envio_fabrica_replicacion_fecha = resp_x.envio_fabrica_replicacion_fecha;
            reunion_produccion_grabacion = resp_x.reunion_produccion_grabacion;
            reunion_produccion_grabacion_fecha = resp_x.reunion_produccion_grabacion_fecha;
            grabacion_grabacion = resp_x.grabacion_grabacion;
            grabacion_grabacion_fecha = resp_x.grabacion_grabacion_fecha;
            post_produccion_grabacion = resp_x.post_produccion_grabacion;
            post_produccion_grabacion_fecha = resp_x.post_produccion_grabacion_fecha;
            envio_fabrica_grabacion = resp_x.envio_fabrica_grabacion;
            envio_fabrica_grabacion_fecha = resp_x.envio_fabrica_grabacion_fecha;
        }
        montarDatosAudioDetalle(tipo_proyecto_id,revision_tecnica_replicacion,revision_tecnica_replicacion_fecha,ddp_replicacion,ddp_replicacion_fecha,
        envio_fabrica_replicacion,envio_fabrica_replicacion_fecha,reunion_produccion_grabacion,reunion_produccion_grabacion_fecha,
        grabacion_grabacion,grabacion_grabacion_fecha,post_produccion_grabacion,post_produccion_grabacion_fecha,envio_fabrica_grabacion,envio_fabrica_grabacion_fecha);
    },"json");//
        
}

function montarDatosAudio(proyecto_id,nombre_proyecto,artista_id,tipo_artista_id, numero_deposito_legal, numero_produccion, cantidad_copias){
    //limpiar();
    $('#hid_proyecto').val(proyecto_id);
    $('#lbl_nombre_proyecto').html(nombre_proyecto);
    $('#lbl_numero_deposito_legal').html(numero_deposito_legal);
    $('#lbl_numero_produccion').html( numero_produccion);
    $('#lbl_numero_copias').html(cantidad_copias);
    $('#sel_tipo_artista').val(tipo_artista_id);
    var objeto = {
        dependencia:'tipo_artista',
        dependencia_id:tipo_artista_id};
    llenaCombox('','artista',artista_id,objeto);
    objeto = {
        dependencia:'artista',
        dependencia_id:artista_id};
    llenaCombox('','proyecto',proyecto_id,objeto);
}

function montarDatosAudioDetalle(
                tipo_proyecto_id,
                revision_tecnica_replicacion,
                revision_tecnica_replicacion_fecha,
                ddp_replicacion,
                ddp_replicacion_fecha,
                envio_fabrica_replicacion,
                envio_fabrica_replicacion_fecha,
                reunion_produccion_grabacion,
                reunion_produccion_grabacion_fecha,
                grabacion_grabacion,
                grabacion_grabacion_fecha,
                post_produccion_grabacion,
                post_produccion_grabacion_fecha,
                envio_fabrica_grabacion,
                envio_fabrica_grabacion_fecha){
    
    $('#hid_tipo_proyecto').val(tipo_proyecto_id);
    if (tipo_proyecto_id == 1)
        $('.Replicacion').show();
    else
        $('.Grabacion').show();
    if (revision_tecnica_replicacion == 't'){
        checkar('ckb_revision_tecnica_replicacion');
        $('#revision_tecnica_replicacion_fecha').html(revision_tecnica_replicacion_fecha);
    }
    if (ddp_replicacion == 't'){
        checkar('ckb_ddp_replicacion');
        $('#ddp_replicacion_fecha').html(ddp_replicacion_fecha);
    }
    if (envio_fabrica_replicacion == 't'){
        checkar('ckb_envio_fabrica_replicacion');
        $('#envio_fabrica_replicacion_fecha').html(envio_fabrica_replicacion_fecha);
    }
    if (reunion_produccion_grabacion == 't'){
        checkar('ckb_reunion_produccion_grabacion');
        $('#reunion_produccion_grabacion_fecha').html(reunion_produccion_grabacion_fecha);
    }
    if (grabacion_grabacion == 't'){
        checkar('ckb_grabacion_grabacion');
        $('#grabacion_grabacion_fecha').html(grabacion_grabacion_fecha);
    }
    if (post_produccion_grabacion == 't'){
        checkar('ckb_post_produccion_grabacion');
        $('#post_produccion_grabacion_fecha').html(post_produccion_grabacion_fecha);
    }
    if (envio_fabrica_grabacion == 't'){
        checkar('ckb_envio_fabrica_grabacion');
        $('#envio_fabrica_grabacion_fecha').html(envio_fabrica_grabacion_fecha);
    }
}

function limpiar(){
    ocultarIconos();
    $('#iconListar').show();
    $('.label_fecha').html('');
    $('#hid_proyecto').val('');
    $('#hid_audio').val('');
    $('#sel_tipo_artista').val('');
    $('#sel_proyecto').html('');
    $('#sel_artista').html('');
    $('#lbl_nombre_proyecto').html('');
    $('#lbl_numero_deposito_legal').html('');
    $('#lbl_numero_produccion').html('');
    $('#lbl_numero_copias').html('');
    $('.Replicacion').hide();
    $('.Grabacion').hide();
    desChecked('ckb_todos');
    uncheckAll(document.frm_audio.lista_audio);
}
function limpiarAlNoEncontrarProyecto(){
    $('#hid_audio').val('');
    $('.label_fecha').html('');
    desChecked('ckb_todos');
    uncheckAll(document.frm_audio.lista_audio);
    $('.Replicacion').hide();
    $('.Grabacion').hide();
}

function TipoProyecto(proyecto_id){
    $.post("../modelo/cls_audio.php",{metodo:"TipoProyecto",parametros:proyecto_id},function(resp_x){
        $('#hid_tipo_proyecto').val(resp_x);
        if (resp_x == 1)
            $('.Replicacion').show();
        else
            $('.Grabacion').show();
    },"json");
}

