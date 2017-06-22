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
    $('#vm_Salir').click(function(){// sale del catalogo.
        parent.$('#ventana_actual').attr('style',$('#haltoventana').val());
        close_form();
    });    
    LlenarProyectos();
});

function LlenarProyectos(){    
    $('.fila_catalogo').remove();
    var objeto = {caso:'listar_consulta', estatus_proyectos:$('#estatus_proyectos').val(), ano_proyectos:$('#txt_ano_proyecto').val()};
    objeto = JSON.stringify(objeto);    
    $.post("../modelo/cls_cons_seguimiento_proyectos.php",{metodo:"LlenarProyectos",parametros:objeto},function(resp_x){
        if (resp_x){
            $('#listado tbody').append(resp_x.html);
        }else{
            jAlert('Disculpe, no se encontraron coincidencias', 'Confirmación de Proceso');
        }
    },"json");    
    
}
