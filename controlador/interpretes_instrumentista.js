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
    ocultarIconos();
    llenaCombox('','tipo_artista');
    llenaCombox('','instrumento');
    $('.fila_interprete_instrumentista').remove();
    $('#titulo').html('::. Ingresar .::');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
       if($('#prms').data('pms_buscar')){msjAccss();return;}
        open_form('interpretes_catalogo','410','400','','div_form');
    });
    
    $('#iconLimpiar').click(function(){//Visualiza el catalogo de ocupaciones.
       if($('#prms').data('pms_buscar')){msjAccss();return;}
        if ($('#hid_tema').val() != ''){
            jConfirm('Desea matener el Tema Actual?', 'Confirmación de Proceso', function(rx){
                if(rx)
                    limpiarMatenerProyecto()
                else
                    limpiar();
            });
        }else
           limpiar();
    });
    
    $('#sel_tipo_artista').change(function(){
        var objeto = {
            dependencia:'tipo_artista',
            dependencia_id:$('#sel_tipo_artista').val()};
        llenaCombox('','artista','',objeto);
        $('#sel_proyecto').html('')
        $('#sel_tema').html('')
    });
    
    $('#sel_artista').change(function(){
        var objeto = {
            dependencia:'artista',
            dependencia_id:$('#sel_artista').val(),
			dependencia2:'estatus_proyecto',
            dependencia_id2:3};
        llenaCombox('','proyecto','',objeto); 
        $('#sel_tema').html('')
    });
    
    $('#sel_proyecto').change(function(){
        var objeto = {
            dependencia:'proyecto',
            dependencia_id:$('#sel_proyecto').val()};
        llenaCombox('','tema','',objeto);
    });
    
    $('#sel_tema').change(function(){
        if ($('#sel_proyecto').val() != ''){
            $.post("../modelo/cls_interprete_instrumentista.php",{metodo:"SeleccionarTema",parametros:$('#sel_tema').val()},function(resp_x){
                if(resp_x.tema_id){
                    $('#hid_tema').val(resp_x.tema_id);
                    $('#lbl_nombre_tema').html(resp_x.nombre_tema);
                    $('#lbl_nombre_proyecto').html(resp_x.nombre_proyecto);
                    LlenarInterprete_Instrumentista(resp_x.tema_id);
                }
            },"json");//
        }else{
            limpiar();
        }
    });
	
    //FUNCIONES
    function creaParametros(){
        //Retorna los parárametros en notación JSON.
        var objeto = {
            interprete_instrumentista_id:$('#hid_interprete_instrumentista').val(),
            tema_id:$('#hid_tema').val(),
            instrumento_id:$('#sel_instrumento').val(),
            nombre_interprete_instrumentista:$('#txt_nombre_interprete_instrumentista').val()};
        return JSON.stringify(objeto);
    }
    
    function validaIngreso(){
        //validar los datos requeridos
        retorna = true;
        if ($('#sel_instrumento').val() == '')
        {
            jAlert('Debe Seleccionar un Tipo Interprete o instrumentistas', 'Operación cancelada');
            retorna =false;
        } 
        return retorna;
    }
    $('#iconGuardar').click(function(){
        if(!$('#hid_interprete_instrumentista').val()){
            if($('#prms').data('pms_ingresar')){msjAccss();return;}
            if(validaIngreso()){
                jConfirm('Desea guardar este Registro', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_interprete_instrumentista.php",{metodo:"ingresaInterprete",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                            $('#hid_interprete_instrumentista').val(resp_x.interprete_instrumentista_id),
                            LlenarInterprete_Instrumentista($('#hid_tema').val());
                            jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                        },"json");
                    }else{
                        jAlert('Operación Cancelada', 'Confirmación de Proceso');
                    }
                });
            }
        }else{
            jConfirm('Desea Actualizar el Registro actual', 'Confirmación de Proceso', function(rx){
                if(rx){
                    $.post("../modelo/cls_interprete_instrumentista.php",{metodo:"actualizaInterprete",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                        LlenarInterprete_Instrumentista($('#hid_tema').val());
                        jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                    },"json");
                }else{
                    jAlert('Operación Cancelada', 'Confirmación de Proceso');
                }
            });
        }
    });// fin $('#iconGuardar')
    $('#iconEliminar').click(function(){
        if($('#prms').data('pms_eliminar')){msjAccss();return;}
        jConfirm('Se va Eliminar el registro actual', 'Confirmación de Proceso', function(rx){
            if(rx){
                $.post("../modelo/cls_interprete_instrumentista.php",{metodo:"eliminarInterprete_Instrumentista",parametros:$('#hid_interprete_instrumentista').val()},function(resp_x){
                    limpiar();
                    jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                },"json");	// Fin $.getJSON.
            }else{
               jAlert('Operación Cancelada', 'Confirmación de Proceso');
            }
        });
    }).hide();// fin $('#iconEliminar')
});// Fin---$(document).ready(function().

