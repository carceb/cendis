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
    llenaCombox('','genero_musical');	
    $('.fila_temas').remove();
    $('#titulo').html('Carga del Repertorio de Temas de la Producción Musical');
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    $('#iconBuscar').hide();
    
    //Se eliminó debido a que el formulario repertorio_catalogo no estaba funcionando bien
    //Carlos Ceballos 03-11-12
    /*$('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
        if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('repertorio_catalogo','410','400','','div_form');
    });*/
    
    $('#iconLimpiar').click(function(){
        if ($('#hid_proyecto').val() != ''){
            jConfirm('¿Desea matener el Proyecto Actual?', 'Confirmación de Proceso', function(rx){
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
            $.post("../modelo/cls_repertorio.php",{metodo:"SeleccionarProyecto",parametros:$('#sel_proyecto').val()},function(resp_x){
                if(resp_x){
                    $('#hid_proyecto').val(resp_x.proyecto_id);
                    $('#lbl_nombre_proyecto').html(resp_x.nombre_proyecto);
                    LlenarTemas(resp_x.proyecto_id);
		    NextTrack(resp_x.proyecto_id);
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
            proyecto_id:$('#hid_proyecto').val(),
            tema_id:$('#hid_tema').val(),
            genero_musical_id:$('#sel_genero_musical').val(),
            nombre_tema:$('#txt_nombre_tema').val(),
            autor_letra:$('#txt_autor_letra').val(),
            autor_musica:$('#txt_autor_musica').val(),
            arreglo:$('#txt_arreglo').val(),
            duracion:$('#txt_duracion').val(),
            track:$('#sel_track').val()};
        return JSON.stringify(objeto);
    }
    
    function validaIngreso(){
        //validar los datos requeridos
        retorna = true;    
        if ($('#sel_genero_musical').val() == '')
        {
            jAlert('Debe Seleccionar un Genero Músical.', 'Operación cancelada');
            retorna =false;
        }
        
        if ($('#txt_nombre_tema').val() == '')
        {
            jAlert('Debe colocar el nombre del tema.', 'Operación cancelada');
            retorna =false;
        }
        if ($('#txt_autor_letra').val() == '')
        {
            jAlert('Debe colocar el nombre del autor de la letra.', 'Operación cancelada');
            retorna =false;
        }
        if ($('#txt_autor_musica').val() == '')
        {
            jAlert('Debe colocar el nombre del autor de la música.', 'Operación cancelada');
            retorna =false;
        }
        if ($('#txt_arreglo').val() == '')
        {
            jAlert('Debe colocar el nombre del autor del arreglo.', 'Operación cancelada');
            retorna =false;
        }
        if ($('#txt_duracion').val() == '')
        {
            jAlert('Debe colocar la duración del tema.', 'Operación cancelada');
            retorna =false;
        }
 	if ($('#hid_proyecto').val() == '')
        {
            jAlert('Debe Seleccionar un proyecto.', 'Operación cancelada');
            retorna =false;
        }           
        return retorna;
    }
    $('#iconGuardar').click(function(){
        if(!$('#hid_tema').val()){
            if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
            if(validaIngreso()){
                jConfirm('¿Desea guardar este Registro?', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_repertorio.php",{metodo:"ingresaTema",parametros:creaParametros()},function(resp_x){//alert(resp_x);
                            $('#hid_tema').val(resp_x.tema_id);
                            LlenarTemas($('#hid_proyecto').val());
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
                jConfirm('¿Desea Actualizar el Registro actual?', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_repertorio.php",{metodo:"actualizaTema",parametros:creaParametros()},function(resp_x){									
                            LlenarTemas($('#hid_proyecto').val());
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
                $.post("../modelo/cls_repertorio.php",{metodo:"eliminarTema",parametros:$('#hid_tema').val()},function(resp_x){
                    limpiar();
                    jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                },"json");	// Fin $.getJSON.
            }else{
               jAlert('Operación Cancelada', 'Confirmación de Proceso');
            }
        });
    }).hide();// fin $('#iconEliminar')
});// Fin---$(document).ready(function().

function montarDatosTema(proyecto_id,tipo_artista_id,artista_id,tema_id,nombre_proyecto,nombre_tema,autor_letra,autor_musica,arreglo,duracion,genero_musical_id,track){
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
    $('#hid_proyecto').val(proyecto_id);
    $('#hid_tema').val(tema_id);
    $('#lbl_nombre_proyecto').html(nombre_proyecto)
    $('#txt_nombre_tema').val(nombre_tema);
    $('#txt_autor_letra').val(autor_letra);
    $('#txt_autor_musica').val(autor_musica);
    $('#txt_arreglo').val(arreglo);
    $('#txt_duracion').val(duracion);
    $('#sel_genero_musical').val(genero_musical_id);
    LlenarTemas(proyecto_id);
    $('#sel_track').val(track);
    $('#iconEliminar').show();
    $('#iconImprimir').show();
}

function LlenarTemas(proyecto_id){
    $('.fila_temas').remove();
    var objeto = {caso:'listar_proyectos',proyecto_id:proyecto_id};
    objeto = JSON.stringify(objeto);
    $.post("../modelo/cls_repertorio.php",{metodo:"LlenarTemas",parametros:objeto},function(resp_x){
        $('#temas tbody').append(resp_x.html);
    },"json");//
}

function modificar(tema_id){
    $.post("../modelo/cls_repertorio.php",{metodo:"SeleccionarTema",parametros:tema_id},function(resp_x){
        if(resp_x.proyecto_id){
            $('#hid_proyecto').val(resp_x.proyecto_id);
            $('#hid_tema').val(resp_x.tema_id);
            $('#lbl_nombre_proyecto').html(resp_x.nombre_proyecto)
            $('#txt_nombre_tema').val(resp_x.nombre_tema);
            $('#txt_autor_letra').val(resp_x.autor_letra);
            $('#txt_autor_musica').val(resp_x.autor_musica);
            $('#txt_arreglo').val(resp_x.arreglo);
            $('#txt_duracion').val(resp_x.duracion);
            $('#sel_genero_musical').val(resp_x.genero_musical_id);
            $('#sel_track').val(resp_x.track);
            LlenarTemas(resp_x.proyecto_id);
            $('#iconEliminar').show();
            $('#iconImprimir').show();
        }
    },"json");//
}

function eliminar(tema_id){
    jConfirm('Se va Eliminar el registro Seleccionado', 'Confirmación de Proceso', function(rx){
        if(rx){
            $.post("../modelo/cls_repertorio.php",{metodo:"eliminarTema",parametros:tema_id},function(resp_x){
                proyecto_id = $('#hid_proyecto').val();
                limpiar()
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
    $('#sel_artista').html('');
    $('#sel_proyecto').html('');
    $('#hid_proyecto').val('');
    $('#hid_tema').val('');
    $('#lbl_nombre_proyecto').html('');
    $('#txt_nombre_tema').val('');
    $('#txt_autor_letra').val('');
    $('#txt_autor_musica').val('');
    $('#txt_arreglo').val('');
    $('#txt_duracion').val('');
    $('#sel_genero_musical').val('');
    $('#sel_track').val(1);
    $('.fila_temas').remove();
}

function limpiarMatenerProyecto(){
    ocultarIconos();
    $('#hid_tema').val('');
    $('#txt_nombre_tema').val('');
    $('#txt_autor_letra').val('');
    $('#txt_autor_musica').val('');
    $('#txt_arreglo').val('');
    $('#txt_duracion').val('');
    $('#sel_genero_musical').val('');
	NextTrack($('#hid_proyecto').val());
}

function NextTrack(proyecto_id){
    $.post("../modelo/cls_repertorio.php",{metodo:"NextTrack",parametros:proyecto_id},function(resp_x){
            if(resp_x){
                    $('#sel_track').val(resp_x.next_track);
            }
    },"json");//
}