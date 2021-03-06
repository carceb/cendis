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
        $('#txt_todoVM').val('');
        $('#grilla').remove();
        $('#tb_cabeceragrilla').hide();
    });
    $('#vm_Buscar').click(function(){//busca ál o los registros
        if($('#grilla')){$('#grilla').remove();}//si la grilla está pintada la borra
        //loading('cargando');
        $.post("../modelo/cls_usuario.php",{metodo:"cargaGrilla",parametros:creaParametrosvm()},function(data){//se ejecula la básqueda.
            //alert(data);
            //loading_cerrar();
            if(data.filas){//si trae resultado, entra.
                $('#tb_cabeceragrilla').show();//se visualiza el encabezado de la grilla.
                $.each(data.filas, function(cant_reg,detalle){//se recorre el json.
                    if(cant_reg==0){$('#scrolltb').append(tbgrilla());}//se pinta la grilla.
                    var str = detalle.usuario_id+",'"+detalle.usuario_nombre+"','"+detalle.usuario_apellido+"','"+detalle.usuario_cedula+"','"+detalle.usuario_user+"','"+detalle.usuario_pws+"',"+detalle.usuario_estatus_id;
                    //se agrega la fila con sus datos a la grilla.
                    $('#grilla tbody').append('<tr id="consulta"><td id="fila" align="left" width="370"><a href="#" onclick="aceptar('+str+')">'+detalle.usuario_apellido+","+detalle.usuario_nombre+'</a></td></tr>');
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


function aceptar(usuario_id,usuario_nombre,usuario_apellido,usuario_cedula,usuario_user,usuario_pws,usuario_estatus_id){//se carga los datos en formulario que los solicitá al clicar en el registro solicitado y cierra el catálogo.
    montarDatosUsuario(usuario_id,usuario_nombre,usuario_apellido,usuario_cedula,usuario_user,usuario_pws,usuario_estatus_id);
    close_form();
}

function creaParametrosvm(){
    //Retorna los parárametros en notación JSON.
    var objeto = {todoVM:$('#txt_todoVM').val()};
    return JSON.stringify(objeto);
}