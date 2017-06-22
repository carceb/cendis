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
<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.autocomplete.js"></script>
<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.position.js"></script>
<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.datepicker-es.js"></script>

<script type="text/JavaScript" src="../shared/js/fungralp.js"></script>
<script type="text/JavaScript" src="../controlador/interpretes_instrumentista.js"></script>

<form>
<table id="formulario" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td id="titulo" colspan="5" class="etiqueta">Titulo del formulario...</td>
    </tr>
    <?php include('menu_formulario.php'); ?>
    <tr>
    <td height="133" valign="top">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
			  <td class="etiqueta"><label for="sel_tipo_artista">Tipo Artista:</label></td>
			  <td><select name="sel_tipo_artista" id="sel_tipo_artista" class="select"></select></td>
			  <td width="2%" rowspan="6">&nbsp;</td>
			  <td align="right"><label for="sel_artista">Artista:</label></td>
			  <td><select name="sel_artista" id="sel_artista" class="select"></select></td>
		  </tr>
			<tr>
			  <td class="etiqueta"><label for="sel_tipo_artista">Proyecto:</label></td>
			  <td><select name="sel_proyecto" id="sel_proyecto" class="select"></select></td>
			  <td><label for="sel_tipo_artista">Tema:</label></td>
			  <td><select name="sel_tema" id="sel_tema" class="select"></select></td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td><label id="lbl_nombre_proyecto"></label></td>
			  <td>&nbsp;</td>
			  <td><label id="lbl_nombre_tema"></label></td>
		  </tr>
			<tr>
				<td width="20%" class="etiqueta"><label for="txt_nombre_interprete_instrumentista">Nombre :</label></td>
				<td width="29%"><input type="text" name="txt_nombre_interprete_instrumentista" id="txt_nombre_interprete_instrumentista" class="input" /></td>
				<td width="20%" align="right"><label for="sel_instrumento">Tipo:</label></td>
				<td width="29%"><select name="sel_instrumento" id="sel_instrumento" class="select"></select>
				</td>
			</tr>
		</table>
    </td>
    </tr>
	<tr>
        <td valign="top">
	    <table id="interprete_instrumentista" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
            	<td colspan="5">&nbsp;</td>
            </tr>
            <tr style="background-color:#333333;font-weight:bold;text-align:center;color:#FFFFFF;">
            	<td colspan="5">LISTADO DE INTERPRETES E INSTRUMENTISTA</td>
            </tr>
            <tr style="background-color:#666666;color:#FFFFFF;font-weight:bold;">
            	<td style="width:30%">Proyecto</td>
                <td style="width:30%">Tema</td>
                <td style="width:20%">Nombre</td>
                <td style="width:15%">Instrumento</td>
                <td style="width:5%">&nbsp;Opci&oacute;n</td>
            </tr>
	    <tr style="background-color:#CCCCCC;" id="1" class="fila_interprete_instrumentista">
            	<td id="nombre_tema_1">&nbsp;Reckless Life </td>
                <td id="autor_letra_1">&nbsp;Guns N' Roses</td>
                <td id="autor_musica_1">&nbsp;Guns n" Roses</td>
                <td id="arreglo_1">&nbsp;Guns N' Roses</td>
                <td id="decision">
                <a href="#" onclick="modificar(1)"><div class="like"></div></a>
                <a href="#" onclick="eliminar(1)"><div class="liked"></div></a>                </td>
            </tr>
        </table>
		</td>
    </tr>
</table>
<input type="hidden" name="hid_interprete_instrumentista" id="hid_interprete_instrumentista" />
<input type="hidden" name="hid_tema" id="hid_tema" />
<input type="hidden" name="prms" id="prms" />
<div id="div_form"></div>
<div id="div_loading"></div>
</form>