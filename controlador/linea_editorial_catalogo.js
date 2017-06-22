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
        $('#txt_fecha_desdeVM').val('');
        $('#txt_fecha_hastaVM').val('');
    });
    $('#txt_fecha_desdeVM').datepicker({changeMonth: true,changeYear: true});//Calendario
    $('#txt_fecha_hastaVM').datepicker({changeMonth: true,changeYear: true});//Calendario
    $('#vm_Buscar').click(function(){//busca �l o los registros
        $('.fila_linea_editorial').remove();
        var objeto = {txt_fecha_desdeVM:$('#txt_fecha_desdeVM').val(),txt_fecha_hastaVM:$('#txt_fecha_hastaVM').val(),caso:'listar_proyectos_fecha'};
        objeto = JSON.stringify(objeto);
        $.post("../modelo/cls_linea_editorial.php",{metodo:"LlenarSolicitudes",parametros:objeto},function(resp_x){
            if(resp_x.filas){//si trae resultado, entra.
                var i = 1;
                var background = '';
                var resto;
                $.each(resp_x.filas, function(cant_reg,detalle){//se recorre el json.
                    resto = i % 2;
                    if (resto == 0){
                        background = '';
                    }else{
                        background = 'background-color:#CCCCCC';
                    }
                    var html = '<tr id="'+detalle.proyecto_id+'" style="'+background+'"class="fila_linea_editorial">'
                        html += '    <td id="tipo_artista_'+detalle.proyecto_id+'">&nbsp;'+detalle.nombre_tipo_artista+'</td>'
                        html += '    <td id="artista_'+detalle.proyecto_id+'">&nbsp;'+detalle.nombre_artista+'</td>'
                        html += '    <td id="proyecto_'+detalle.proyecto_id+'">&nbsp;'+detalle.nombre_proyecto+'</td>'
                        html += '    <td id="genero_'+detalle.proyecto_id+'">&nbsp;'+detalle.nombre_genero_musical+'</td>'
                        html += '    <td><select id="sel_linea_editorial_'+detalle.proyecto_id+'" name="sel_linea_editorial_'+detalle.proyecto_id+'" class="select">'
                        html += '    </select>'
                        html += '    </td>'
                        html += '</tr>';
                    $('#linea_editorial tbody').append(html);
                    llenaCombox('sel_linea_editorial_'+detalle.proyecto_id,'linea_editorial');
                    i++;
                });//Fin $.each
            }
        },"json");//
        parent.$('#ventana_actual').attr('style',$('#haltoventana').val());
        close_form();
    });// Fin $('#vm_Buscar').
    
    $('#vm_Salir').click(function(){// sale del catalogo.
        parent.$('#ventana_actual').attr('style',$('#haltoventana').val());
        close_form();
    });
});