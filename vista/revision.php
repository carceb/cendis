<!--
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
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="../shared/css/formulario.css" rel="stylesheet" />

<link type="text/css" href="../shared/lib/jquery/css/alerts/jquery.alerts.css" rel="stylesheet" media="screen" />

<link rel="stylesheet" href="../shared/lib/jquery/css/ui/jquery.ui.all.css">

<script type="text/javascript" src="../shared/lib/jquery/js/jquery.js"></script>
<script type="text/javascript" src="../shared/lib/jquery/js/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../shared/lib/jquery/js/alerts/jquery.alerts.js" ></script>

<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.datepicker-es.js"></script>

<script type="text/JavaScript" src="../shared/js/fungralp.js"></script>
<script type="text/JavaScript" src="../controlador/revision.js"></script>
<form>
<table id="formulario" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td id="titulo" colspan="5" class="etiqueta">Titulo del formulario...</td>
    </tr>
    <?php include('menu_formulario.php'); ?>
    <tr>
    <td valign="top">
		<div  style="overflow:auto;height:456px;">
        <table id="seleccionables" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
            	<td colspan="6">&nbsp;</td>
                </tr>
                    <tr style="background-color:#333333;font-weight:bold;text-align:center;color:#FFFFFF;">
                    <td colspan="6">SELECCIONABLES</td>
                </tr>
		<tr style="background-color:#666666;color:#FFFFFF;font-weight:bold;">
            	<td style="width:10%">&nbsp;Fecha</td>
                <td style="width:10%">&nbsp;Tipo Artista</td>
                <td style="width:30%">&nbsp;Artista</td>
                <td style="width:35%">&nbsp;Proyecto</td>
                <td style="width:10%">&nbsp;Genero</td>
                <td style="width:5%">&nbsp;Decisión</td>
            </tr>
	    <tr style="background-color:#CCCCCC;" id="1" class="fila_seleccionables">
            	<td id="fecha_1">&nbsp;01/01/2011</td>
                <td id="tipo_artista_1">&nbsp;Grupo</td>
                <td id="artista_1">&nbsp;Guns n" Roses</td>
                <td id="proyecto_1">&nbsp;Live ?!*@ Like a Suicide</td>
                <td id="genero_1">&nbsp;Rock</td>
                <td id="decision">
                <a href="#" onclick="agregar_aprobado(1)"><div class="like"></div></a>
                <a href="#" onclick="agregar_rechazado(1)"><div class="liked"></div></a>
                </td>
            </tr>
        </table>
		
		<table id="aprobados" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
            	<td colspan="6">&nbsp;</td>
            </tr>
			<tr style="background-color:#333333;font-weight:bold;text-align:center;color:#FFFFFF;">
            	<td colspan="6">APROBADOS</td>
            </tr>
			<tr style="background-color:#666666;color:#FFFFFF;font-weight:bold;">
            	<td style="width:10%">&nbsp;Fecha</td>
                <td style="width:10%">&nbsp;Tipo Artista</td>
                <td style="width:30%">&nbsp;Artista</td>
                <td style="width:35%">&nbsp;Proyecto</td>
                <td style="width:10%">&nbsp;Genero</td>
                <td style="width:5%">&nbsp;Decisión</td>
            </tr>
	    <tr style="background-color:#CCCCCC;" id="5" class="fila_aprobados">
            	<td id="fecha_5">&nbsp;01/01/2011</td>
                <td id="tipo_artista_5">&nbsp;Grupo</td>
                <td id="artista_5">&nbsp;Guns n" Roses</td>
                <td id="proyecto_5">&nbsp;Live ?!*@ Like a Suicide</td>
                <td id="genero_5">&nbsp;Rock</td>
                <td id="decision">
                        <a href="#" onclick="selecionable(5)"><div class="liked"></div></a>
                </td>
            </tr>
        </table>
		
		<table id="rechazados" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
            	<td colspan="7">&nbsp;</td>
            </tr>
		<tr style="background-color:#333333;font-weight:bold;text-align:center;color:#FFFFFF;">
            	<td colspan="7">RECHAZADOS </td>
            </tr>
                <tr style="background-color:#666666;color:#FFFFFF;font-weight:bold;">
            	<td style="width:10%">&nbsp;Fecha</td>
                <td style="width:10%">&nbsp;Tipo Artista</td>
                <td style="width:30%">&nbsp;Artista</td>
                <td style="width:35%">&nbsp;Proyecto</td>
                <td style="width:10%">&nbsp;Genero</td>
                <td style="width:10%">&nbsp;Motivo</td>
                <td style="width:5%">&nbsp;Decisión</td>
            </tr>
                    <tr style="background-color:#CCCCCC;" id="9" class="fila_rechazados">
            	<td id="fecha_9">&nbsp;01/01/2011</td>
                <td id="tipo_artista_9">&nbsp;Grupo</td>
                <td id="artista_9">&nbsp;Guns n" Roses</td>
                <td id="proyecto_9">&nbsp;Live ?!*@ Like a Suicide</td>
                <td id="genero_9">&nbsp;Rock</td>
                <td id="decision">
                        <a href="#" onclick="selecionable(9)"><div class="like"></div></a>
                </td>
            </tr>
        </table>
		</div>
    </td>
    </tr>
</table>
<input type="hidden" name="hid_artista" id="hid_artista" />
<input type="hidden" name="prms" id="prms" />
<div id="div_form"></div>
<div id="div_loading"></div>
</form>