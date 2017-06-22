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
    $('#tb_cabeceragrilla').hide();//oculta el encabezado de la grilla.
    $('#vm_Limpiar').click(function(){//Limpia el catalogo.
        llenaCombox('','tipo_artistaVM');
        $('#sel_artistaVM').html();
        $('#sel_proyectoVM').html();
        $('#sel_temaVM').html();
        $('#grilla').remove();
        $('#tb_cabeceragrilla').hide();
    });
    llenaCombox('','tipo_artistaVM');
    
    $('#sel_tipo_artistaVM').change(function(){
        var objeto = {
            dependencia:'tipo_artista',
            dependencia_id:$('#sel_tipo_artistaVM').val()};
        llenaCombox('','artistaVM','',objeto);
        $('#sel_proyectoVM').html('')
        $('#sel_temaVM').html('')
    });
    
    $('#sel_artistaVM').change(function(){
        var objeto = {
            dependencia:'artista',
            dependencia_id:$('#sel_artistaVM').val()};
        llenaCombox('','proyectoVM','',objeto);
        $('#sel_temaVM').html('')
    });
    
     $('#sel_proyectoVM').change(function(){
        var objeto = {
            dependencia:'proyecto',
            dependencia_id:$('#sel_proyectoVM').val()};
        llenaCombox('','temaVM','',objeto);
    });
    
    $('#vm_Buscar').click(function(){//busca �l o los registros
        if($('#grilla')){$('#grilla').remove();}//si la grilla est� pintada la borra
        //loading('cargando');
        $.post("../modelo/cls_interprete_instrumentista.php",{metodo:"cargaGrilla",parametros:creaParametrosvm()},function(data){//se ejecula la b�squeda.
            //alert(data);
            //loading_cerrar();
            if(data.filas){//si trae resultado, entra.
                $('#tb_cabeceragrilla').show();//se visualiza el encabezado de la grilla.
                $.each(data.filas, function(cant_reg,detalle){//se recorre el json.
                    if(cant_reg==0){$('#scrolltb').append(tbgrilla());}//se pinta la grilla.
                    var str = detalle.interprete_instrumentista_id+", "+detalle.tema_id+", "+detalle.tipo_artista_id+", "+detalle.artista_id+", "+detalle.proyecto_id+", '"+detalle.nombre_proyecto+"', '"+detalle.nombre_tema+"', '"+detalle.nombre_interprete_instrumentista+"', "+detalle.instrumento_id;
                    //se agrega la fila con sus datos a la grilla.
                    $('#grilla tbody').append('<tr id="consulta"><td id="fila" align="left" width="370"><a href="#" onclick="aceptar('+str+')">'+detalle.nombre_interprete_instrumentista+' | '+detalle.nombre_instrumento+'</a></td></tr>');
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

function aceptar(interprete_instrumentista_id,tema_id,tipo_artista_id,artista_id,proyecto_id,nombre_proyecto,nombre_tema,nombre_interprete_instrumentista,instrumento_id){//se carga los datos en formulario que los solicit� al clicar en el registro solicitado y cierra el cat�logo.
    montarDatosInterprete(interprete_instrumentista_id,tema_id,tipo_artista_id,artista_id,proyecto_id,nombre_proyecto,nombre_tema,nombre_interprete_instrumentista,instrumento_id);
    close_form();
}

function creaParametrosvm(){
    //Retorna los parárametros en notación JSON.
    var objeto = {sel_tipo_artistaVM:$('#sel_tipo_artistaVM').val(),sel_artistaVM:$('#sel_artistaVM').val(),
                  sel_proyectoVM:$('#sel_proyectoVM').val(),sel_temaVM:$('#sel_temaVM').val()};
    return JSON.stringify(objeto);
}