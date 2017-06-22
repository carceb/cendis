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
    $('#iconGuardar').hide();
    $('#titulo').html('Consulta de Proyectos');
    
    //llenar grid seleccionables
    LlenarSolicitudes();
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){
        if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
          LlenarSolicitudes();
    });
    
    $('#iconLimpiar').click(function(){LlenarSolicitudes();});
    
});// Fin---$(document).ready(function().


function LlenarSolicitudes(){
    $('.fila_seguimiento').remove();var objeto = {caso:'listar_proyectos', ano_proyectos:$('#txt_ano_proyecto').val()};
    objeto = JSON.stringify(objeto);
    $.post("../modelo/cls_cons_seguimiento_proyectos.php",{metodo:"LlenarSolicitudes",parametros:objeto},function(resp_x){
        $('#seguimiento tbody').append(resp_x.html);
    },"json");//
}

function mostrarListar($codigo_estatus){
    $('#estatus_proyectos').val($codigo_estatus);
    open_form('cons_seguimiento_proyectos_listar','800','500','','div_form');
}