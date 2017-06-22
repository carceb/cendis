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
    $('.fila_diseno').remove();
    $.post("../modelo/cls_revision.php",{metodo:"listarGrilla",parametros:''},function(resp_x){
        if (resp_x){
            $('#listado tbody').append(resp_x.html);
        }else{
            jAlert('Disculpe, no se encontraron coincidencias', 'Confirmación de Proceso');
        }
    },"json");

    $('#vm_Salir').click(function(){// sale del catalogo.
        parent.$('#ventana_actual').attr('style',$('#haltoventana').val());
        close_form();
    });
});

function SeleccionarProyectoListar(proyecto_id){//se carga los datos en formulario que los solicit� al clicar en el registro solicitado y cierra el cat�logo.
    SeleccionarProyecto(proyecto_id);
    close_form();
}