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
    //AcceVent();
    ocultarIconos();
    llenaCombox('','tipo_artista');
    llenaCombox('','tipo_estuche');
    $('#txt_numero_deposito_legal').attr('disabled','disabled');
    $('#iconListar').show();
	$('#iconQR').hide();
    $('#titulo').html('Catalogo de Documentos Consignados');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
       if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('catalogo_catalogo','410','400','','div_form');
    });
    
    $('#iconListar').click(function(){//Visualiza el catalogo de ocupaciones.
       if($('#prms').data('pms_listar')=='f'){msjAccss();return;}
        open_form('catalogo_listar','800','500','','div_form');
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
            SeleccionarProyecto($('#sel_proyecto').val());
        }else{
            limpiarAlNoEncontrarProyecto();
        }
    });
    
    $('#ckb_todos').change(function(){
        if (valorCheck('ckb_todos') == 't'){
            $('#txt_numero_deposito_legal').attr('disabled','');
            checkAll(document.frm_catalogo.lista_requisito);
        }else{
            $('#txt_numero_deposito_legal').attr('disabled','disabled');
            uncheckAll(document.frm_catalogo.lista_requisito);
        }
    });
	
    $('#ckb_deposito_legal').change(function(){
        if (valorCheck('ckb_deposito_legal') == 't'){
            $('#txt_numero_deposito_legal').attr('disabled','');
        }else{
            $('#txt_numero_deposito_legal').attr('disabled','disabled');
            $('#txt_numero_deposito_legal').val('');
        }
    });
    
    $('#iconQR').click(function(){//Visualiza el catalogo de ocupaciones.
	   	var qr_proyecto = $('#h_qr_proyecto').val();
        open_form('qr_generador','164','164',{"qr_proyecto":qr_proyecto},'div_form');
    });
	
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        //alert(valorCheck('ckb_carta_solicitud'));
        var objeto = {
            proyecto_id:$('#hid_proyecto').val(),
            direccion:valorCheck('ckb_direccion'),
            carta_compromiso_autoria:valorCheck('ckb_carta_compromiso_autoria'),
            carta_buena_fe:valorCheck('ckb_carta_buena_fe'),
            deposito_legal:valorCheck('ckb_deposito_legal'),
            representante_legal:valorCheck('ckb_representante_legal'),
            acta_constitutiva:valorCheck('ckb_acta_constitutiva'),
            copia_rif:valorCheck('ckb_copia_rif'),
            copia_cedula:valorCheck('ckb_copia_cedula'),
            letras:valorCheck('ckb_letras'),
            listado_interprete:valorCheck('ckb_listado_interprete'),
            autorizacion_replica:valorCheck('ckb_autorizacion_replica'),
            exoneracion_derecho:valorCheck('ckb_exoneracion_derecho'),
            nombre_definitivo:valorCheck('ckb_nombre_definitivo'),
            master_produccion:valorCheck('ckb_master_produccion'),
            fotografias:valorCheck('ckb_fotografias'),
            numero_deposito_legal:$('#txt_numero_deposito_legal').val(),
            fecha_sistema_requisito_proyecto:fechaActual(),
            numero_produccion:$('#txt_numero_produccion').val(),
            tipo_estuche_id:$('#sel_tipo_estuche').val()};
        return JSON.stringify(objeto);
    }
    function valida(){

        retorna = true;
	//validar los datos requeridos
	if ($('#hid_proyecto').val() == '')
        {
            jAlert('Debe Seleccionar un proyecto.', 'Operación cancelada');
            retorna =false;
        }
        
        if ($('#txt_numero_deposito_legal').val() == '')
        {
            jAlert('Debe ingresar el Nº de deposito legal', 'Operación cancelada');
            return false;
        }
        if ($('#txt_numero_produccion').val() == '')
        {
            jAlert('Debe ingresar el Nº de producción.', 'Operación cancelada');
            return false;
        }
        if ($('#sel_tipo_estuche').val() == '')
        {
            jAlert('Debe ingresar el Tipo de Estuche.', 'Operación cancelada');
            return false;
        }
        if (numeroDepositoLegalValido() == false){
            return false;
        }
	return retorna;
    }
    
    function numeroDepositoLegalValido(){
        retorna = true;
        $.post("../modelo/cls_catalogo.php",{metodo:"depositoLegalValido",parametros:creaParametros()},function(resp_x)
        {
            if (resp_x.resultado == false)
            {                             
                jAlert("El número de deposito legal está registrado al proyecto: " + resp_x.proyecto, 'Operación cancelada');
                retorna = false;
            }
            else
            {
                retorna = true
            }

         },"json");
         
         return retorna;
    }
    
    $('#iconGuardar').click(function(){
        if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
        if(valida()){
            jConfirm('¿Desea guardar este Registro?', 'Confirmación de Proceso', function(rx){
                if(rx){
                    $.post("../modelo/cls_catalogo.php",{metodo:"actualizaCatalogo",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                    if (resp_x.mensaje){                             
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
    });
});// Fin---$(document).ready(function().

function SeleccionarProyecto(proyecto_id){
    $.post("../modelo/cls_catalogo.php",{metodo:"cargaGrilla",parametros:proyecto_id},function(resp_x){
        limpiar();//vacia el formulario por si el valor del select esta vacio o "--seleccione--"
        if(resp_x){
            montarDatosCatalogo(resp_x.proyecto_id,
            resp_x.nombre_proyecto,
            resp_x.artista_id,
            resp_x.tipo_artista_id,
            resp_x.numero_deposito_legal,
            resp_x.direccion,
            resp_x.direccion_fecha,
            resp_x.carta_compromiso_autoria,
            resp_x.carta_compromiso_autoria_fecha,
            resp_x.carta_buena_fe,
            resp_x.carta_buena_fe_fecha,
            resp_x.deposito_legal,
            resp_x.deposito_legal_fecha,
            resp_x.representante_legal,
            resp_x.representante_legal_fecha,
            resp_x.acta_constitutiva,
            resp_x.acta_constitutiva_fecha,
            resp_x.copia_rif,
            resp_x.copia_rif_fecha,
            resp_x.copia_cedula,
            resp_x.copia_cedula_fecha,
            resp_x.letras,
            resp_x.letras_fecha,
            resp_x.listado_interprete,
            resp_x.listado_interprete_fecha,
            resp_x.autorizacion_replica,
            resp_x.autorizacion_replica_fecha,
            resp_x.exoneracion_derecho,
            resp_x.exoneracion_derecho_fecha,
            resp_x.nombre_definitivo,
            resp_x.nombre_definitivo_fecha,
            resp_x.master_produccion,
            resp_x.master_produccion_fecha,
            resp_x.fotografias,
            resp_x.fotografias_fecha,
            resp_x.numero_produccion,
            resp_x.tipo_estuche_id,
            resp_x.nombre_artista);
			$('#iconQR').show();
        }else{
			$('#iconQR').hide();
            limpiarAlNoEncontrarProyecto();
            $('#hid_proyecto').val($('#sel_proyecto').val());
            $('#lbl_nombre_proyecto').html(capturaNombreOpcion('sel_proyecto',$('#sel_proyecto').val()));
            TipoProyecto($('#sel_proyecto').val());
        }
    },"json");//
}

function montarDatosCatalogo(proyecto_id,nombre_proyecto,artista_id,tipo_artista_id,numero_deposito_legal,direccion,direccion_fecha,carta_compromiso_autoria,
                    carta_compromiso_autoria_fecha,carta_buena_fe,carta_buena_fe_fecha,deposito_legal,deposito_legal_fecha,representante_legal,representante_legal_fecha,
                    acta_constitutiva,acta_constitutiva_fecha,copia_rif,copia_rif_fecha,copia_cedula,copia_cedula_fecha,letras,letras_fecha,listado_interprete,listado_interprete_fecha,
                    autorizacion_replica,autorizacion_replica_fecha,exoneracion_derecho,exoneracion_derecho_fecha,nombre_definitivo,nombre_definitivo_fecha,
                    master_produccion,master_produccion_fecha,fotografias,fotografias_fecha,numero_produccion, tipo_estuche_id, nombre_artista){
    
    //validar comillas simples y dobles
    //*****************************************************************
    nombre_proyecto = escapaComiSen2(nombre_proyecto);
    if(numero_deposito_legal != null){
        numero_deposito_legal = escapaComiSen2(numero_deposito_legal);
    }
    if(numero_produccion != null){
        numero_produccion = escapaComiSen2(numero_produccion);
    }
    if(nombre_artista != null){
        nombre_artista = escapaComiSen2(nombre_artista);
    }    
    //*****************************************************************
    $('#hid_proyecto').val(proyecto_id);
    $('#h_qr_proyecto').val('Código Proyecto: ' + proyecto_id  + ' Artista: '+nombre_artista+' Nombre Producción: ' + nombre_proyecto);    
    $('#lbl_nombre_proyecto').html('&nbsp;&nbsp;&nbsp;'+nombre_proyecto);
    $('#sel_tipo_artista').val(tipo_artista_id);
    var objeto = {
        dependencia:'tipo_artista',
        dependencia_id:tipo_artista_id};
    llenaCombox('','artista',artista_id,objeto);
    objeto = {
        dependencia:'artista',
        dependencia_id:artista_id};
    llenaCombox('','proyecto',proyecto_id,objeto);
    if (direccion == 't'){
        checkar('ckb_direccion');
        $('#direccion_fecha').html(direccion_fecha);
    }
    if (carta_compromiso_autoria == 't'){
        checkar('ckb_carta_compromiso_autoria');
        $('#carta_compromiso_autoria_fecha').html(carta_compromiso_autoria_fecha);
    }
    if (carta_buena_fe == 't'){
        checkar('ckb_carta_buena_fe');
        $('#carta_buena_fe_fecha').html(carta_buena_fe_fecha);
    }
    if (deposito_legal == 't'){
        checkar('ckb_deposito_legal');
        $('#txt_numero_deposito_legal').val(numero_deposito_legal);
        $('#txt_numero_deposito_legal').attr('disabled','');
        $('#deposito_legal_fecha').html(deposito_legal_fecha);
    }
    $('#txt_numero_produccion').val(numero_produccion);
   
    if( tipo_estuche_id != null) {
        $('#sel_tipo_estuche').val(tipo_estuche_id);
    }
    
    if (representante_legal == 't'){
        checkar('ckb_representante_legal');
        $('#representante_legal_fecha').html(representante_legal_fecha);
    }
    if (acta_constitutiva == 't'){
        checkar('ckb_acta_constitutiva');
        $('#acta_constitutiva_fecha').html(acta_constitutiva_fecha);
    }
    if (copia_rif == 't'){
        checkar('ckb_copia_rif');
        $('#copia_rif_fecha').html(copia_rif_fecha);
    }
    if (copia_cedula == 't'){
        checkar('ckb_copia_cedula');
        $('#copia_cedula_fecha').html(copia_cedula_fecha);
    }
    if (letras == 't'){
        checkar('ckb_letras');
        $('#letras_fecha').html(letras_fecha);
    }
    if (listado_interprete == 't'){
        checkar('ckb_listado_interprete');
        $('#listado_interprete_fecha').html(listado_interprete_fecha);
    }
    if (autorizacion_replica == 't'){
        checkar('ckb_autorizacion_replica');
        $('#autorizacion_replica_fecha').html(autorizacion_replica_fecha);
    }
    if (exoneracion_derecho == 't'){
        checkar('ckb_exoneracion_derecho');
        $('#exoneracion_derecho_fecha').html(exoneracion_derecho_fecha);
    }
    if (nombre_definitivo == 't'){
        checkar('ckb_nombre_definitivo');
        $('#nombre_definitivo_fecha').html(nombre_definitivo_fecha);
    }
    if (master_produccion == 't'){
        checkar('ckb_master_produccion');
        $('#master_produccion_fecha').html(master_produccion_fecha);
    }
    if (fotografias == 't'){
        checkar('ckb_fotografias');
        $('#fotografias_fecha').html(fotografias_fecha);
    }
}

function limpiarAlNoEncontrarProyecto(){
    $('#hid_audio').val('');
    $('.label_fecha').html('');
    $('#lbl_nombre_proyecto').html('');
    $('#txt_numero_deposito_legal').val('');
    $('#txt_numero_deposito_legal').attr('disabled','disabled');
    $('#txt_numero_produccion').val('');
    $('#sel_tipo_estuche').val('');
    desChecked('ckb_todos');
    uncheckAll(document.frm_catalogo.lista_requisito);
}

function limpiar(){
    ocultarIconos();
	$('#iconQR').hide();
    $('#iconListar').show();
    $('.label_fecha').html('');
    $('#sel_tipo_artista').val('');
    $('#sel_artista').html('');
    $('#sel_proyecto').html('');
    $('#hid_proyecto').val('');
    $('#sel_proyecto').html('');
    $('#sel_artista').html('');
    $('#txt_numero_deposito_legal').val('');
    $('#txt_numero_deposito_legal').attr('disabled','disabled');
    $('#txt_numero_produccion').val('');
    $('#sel_tipo_estuche').val('');
    $('#lbl_nombre_proyecto').html('');
    desChecked('ckb_todos');
    uncheckAll(document.frm_catalogo.lista_requisito);
}