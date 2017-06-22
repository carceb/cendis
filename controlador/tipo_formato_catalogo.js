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
        $('#txt_formatoVM').val('');
        $('#grilla').remove();
        $('#tb_cabeceragrilla').hide();
    });
    $('#vm_Buscar').click(function(){//busca �l o los registros
        if($('#grilla')){$('#grilla').remove();}//si la grilla est� pintada la borra
        //loading('cargando');
        $.post("../modelo/cls_tipo_formato.php",{metodo:"cargaGrilla",parametros:creaParametrosvm()},function(data){//se ejecula la b�squeda.
            if(data.filas){//si trae resultado, entra.
                $('#tb_cabeceragrilla').show();//se visualiza el encabezado de la grilla.
                $.each(data.filas, function(cant_reg,detalle){//se recorre el json.
                    if(cant_reg==0){$('#scrolltb').append(tbgrilla());}//se pinta la grilla.
                    var str = detalle.tipo_formato_id+",'"+detalle.nombre_tipo_formato+"'";
                    //se agrega la fila con sus datos a la grilla.
                    $('#grilla tbody').append('<tr id="consulta"><td id="fila" align="left" width="370"><a href="#" onclick="aceptar('+str+')">'+detalle.nombre_tipo_formato+'</a></td></tr>');
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


function aceptar(tipo_formato_id,nombre_tipo_formato){//se carga los datos en formulario que los solicit� al clicar en el registro solicitado y cierra el cat�logo.
    montarTipoFormato(tipo_formato_id,nombre_tipo_formato);
    close_form();
}

function creaParametrosvm(){
    //Retorna los parárametros en notación JSON.
    var objeto = {nombre_tipo_formatoVM:$('#txt_formatoVM').val()};
    return JSON.stringify(objeto);
}