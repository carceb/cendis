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
    $('#titulo').html('Fases del Proceso de Diseño');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
       if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('catalogo_catalogo','410','400','','div_form');
    });
    
    $('#iconListar').click(function(){//Visualiza el catalogo de ocupaciones.
       if($('#prms').data('pms_listar')=='f'){msjAccss();return;}
        open_form('diseno_listar','800','500','','div_form');
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
                dependencia_id2:4};
            llenaCombox('','proyecto','',objeto);
        }else{
            $('#sel_proyecto').html('');
        }
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
            checkAll(document.frm_diseno.lista_requisito);
        }else{
            uncheckAll(document.frm_diseno.lista_requisito);
        }
    });
    
    //FUNCIONES
    function creaParametros(){
        //Retorna los parórametros en notación JSON.
        var objeto = {proyecto_id:$('#hid_proyecto').val(),
            diseno_id:$('#hid_diseno').val(),
            tipo_proyecto_id:$('#hid_tipo_proyecto').val(),
            recibido:valorCheck('ckb_recibido'),
            en_proceso:valorCheck('ckb_en_proceso'),
            diseno_aprobado:valorCheck('ckb_diseno_aprobado'),
            en_fotolito:valorCheck('ckb_fotolito'),
            enviado_imprenta:valorCheck('ckb_enviado_imprenta'),
            fecha_sistema_estatus_diseno:fechaActual()};
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
        if(!$('#hid_diseno').val()){
            if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
            if(valida()){
                jConfirm('¿Desea guardar este Registro?', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_diseno.php",{metodo:"ingresaDiseno",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                            if (resp_x.mensaje){
                                $('#hid_diseno').val(true);
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
                    $.post("../modelo/cls_diseno.php",{metodo:"actualizaDiseno",parametros:creaParametros()},function(resp_x){//alert(resp_x);
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
    var nombre_proyecto,artista_id,tipo_artista_id,tipo_proyecto_id,recibido='f',recibido_fecha='',en_proceso='f',en_proceso_fecha='',
    diseno_aprobado='f',diseno_aprobado_fecha='',en_fotolito='f',en_fotolito_fecha='',enviado_imprenta='f',enviado_imprenta_fecha='', numero_deposito_legal ='', numero_produccion='', cantidad_copias='';
    
    $.post("../modelo/cls_proyecto.php",{metodo:"DatosProyecto",parametros:proyecto_id},function(resp_x){
        proyecto_id = resp_x.proyecto_id;
        nombre_proyecto = resp_x.nombre_proyecto;
        numero_deposito_legal = resp_x.numero_deposito_legal;
        numero_produccion = resp_x.numero_produccion;
        cantidad_copias = resp_x.cantidad_copias;
        artista_id = resp_x.artista_id;
        tipo_artista_id = resp_x.tipo_artista_id;
        tipo_proyecto_id = resp_x.tipo_proyecto_id
        montarDatosDiseno(proyecto_id,nombre_proyecto,artista_id,tipo_artista_id,tipo_proyecto_id, numero_deposito_legal, numero_produccion, cantidad_copias);
    },"json");//
    
    $.post("../modelo/cls_diseno.php",{metodo:"SeleccionarProyecto",parametros:proyecto_id},function(resp_x){
        if(resp_x){
            $('#hid_diseno').val(true);
            recibido = resp_x.recibido;
            recibido_fecha = resp_x.recibido_fecha;
            en_proceso = resp_x.en_proceso;
            en_proceso_fecha = resp_x.en_proceso_fecha;
            diseno_aprobado = resp_x.diseno_aprobado;
            diseno_aprobado_fecha = resp_x.diseno_aprobado_fecha;
            en_fotolito = resp_x.en_fotolito;
            en_fotolito_fecha = resp_x.en_fotolito_fecha;
            enviado_imprenta = resp_x.enviado_imprenta;
            enviado_imprenta_fecha = resp_x.enviado_imprenta_fecha;
        }
        montarDatosDisenoDetalle(recibido,recibido_fecha,en_proceso,en_proceso_fecha,diseno_aprobado,
            diseno_aprobado_fecha,en_fotolito,en_fotolito_fecha,enviado_imprenta,enviado_imprenta_fecha);
    },"json");//
}

function montarDatosDiseno(proyecto_id,nombre_proyecto, artista_id,tipo_artista_id,tipo_proyecto_id, numero_deposito_legal, numero_produccion, cantidad_copias){
    $('#hid_proyecto').val(proyecto_id);
    $('#hid_tipo_proyecto').val(tipo_proyecto_id);
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

function montarDatosDisenoDetalle(recibido,recibido_fecha,en_proceso,en_proceso_fecha,
        diseno_aprobado,diseno_aprobado_fecha,en_fotolito,en_fotolito_fecha,enviado_imprenta,
        enviado_imprenta_fecha){
    if (recibido == 't'){
        checkar('ckb_recibido');
        $('#recibido_fecha').html(recibido_fecha);
    }
    if (en_proceso == 't'){
        checkar('ckb_en_proceso');
        $('#en_proceso_fecha').html(en_proceso_fecha);
    }
    if (diseno_aprobado == 't'){
        checkar('ckb_diseno_aprobado');
        $('#diseno_aprobado_fecha').html(diseno_aprobado_fecha);
    }
    if (en_fotolito == 't'){
        checkar('ckb_fotolito');
        $('#en_fotolito_fecha').html(en_fotolito_fecha);
    }
    if (enviado_imprenta == 't'){
        checkar('ckb_enviado_imprenta');
        $('#enviado_imprenta_fecha').html(enviado_imprenta_fecha);
    }
}

function limpiar(){
    ocultarIconos();
    $('#iconListar').show();
    $('.label_fecha').html('');
    $('#hid_proyecto').val('');
    $('#hid_diseno').val('');
    $('#sel_tipo_artista').val('');
    $('#sel_proyecto').html('');
    $('#sel_artista').html('');
    $('#lbl_nombre_proyecto').html('');
    $('#lbl_numero_deposito_legal').html('');
    $('#lbl_numero_produccion').html('');
    $('#lbl_numero_copias').html('');
    desChecked('ckb_todos');
    uncheckAll(document.frm_diseno.lista_requisito);
}
function limpiarAlNoEncontrarProyecto(){
    $('#hid_diseno').val('');
    $('.label_fecha').html('');
    desChecked('ckb_todos');
    uncheckAll(document.frm_diseno.lista_requisito);
}
