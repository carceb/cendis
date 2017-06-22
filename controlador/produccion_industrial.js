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
    $('#iconBuscar').hide();
    $('#iconListar').show();
    llenaCombox('','tipo_artista');
    $('#titulo').html('::. Actualizar .::');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconListar').click(function(){//Visualiza el catalogo de ocupaciones.
        if($('#prms').data('pms_listar')=='f'){msjAccss();return;}
        open_form('produccion_industrial_listar','800','500','','div_form');
    });
    
    $('#iconLimpiar').click(function(){limpiar();});
    
    $('#sel_tipo_artista').change(function(){
        if ($('#sel_tipo_artista').val() != ''){
            var objeto = {
                dependencia:'tipo_artista',
                dependencia_id:$('#sel_tipo_artista').val()};
            llenaCombox('','artista','',objeto);
        }else{
            $('#sel_artista').html('');
        }
    });
    
    $('#sel_artista').change(function(){
        if ($('#sel_artista').val() != ''){
            var objeto = {
                dependencia:'artista',
                dependencia_id:$('#sel_artista').val(),
                dependencia2:'estatus_proyecto',
                dependencia_id2:5};
            llenaCombox('','proyecto','',objeto);
        }else{
            $('#sel_proyecto').html('');
        }
    });
	
    $('#ckb_todos').change(function(){
        if (valorCheck('ckb_todos') == 't'){
            checkAll(document.frm_produccion_industrial.lista_requisito);
        }else{
            uncheckAll(document.frm_produccion_industrial.lista_requisito);
        }
    });
	
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
		proyecto_id:$('#hid_proyecto').val(),
                produccion_industrial_id:$('#hid_produccion_industrial').val(),
                masterizacion:valorCheck('ckb_masterizacion'),
                replicacion:valorCheck('ckb_replicacion'),
                pintado:valorCheck('ckb_pintado')};
        return JSON.stringify(objeto);
    }
    function valida(){
        retorna = true;
	//validar los datos requeridos
	if ($('#hid_proyecto').val() == '')
        {
            jAlert('Debe Seleccionar un proyecto', 'Operación cancelada');
            retorna =false;
        }
	return retorna;
    }
    $('#iconGuardar').click(function(){
        if(!$('#hid_produccion_industrial').val()){
            if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
            if(valida()){
                jConfirm('Desea guardar este Registro', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_produccion_industrial.php",{metodo:"ingresaProduccionIndustrial",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                            if (resp_x.mensaje){
                                $('#hid_produccion_industrial').val(true)
                                $('#titulo').html('::. Actualizar .::');
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
            jConfirm('Desea Actualizar el Registro actual', 'Confirmación de Proceso', function(rx){
                if(rx){
                    $.post("../modelo/cls_produccion_industrial.php",{metodo:"actualizaProduccionIndustrial",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                        jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                    },"json");
                }else{
                    jAlert('Operación Cancelada', 'Confirmación de Proceso');
                }
            });   
        }            
    });
    
    $('#sel_proyecto').change(function(){
        if ($('#sel_proyecto').val() != ''){
            SeleccionarProyecto($('#sel_proyecto').val());
        }else{
            limpiarAlNoEncontrarProyecto();
        }
    });
});// Fin---$(document).ready(function().

function SeleccionarProyecto(proyecto_id){
    var nombre_proyecto,artista_id,tipo_artista_id,masterizacion,replicacion,pintado,
        masterizacion_fecha,replicacion_fecha,pintado_fecha, numero_deposito_legal, numero_produccion, cantidad_copias;
    $.post("../modelo/cls_proyecto.php",{metodo:"DatosProyecto",parametros:proyecto_id},function(resp_x){
        nombre_proyecto = resp_x.nombre_proyecto;
        numero_deposito_legal = resp_x.numero_deposito_legal;
        numero_produccion = resp_x.numero_produccion;
        cantidad_copias = resp_x.cantidad_copias;        
        artista_id = resp_x.artista_id;
        tipo_artista_id = resp_x.tipo_artista_id;
        montarDatosProduccionIndustrial(proyecto_id,nombre_proyecto,artista_id,tipo_artista_id, numero_deposito_legal, numero_produccion, cantidad_copias);
    },"json");//
    
    $.post("../modelo/cls_produccion_industrial.php",{metodo:"SeleccionarProyecto",parametros:proyecto_id},function(resp_x){
        if(resp_x){
            $('#hid_produccion_industrial').val(true);
            masterizacion = resp_x.masterizacion;
            replicacion = resp_x.replicacion;
            pintado = resp_x.pintado;
            masterizacion_fecha = resp_x.masterizacion_fecha;
            replicacion_fecha = resp_x.replicacion_fecha;
            pintado_fecha = resp_x.pintado_fecha;
        }
        montarDatosProduccionIndustrialDetalle(masterizacion,replicacion,pintado,masterizacion_fecha,replicacion_fecha,pintado_fecha);
    },"json");//
}

function montarDatosProduccionIndustrial(proyecto_id,nombre_proyecto,artista_id,tipo_artista_id, numero_deposito_legal, numero_produccion, cantidad_copias){
    limpiar();
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

function montarDatosProduccionIndustrialDetalle(masterizacion,replicacion,pintado, masterizacion_fecha,replicacion_fecha,pintado_fecha){
    if (masterizacion == 't') {
        checkar('ckb_masterizacion');
        $('#masterizacion_fecha').html(masterizacion_fecha);
    }
    if (replicacion == 't'){
        checkar('ckb_replicacion');{}
        $('#replicacion_fecha').html(replicacion_fecha);
    }
    if (pintado == 't') {
        checkar('ckb_pintado');
        $('#pintado_fecha').html(pintado_fecha);
    }
}

function limpiar(){
    ocultarIconos();
    $('#iconListar').show();
    $('.label_fecha').html('');
    $('#hid_proyecto').val('');
    $('#hid_produccion_industrial').val('');
    $('#sel_tipo_artista').val('');
    $('#sel_proyecto').html('');
    $('#sel_artista').html('');
    $('#lbl_nombre_proyecto').html('');
    $('#lbl_numero_deposito_legal').html('');
    $('#lbl_numero_produccion').html('');
    $('#lbl_numero_copias').html('');
    uncheckAll(document.frm_produccion_industrial.lista_requisito);
    $('#titulo').html('::. Ingresar .::');
}
function limpiarAlNoEncontrarProyecto(){
    $('#hid_produccion_industrial').val('');
    uncheckAll(document.frm_produccion_industrial.lista_requisito);
    $('#titulo').html('::. Ingresar .::');
}

