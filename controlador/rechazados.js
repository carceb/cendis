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
    $('#titulo').html('Proyectos Rechazados por la Comisión Artística');
    
    //llenar grid seleccionables
    LlenarSolicitudes();
    
    $('#iconSalir').click(function(){
        parent.$('#ventana_actual').remove();
    });
    
    $('#iconBuscar').click(function(){//Visualiza el catalogo de ocupaciones.
        if($('#prms').data('pms_buscar')=='f'){msjAccss();return;}
        open_form('rechazados_catalogo','410','400','','div_form');
    });
    
    $('#iconLimpiar').click(function(){LlenarSolicitudes();});
    
});// Fin---$(document).ready(function().

function ActualizarEstatusProyecto(id){
    if($('#prms').data('pms_ingresar')=='f'){msjAccss();return;}
    var objeto = {proyecto_id:id,linea_editorial_id:0,comision_artistica_id:0,estatus_proyecto_id:1};
    objeto = JSON.stringify(objeto)
    $.post("../modelo/cls_rechazados.php",{metodo:"ActualizarEstatusProyecto",parametros:objeto},function(){},"json");//
    LlenarSolicitudes();
}

function LlenarSolicitudes(){
    $('.fila_rechazados').remove();var objeto = {caso:'listar_proyectos'};
    objeto = JSON.stringify(objeto);
    $.post("../modelo/cls_rechazados.php",{metodo:"LlenarSolicitudes",parametros:objeto},function(resp_x){
        $('#rechazados tbody').append(resp_x.html);
    },"json");//
}