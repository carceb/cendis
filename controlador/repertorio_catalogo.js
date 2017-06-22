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
    $('#tb_cabeceragrilla').hide();//oculta el encabezado de la grilla.
    $('#vm_Limpiar').click(function(){//Limpia el catalogo.
        llenaCombox('','tipo_artistaVM');
        $('#grilla').remove();
        $('#tb_cabeceragrilla').hide();
    });
    llenaCombox('','tipo_artistaVM');
    $('#sel_tipo_artistaVM').change(function(){
        var objeto = {
            dependencia:'tipo_artista',
            dependencia_id:$('#sel_tipo_artistaVM').val()};
        llenaCombox('','artistaVM','',objeto);
        $('#sel_proyectoVM').html('');
    });
    
    $('#sel_artistaVM').change(function(){
        if ($('#sel_artistaVM').val() != ''){
            var objeto = {
                dependencia:'artista',
                dependencia_id:$('#sel_artistaVM').val()};
            llenaCombox('','proyectoVM','',objeto);
        }else{
            $('#sel_proyectoVM').html('');
        }
    });
    $('#vm_Buscar').click(function(){//busca �l o los registros
        if($('#grilla')){$('#grilla').remove();}//si la grilla est� pintada la borra
        //loading('cargando');
        $.post("../modelo/cls_repertorio.php",{metodo:"cargaGrilla",parametros:creaParametrosvm()},function(data){//se ejecula la b�squeda.
            //alert(data);
            //loading_cerrar();
            if(data.filas){//si trae resultado, entra.
                $('#tb_cabeceragrilla').show();//se visualiza el encabezado de la grilla.
                $.each(data.filas, function(cant_reg,detalle){//se recorre el json.
                    if(cant_reg==0){$('#scrolltb').append(tbgrilla());}//se pinta la grilla.
                    var str = detalle.proyecto_id+","+detalle.tipo_artista_id+","+detalle.artista_id+","+detalle.tema_id+",'"+detalle.nombre_proyecto+"','"+detalle.nombre_tema+"','"+detalle.autor_letra+"','"+detalle.autor_musica+"','"+detalle.arreglo+"','"+detalle.duracion+"',"+detalle.genero_musical_id+","+detalle.track;
                    //se agrega la fila con sus datos a la grilla.
                    $('#grilla tbody').append('<tr id="consulta"><td id="fila" align="left" width="370"><a href="#" onclick="aceptar('+str+')">'+detalle.nombre_tema+' | '+detalle.nombre_genero_musical+'</a></td></tr>');
                    $('#grilla tbody').append('<tr><td height="1" bgcolor="#BBBBBB" align="center"></td>');//separador de fila.
                });//Fin $.each
            }else{
                alert('Disculpe, no se encontraron coincidencias');
            }
        },"json");//    Fin getJSON.
    });// Fin $('#vm_Buscar').

    $('#vm_Salir').click(function(){// sale del catalogo.
        parent.$('#ventana_actual').attr('style',$('#haltoventana').val());
        close_form();
    });
});

function tbgrilla(){//tabla para la grilla.
    return '<table id="grilla" width="370" height="16" border="0" align="center" cellpadding="0" cellspacing="2"><tr></tr></table>';
}

function aceptar(proyecto_id,tipo_artista_id,artista_id,tema_id,nombre_proyecto,nombre_tema,autor_letra,autor_musica,arreglo,duracion,genero_musical_id,track){//se carga los datos en formulario que los solicit� al clicar en el registro solicitado y cierra el cat�logo.
    montarDatosTema(proyecto_id,tipo_artista_id,artista_id,tema_id,nombre_proyecto,nombre_tema,autor_letra,autor_musica,arreglo,duracion,genero_musical_id,track);
    close_form();
}

function creaParametrosvm(){
    //Retorna los parárametros en notación JSON.
    var objeto = {sel_tipo_artistaVM:$('#sel_tipo_artistaVM').val(),sel_artistaVM:$('#sel_artistaVM').val(),sel_proyectoVM:$('#sel_proyectoVM').val()};
    return JSON.stringify(objeto);
}