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
        $('#sel_tipo_artistaVM').val('');
        $('#sel_artistaVM').html('');
        $('#sel_proyectoVM').html(''); 
        $('#grilla').remove();
        $('#tb_cabeceragrilla').hide();
    });
    llenaCombox('','tipo_artistaVM');
    $('#sel_tipo_artistaVM').change(function(){
        var objeto = {
            dependencia:'tipo_artista',
            dependencia_id:$('#sel_tipo_artistaVM').val()};
        llenaCombox('','artistaVM','',objeto);
    });
    
    $('#sel_artistaVM').change(function(){
        var objeto = {
            dependencia:'artista',
            dependencia_id:$('#sel_artistaVM').val()};
        llenaCombox('','proyectoVM','',objeto);
    });
    
    $('#vm_Buscar').click(function(){//busca �l o los registros
        $.post("../modelo/cls_catalogo.php",{metodo:"cargaGrilla",parametros:$('#sel_proyectoVM').val()},function(resp_x){
            if(resp_x){
                montarDatosCatalogo(resp_x.proyecto_id,
                resp_x.nombre_proyecto,
                resp_x.artista_id,
                resp_x.tipo_artista_id,
                resp_x.numero_deposito_legal,
                resp_x.direccion,
                resp_x.direccion_fecha,
                resp_x.carta_compromiso_autoria,
                resp_x.carta_compromiso_autoria_fecha,
                resp_x.carta_buena_fe,
                resp_x.carta_buena_fe_fecha,
                resp_x.deposito_legal,
                resp_x.deposito_legal_fecha,
                resp_x.representante_legal,
                resp_x.representante_legal_fecha,
                resp_x.acta_constitutiva,
                resp_x.acta_constitutiva_fecha,
                resp_x.copia_rif,
                resp_x.copia_rif_fecha,
                resp_x.copia_cedula,
                resp_x.copia_cedula_fecha,
                resp_x.letras,
                resp_x.letras_fecha,
                resp_x.listado_interprete,
                resp_x.listado_interprete_fecha,
                resp_x.autorizacion_replica,
                resp_x.autorizacion_replica_fecha,
                resp_x.exoneracion_derecho,
                resp_x.exoneracion_derecho_fecha,
                resp_x.nombre_definitivo,
                resp_x.nombre_definitivo_fecha,
                resp_x.master_produccion,
                resp_x.master_produccion_fecha,
                resp_x.fotografias,
                resp_x.fotografias_fecha,
                resp_x.numero_produccion,
                resp_x.tipo_estuche_id,
                resp_x.nombre_artista);
                $('#iconQR').show();
                }else{
                $('#iconQR').hide();
                }
                },"json");
    	close_form();
    });

    $('#vm_Salir').click(function(){// sale del catalogo.
        parent.$('#ventana_actual').attr('style',$('#haltoventana').val());
        close_form();
    });
});