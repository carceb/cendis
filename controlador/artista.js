//nota revisar estado y municipio igual al proyecto tipo estado y municipio

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
    llenaCombox('','nacionalidad');
	
    var objeto = {dependencia3:'SELECT pais.pais_id AS id, pais.nombre_pais AS nombre FROM public.pais ORDER BY pais.pais_id ASC OFFSET 1'};
	llenaCombox('','pais','',objeto);
	
    llenaCombox('','sexo');
    llenaCombox('','estado');
    $('#titulo').html('Registro de Datos Principales del Artista o Grupo');
    $('#txt_fecha_ingreso_artista').datepicker({changeMonth: true,changeYear: true});//Calendario
    $('.representante').hide();
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
       if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('artista_catalogo','410','400','','div_form');
    });
    
    $('#iconLimpiar').click(function(){limpiar();});
    
    $('#sel_tipo_artista').change(function(){
        if ($('#sel_tipo_artista').val() == '3' ){
                $('.representante').show();
                $('.cedula_artista').hide();                
        } else {
                $('.representante').hide();
                $('.cedula_artista').show();
        } 
    });
    
    $('#sel_estado').change(function(){
        var objeto = {
            dependencia:'estado',
            dependencia_id:$('#sel_estado').val()};
        llenaCombox('','municipio','',objeto);
    });
	
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            artista_id:$('#hid_artista').val(),
            tipo_artista_id:$('#sel_tipo_artista').val(),
            nombre_artista:$('#txt_nombre_artista').val(),
            sexo_id:$('#sel_sexo').val(),
            fecha_ingreso_artista:$('#txt_fecha_ingreso_artista').val(),
            nacionalidad_id:$('#sel_nacionalidad').val(),
            pais_id:$('#sel_pais').val(),
            cedula_artista:val_integer('txt_cedula_artista'),
            cedula_representante_artistico:val_integer('txt_cedula_representante_artistico'),
            nombre_representante_artistico:$('#txt_nombre_representante_artistico').val(),
            telefono_habitacion:$('#txt_telefono_habitacion').val(),
            telefono_celular:$('#txt_telefono_celular').val(),
            telefono_otro:$('#txt_telefono_otro').val(),
            email_artista:$('#txt_email_artista').val(),
            direccion_artista:$('#txt_direccion_artista').val(),
            estado_id:$('#sel_estado').val(),
            municipio_id:$('#sel_municipio').val()};
        return JSON.stringify(objeto);
    }
    function validaIngreso(){
        //validar los datos requeridos
		if ($('#txt_nombre_artista').val() == ''){
			jAlert('Debe ingresar el Nombre', 'Operación cancelada');
			return false;
		}
		
                if ($('#sel_tipo_artista').val() != 3){
                    if ($('#txt_cedula_artista').val() == ''){
                            jAlert('Debe ingresar una Cedula' , 'Operación cancelada');
                            return false;
                    }else{
                            var cedula = $('#txt_cedula_artista').val();
                            if (cedula.match(/^\d+$/) == null){
                                    jAlert('Debe colocar solo n&uacute;meros en el campo de C&eacute;dula' , 'Operación cancelada');
                                    return false;
                            }
                    }                    
                }

		
		if ($('#sel_tipo_artista').val() == ''){
			jAlert('Debe seleccionar un Tipo Artista' , 'Operación cancelada');
			return false;
		}else{
			if ($('#sel_tipo_artista').val() != '3' && $('#txt_cedula_artista').val() == ''){
				jAlert('Debe colocar el n&uacute;mero de c&eacute;dula' , 'Operación cancelada');
				return false;
			}
		}
		
		if ($('#sel_nacionalidad').val() == ''){
			jAlert('Debe seleccionar una Nacionalidad' , 'Operación cancelada');
            return false;
		}
		
		if ($('#sel_pais').val() == ''){
			jAlert('Debe seleccionar un Pa&iacute;s' , 'Operación cancelada');
            return false;
		}
		
		if ($('#sel_sexo').val() == ''){
			jAlert('Debe seleccionar el Sexo' , 'Operación cancelada');
            return false;
		}
            
        if ($('#txt_fecha_ingreso_artista').val() == ''){
			jAlert('Debe ingresar la Fecha Ingreso.', 'Operación cancelada');
			return false;
        }else{
			if(!isDate($('#txt_fecha_ingreso_artista').val())){
				jAlert('Debe ingresar la Fecha Ingreso valida.', 'Operación cancelada');
                return false;
			}
		}
		
        if ($('#txt_telefono_habitacion').val() == ''){
			jAlert('Debe ingresar un Tel&eacute;fono Habitación.', 'Operación cancelada');
			return false;
		}
        
        if ($('#txt_telefono_celular').val() == ''){
			jAlert('Debe ingresar un Tel&eacute;fono Celular.', 'Operación cancelada');
			return false;
		}

        if($('#txt_email_artista').val() != ""){
			if($('#txt_email_artista').val().indexOf('@')==-1 || $('#txt_email_artista').val().indexOf('.')==-1 ){
			   jAlert( "Debe ingresar un Correo valido." );
			   return false;
			}
        }
		
        if ($('#txt_direccion_artista').val() == ''){
			jAlert('Debe ingresar una Direcci&oacute;n.', 'Operación cancelada');
			return false;
        }    
        return true;
    }
    $('#iconGuardar').click(function(){
        if(!$('#hid_artista').val()){
            if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
            if(validaIngreso()){
                jConfirm('¿Desea guardar este Registro?', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_artista.php",{metodo:"ingresaArtista",parametros:creaParametros()},function(resp_x){
                            if (resp_x.id_artista){
                                $('#hid_artista').val(resp_x.id_artista);
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
            jConfirm('¿Desea Actualizar el Registro actual?', 'Confirmación de Proceso', function(rx){
                if(rx){
                    $.post("../modelo/cls_artista.php",{metodo:"actualizaArtista",parametros:creaParametros()},function(resp_x){                   
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
                $.post("../modelo/cls_artista.php",{metodo:"eliminarArtista",parametros:$('#hid_artista').val()},function(resp_x){
                    limpiar();
                    jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                },"json");	// Fin $.getJSON.
            }else{
               jAlert('Operación Cancelada', 'Confirmación de Proceso');
            }
        });
    }).hide();// fin $('#iconEliminar')
    
    $('#txt_cedula_artista').numeric();
    
});// Fin---$(document).ready(function().

function montarDatosArtista(artista_id,tipo_artista_id,nombre_artista,sexo_id,nacionalidad_id,cedula_artista,cedula_representante_artistico,nombre_representante_artistico,pais_id,estado_id,municipio_id,telefono_habitacion,telefono_celular,telefono_otro,email_artista,direccion_artista,fecha_ingreso_artista){
    limpiar();
    $('#hid_artista').val(artista_id);
    $('#sel_tipo_artista').val(tipo_artista_id);
    if (tipo_artista_id == '3' ){
            $('.representante').show();
            $('.cedula_artista').hide();                
    } else {
            $('.representante').hide();
            $('.cedula_artista').show();
    }    
    $('#txt_nombre_artista').val(nombre_artista);
    $('#sel_sexo').val(sexo_id);
    $('#txt_fecha_ingreso_artista').val(fecha_ingreso_artista);
    $('#sel_nacionalidad').val(nacionalidad_id);
    $('#sel_pais').val(pais_id);
    $('#txt_cedula_artista').val(cedula_artista);
    $('#txt_cedula_representante_artistico').val(cedula_representante_artistico);
    $('#txt_nombre_representante_artistico').val(nombre_representante_artistico);
    $('#txt_telefono_habitacion').val(telefono_habitacion);
    $('#txt_telefono_celular').val(telefono_celular);
    $('#txt_telefono_otro').val(telefono_otro);
    $('#txt_email_artista').val(email_artista);
    $('#txt_direccion_artista').val(direccion_artista);
    $('#sel_estado').val(estado_id);
    var objeto = {
        dependencia:'estado',
        dependencia_id:estado_id};
    llenaCombox('','municipio',municipio_id,objeto);
    $('#iconEliminar').show();
    $('#iconImprimir').show();
}

function limpiar(){
    ocultarIconos();
    $('#sel_estado').val('');
    $('#sel_municipio').html('');
    $('#hid_artista').val('');
    $('#sel_tipo_artista').val('');
    $('#txt_nombre_artista').val('');
    $('#sel_sexo').val('');
    $('#txt_fecha_ingreso_artista').val('');
    $('#sel_nacionalidad').val('');
    $('#sel_pais').val('');
    $('#txt_cedula_artista').val('');
    $('.representante').hide();
    $('#txt_nombre_representante_artistico').val('');
    $('#txt_telefono_habitacion').val('');
    $('#txt_telefono_celular').val('');
    $('#txt_telefono_otro').val('');
    $('#txt_email_artista').val('');
    $('#txt_direccion_artista').val('');
}

$(function() {
    var availableTags = [];
    $.post("../modelo/cls_artista.php",{metodo:"availableTags",parametros:''},function(data){
        if(data.filas){//si trae resultado, entra.
            $.each(data.filas, function(cant_reg,detalle){//se recorre el json.
                availableTags[cant_reg] = detalle.nombre_artista;
            });
        }
        $('#txt_nombre_artista').autocomplete({
                source: availableTags
        });
    },"json");    
});