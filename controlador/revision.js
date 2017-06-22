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
    $('#titulo').html('Revisión de Proyectos Comisión Artística');
    
    //llenar grid seleccionables
    LlenarSolicitudes();
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
       if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('revision_catalogo','410','400','','div_form');
    });
    
    $('#iconLimpiar').click(function(){LlenarSolicitudes();});
	
    //FUNCIONES
    function validaIngreso(){
        retorna = true;             
        $('.fila_rechazados').each(function () {
            id = (this.id);
            if ($('#sel_motivo_rechazo_'+id).val() == ''){
                    jAlert('Debe indicar el motivo del rechazo.', 'Operación cancelada');
                    retorna = false;
            }
         });        
        return retorna;
    }
    
    $('#iconGuardar').click(function(){
        if(!$('#hid_comision_artista').val()){
            if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
            if(validaIngreso()){
                jConfirm('¿Desea guardar este Registro?', 'Confirmación de Proceso', function(rx){
                    if(rx){
                        $.post("../modelo/cls_revision.php",{metodo:"ingresaComision",parametros:''},function(resp_x){//alert(resp_x);
                            ActualizarEstatusProyecto(resp_x.comision_artistica_id);
                            jAlert(resp_x.mensaje, 'Confirmación de Proceso');
                            LlenarSolicitudes();
                        },"json");
                    }else{
                        jAlert('Operación Cancelada', 'Confirmación de Proceso');
                    }
                });
            }
        }else{
            if($('#prms').data('pms_modificar')=='f'){msjAccss();return;}
            jConfirm('¿Desea Actualizar el Registro actual?', 'Confirmación de Proceso', function(rx){
                if(rx){
                    $.post("../modelo/cls_artista.php",{metodo:"actualizaComision",parametros:''},function(resp_x){//alert(resp_x);
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
});// Fin---$(document).ready(function().

function montarDatosRevision(proyecto_id,fecha_comision_artistica,nombre_tipo_artista,nombre_artista,nombre_proyecto,nombre_genero_musical,decision){
    LlenarSolicitudes();
    var fila = '';
    if (decision == 'APROBADO')
        fila = 'aprobados';
    else
        fila = 'rechazados';
    fila = '<tr id="'+proyecto_id+'" class="fila_'+fila+'" style="background-color:#CCCCCC">';
        fila += '<td id="fecha_'+proyecto_id+'">'+fecha_comision_artistica+'</td>';
        fila += '<td id="tipo_artista_'+proyecto_id+'">'+nombre_tipo_artista+'</td>';
        fila += '<td id="artista_'+proyecto_id+'">'+nombre_artista+'</td>';
        fila += '<td id="proyecto_'+proyecto_id+'">'+nombre_proyecto+'</td>';
        fila += '<td id="genero_'+proyecto_id+'">'+nombre_genero_musical+'</td>';
        fila += '<td id="decision">';
        fila += decision;
        fila += '</td>';
    fila += '</tr>';
    $('#'+fila+' tbody').append(fila);    
    $('#iconImprimir').show();
}

function agregar_aprobado(id){
    var fila = '';
    var background = '';
    var tr = ($('.fila_aprobados').length);
    var resto = tr % 2;
    if (resto == 0){
        background = 'background-color:#CCCCCC';
    }

    fecha = $('#fecha_'+id).html();
    tipo_artista = $('#tipo_artista_'+id).html();
    artista = $('#artista_'+id).html();
    proyecto = $('#proyecto_'+id).html();
    genero = $('#genero_'+id).html();
    $('#'+id).remove();
        fila = '<tr id="'+id+'" class="fila_aprobados" style="'+background+'">';
        fila += '<td id="fecha_'+id+'">'+fecha+'</td>';
        fila += '<td id="tipo_artista_'+id+'">'+tipo_artista+'</td>';
        fila += '<td id="artista_'+id+'">'+artista+'</td>';
        fila += '<td id="proyecto_'+id+'">'+proyecto+'</td>';
        fila += '<td id="genero_'+id+'">'+genero+'</td>';
        fila += '<td id="decision">';
        fila += '<a href="#" onclick="selecionable(\''+id+'\')"><div class="liked"></div></a>';
        fila += '</td>';
    fila += '</tr>';
    $('#aprobados tbody').append(fila);
}

function agregar_rechazado(id){
    var fila = '';
    var background = '';
    var tr = ($('.fila_rechazados').length);
    var resto = tr % 2;
    if (resto == 0){
        background = 'background-color:#CCCCCC';
    }
    fecha = $('#fecha_'+id).html();
    tipo_artista = $('#tipo_artista_'+id).html();
    artista = $('#artista_'+id).html();
    proyecto = $('#proyecto_'+id).html();
    genero = $('#genero_'+id).html();

    $('#'+id).remove();
        fila = '<tr id="'+id+'" class="fila_rechazados" style="'+background+'">';
        fila += '<td id="fecha_'+id+'">'+fecha+'</td>';
        fila += '<td id="tipo_artista_'+id+'">'+tipo_artista+'</td>';
        fila += '<td id="artista_'+id+'">'+artista+'</td>';
        fila += '<td id="proyecto_'+id+'">'+proyecto+'</td>';
        fila += '<td id="genero_'+id+'">'+genero+'</td>';
        fila += '<td><select id="sel_motivo_rechazo_'+id+'" name="sel_motivo_rechazo_'+id+'" class="select">'
        fila += '<td id="decision">';
        fila += '<a href="#" onclick="selecionable(\''+id+'\')"><div class="like"></div></a>';
        fila += '</td>';
    fila += '</tr>';
    $('#rechazados tbody').append(fila);
    llenaCombox('sel_motivo_rechazo_'+id,'motivo_rechazo');
}

function selecionable(id){
    var fila = '';
    var background = '';
    var tr = ($('.fila_seleccionables').length);
    var resto = tr % 2;
    if (resto == 0){
        background = 'background-color:#CCCCCC';
    }
    fecha = $('#fecha_'+id).html();
    tipo_artista = $('#tipo_artista_'+id).html();
    artista = $('#artista_'+id).html();
    proyecto = $('#proyecto_'+id).html();
    genero = $('#genero_'+id).html();
    $('#'+id).remove();
    fila = '<tr id="'+id+'" class="fila_seleccionables"  style="'+background+'">';
        fila += '<td id="fecha_'+id+'">'+fecha+'</td>';
        fila += '<td id="tipo_artista_'+id+'">'+tipo_artista+'</td>';
        fila += '<td id="artista_'+id+'">'+artista+'</td>';
        fila += '<td id="proyecto_'+id+'">'+proyecto+'</td>';
        fila += '<td id="genero_'+id+'">'+genero+'</td>';
        fila += '<td id="decision">'
        fila += '<a href="#" onclick="agregar_aprobado(\''+id+'\')"><div class="like"></div></a>';
        fila += '<a href="#" onclick="agregar_rechazado(\''+id+'\')"><div class="liked"></div></a>';
        fila += '</td>'
    fila += '</tr>'
    $('#seleccionables tbody').append(fila);
}

function ActualizarEstatusProyecto(comision_artistica_id){
    $('.fila_aprobados').each(function () {
        id = (this.id);
        var objeto = {proyecto_id:id,comision_artistica_id:comision_artistica_id,estatus_proyecto_id:2,motivo_rechazo_id:1};
        objeto = JSON.stringify(objeto)
        $.post("../modelo/cls_revision.php",{metodo:"ActualizarEstatusProyecto",parametros:objeto},function(){},"json");//
    });
    $('.fila_rechazados').each(function () {
        id = (this.id);
        var objeto = {proyecto_id:id,comision_artistica_id:comision_artistica_id,estatus_proyecto_id:0, motivo_rechazo_id:$('#sel_motivo_rechazo_'+id).val()};
        objeto = JSON.stringify(objeto)
        $.post("../modelo/cls_revision.php",{metodo:"ActualizarEstatusProyecto",parametros:objeto},function(){},"json");//
    });
}

function LlenarSolicitudes(){
    $('.fila_seleccionables').remove();
    $('.fila_aprobados').remove();
    $('.fila_rechazados').remove();
    var objeto = {caso:'listar_proyectos'};
    objeto = JSON.stringify(objeto);
    $.post("../modelo/cls_revision.php",{metodo:"LlenarSolicitudes",parametros:objeto},function(resp_x){
        $('#seleccionables tbody').append(resp_x.html);
    },"json");//
}