function montarDatosInterprete(interprete_instrumentista_id,tema_id,tipo_artista_id,artista_id,proyecto_id,nombre_proyecto,nombre_tema,nombre_interprete_instrumentista,instrumento_id){
    limpiar();
    $('#sel_tipo_artista').val(tipo_artista_id);
    var objeto = {
        dependencia:'tipo_artista',
        dependencia_id:tipo_artista_id};
    llenaCombox('','artista',artista_id,objeto);
    objeto = {
        dependencia:'artista',
        dependencia_id:artista_id};
    llenaCombox('','proyecto',proyecto_id,objeto);
    objeto = {
        dependencia:'proyecto',
        dependencia_id:proyecto_id};
    llenaCombox('','tema',tema_id,objeto);
    $('#hid_interprete_instrumentista').val(interprete_instrumentista_id);
    $('#hid_tema').val(tema_id);
    $('#lbl_nombre_proyecto').html(nombre_proyecto);
    $('#lbl_nombre_tema').html(nombre_tema);
    $('#txt_nombre_tema').val(nombre_tema);
    $('#txt_nombre_interprete_instrumentista').val(nombre_interprete_instrumentista);
    $('#sel_instrumento').val(instrumento_id);
    LlenarInterprete_Instrumentista(tema_id);
    $('#iconEliminar').show();
    $('#iconImprimir').show();
    $('#titulo').html('::. Actualizar .::');
}

function LlenarInterprete_Instrumentista(tema_id){
    $('.fila_interprete_instrumentista').remove();
    var objeto = {caso:'por_tema',tema_id:tema_id};
    objeto = JSON.stringify(objeto);
    $.post("../modelo/cls_interprete_instrumentista.php",{metodo:"LlenarInterprete",parametros:objeto},function(resp_x){
        $('#interprete_instrumentista tbody').append(resp_x.html);
    },"json");//
}

function modificar(interprete_instrumentista_id){
    $.post("../modelo/cls_interprete_instrumentista.php",{metodo:"SeleccionarInterpreteInstrumentista",parametros:interprete_instrumentista_id},function(resp_x){
        if(resp_x.interprete_instrumentista_id){
            $('#hid_interprete_instrumentista').val(resp_x.interprete_instrumentista_id);
            $('#txt_nombre_interprete_instrumentista').val(resp_x.nombre_interprete_instrumentista);
            $('#sel_instrumento').val(resp_x.instrumento_id);
            LlenarInterprete_Instrumentista(resp_x.tema_id);
            $('#iconEliminar').show();
            $('#iconImprimir').show();
            $('#titulo').html('::. Actualizar .::');
        }
    },"json");//
}

function eliminar(interprete_instrumentista_id){
    jConfirm('Se va Eliminar el registro Seleccionado', 'Confirmación de Proceso', function(rx){
        if(rx){
            $.post("../modelo/cls_interprete_instrumentista.php",{metodo:"eliminarInterprete_Instrumentista",parametros:interprete_instrumentista_id},function(resp_x){
                tema_id = $('#hid_tema').val();
                limpiar();
                LlenarInterprete_Instrumentista(tema_id);
                jAlert(resp_x.mensaje, 'Confirmación de Proceso');
            },"json");	// Fin $.getJSON.
        }else{
           jAlert('Operación Cancelada', 'Confirmación de Proceso');
        }
    });
}

function limpiar(){
    ocultarIconos();
    $('#sel_tipo_artista').val('');
    $('#sel_artista').html('')
    $('#sel_proyecto').html('')
    $('#sel_tema').html('')
    $('#hid_interprete_instrumentista').val('');
    $('#hid_tema').val('');
    $('#lbl_nombre_proyecto').html('');
    $('#lbl_nombre_tema').html('');
    $('#txt_nombre_interprete_instrumentista').val('');
    $('#txt_duracion').val('');
    $('#sel_instrumento').val('');
    $('.fila_interprete_instrumentista').remove();
    $('#titulo').html('::. Ingresar .::');
}

function limpiarMatenerProyecto(){
    ocultarIconos();
    $('#hid_interprete_instrumentista').val('');
    $('#txt_nombre_interprete_instrumentista').val('');
    $('#txt_duracion').val('');
    $('#sel_instrumento').val('');
    $('#titulo').html('::. Ingresar .::');
}