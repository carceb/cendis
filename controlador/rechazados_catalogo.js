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
    $('#vm_Limpiar').click(function(){//Limpia el catalogo.
        $('#txt_fecha_desdeVM').val('');
        $('#txt_fecha_hastaVM').val('');
        $('#grilla').remove();
        $('#tb_cabeceragrilla').hide();
    });
    $('#txt_fecha_desdeVM').datepicker({changeMonth: true,changeYear: true});//Calendario
    $('#txt_fecha_hastaVM').datepicker({changeMonth: true,changeYear: true});//Calendario
    $('#vm_Buscar').click(function(){//busca �l o los registros
        $('.fila_rechazados').remove();
        var objeto = {txt_fecha_desdeVM:$('#txt_fecha_desdeVM').val(),txt_fecha_hastaVM:$('#txt_fecha_hastaVM').val(),caso:'listar_proyectos_fecha'};
        objeto = JSON.stringify(objeto);
        $.post("../modelo/cls_rechazados.php",{metodo:"LlenarSolicitudes",parametros:objeto},function(resp_x){
            $('#rechazados tbody').append(resp_x.html);
        },"json");//
        parent.$('#ventana_actual').attr('style',$('#haltoventana').val());
        close_form();
    });// Fin $('#vm_Buscar').
    
    $('#vm_Salir').click(function(){// sale del catalogo.
        parent.$('#ventana_actual').attr('style',$('#haltoventana').val());
        close_form();
    });
});