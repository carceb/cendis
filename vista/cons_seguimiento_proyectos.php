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
<script type="text/JavaScript" src="../controlador/cons_seguimiento_proyectos.js"></script>
<form>
<table id="formulario" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td id="titulo" colspan="5" class="etiqueta">Titulo del formulario...</td>
    </tr>
        <?php include('menu_formulario.php'); ?>
    <tr>
 
    <td valign="top">
        <table id="seguimiento" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
            	<td colspan="6">&nbsp;</td>
            </tr>
                <tr style="background-color:#333333;font-weight:bold;text-align:center;color:#FFFFFF;">
            	<td colspan="6">PROYECTOS AÑO: 
                    <input type="text" name="txt_ano_proyecto" id="txt_ano_proyecto" value="<?php echo date("Y");?>"/>
                </td>
            </tr>
		<tr style="background-color:#666666;color:#FFFFFF;font-weight:bold;">
            	<td style="width:10%">&nbsp;Estatus del Proyecto</td>
                <td style="width:10%">&nbsp;Cantidad</td>
            </tr>
	    <tr style="background-color:#CCCCCC;" id="1" class="fila_seguimiento">
            	<td id="estatus_1">&nbsp;ESTATUS XXX</td>
                <td id="cantidad_1">&nbsp;000000</td>
            </tr>
        </table>
		
	  </td>
    </tr>
</table>
<input type="hidden" name="prms" id="prms" />
<input type="hidden" name="estatus_proyectos" id="estatus_proyectos" />
<div id="div_form"></div>
<div id="div_loading"></div>
</form>