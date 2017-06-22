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
<script type="text/JavaScript" src="../controlador/credito.js"></script>

<form>
<table id="formulario" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td id="titulo" colspan="5" class="etiqueta">Titulo del formulario...</td>
    </tr>
    <?php include('menu_formulario.php'); ?>
    <tr>
    <td height="133" valign="top">
	  	<div  style="overflow:auto;height:456px;">
		<table cellpadding="0" cellspacing="0" border="0" width="830px">
			<tr>
					<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
			  <td class="etiqueta"><label for="sel_tipo_artista">Tipo Artista:</label></td>
			  <td><select name="sel_tipo_artista" id="sel_tipo_artista" class="select"></select></td>
			  <td width="2%" rowspan="5">&nbsp;</td>
			  <td align="right"><label for="sel_artista">Artista:</label></td>
			  <td><select name="sel_artista" id="sel_artista" class="select"></select></td>
		</tr>
			<tr>
			  <td class="etiqueta"><label for="sel_tipo_artista">Proyecto:</label></td>
			  <td><select name="sel_proyecto" id="sel_proyecto" class="select"></select></td>
			  <td>&nbsp;</td>
			  <td><label id="lbl_nombre_proyecto"></label></td>
		</tr>
			<tr>
				 <td width="20%" class="etiqueta"><label for="txt_productor_musical"><span class="requerido">*</span> Productor Musical:</label></td>
				 <td width="29%"><input name="txt_productor_musical" type="text" class="input" id="txt_productor_musical" maxlength="100" /></td>
				 <td width="20%" align="right"><label for="txt_productor_ejecutivo"><span class="requerido">*</span> Productor Ejecutivo:</label></td>
				 <td width="29%"><input name="txt_productor_ejecutivo" type="text" class="input" id="txt_productor_ejecutivo" maxlength="100"/></td>
			</tr>
			<tr>
			  <td align="right" class="etiqueta"><label for="txt_arreglista">Arreglista:</label></td>
					<td><input name="txt_arreglista" type="text" class="input" id="txt_arreglista" maxlength="100" /></td>
					<td><label for="txt_ing_grabacion">Ingeniero Grabaci&oacute;n:</label></td>
					<td><input name="txt_ing_grabacion" type="text" class="input" id="txt_ing_grabacion" maxlength="100" /></td>
			</tr>
			<tr>
			  <td align="right" class="etiqueta"><label for="txt_ing_mezcla">Ingeniero Mezcla:</label></td>
					<td><input name="txt_ing_mezcla" type="text" class="input" id="txt_ing_mezcla" maxlength="100"/></td>
					<td><label for="txt_ing_masterizacion" style="width: 100%">Ingeniero Masterizaci&oacute;n:</label></td>
					<td><input name="txt_ing_masterizacion" type="text" class="input" id="txt_ing_masterizacion" maxlength="100" /></td>
			</tr>
			<tr>
				<td style="vertical-align: top;"><label for="txt_otros">Otros Creditos:</label></td>
				<td colspan="4"><textarea name="txt_otros" id="txt_otros" cols="80" rows="5"></textarea></td>
			</tr>
			<tr>
				<td style="vertical-align: top;"><label for="txt_credito_interpretes" style="height:40px;">Interpretes e Instrumentistas:</label></td>
				<td colspan="4"><textarea name="txt_credito_interpretes" id="txt_credito_interpretes" cols="80" rows="5"></textarea></td>
			</tr>             
		</table>
		</div>
        </td>
    </tr>    
</table>        
 
        
<input type="hidden" name="hid_proyecto" id="hid_proyecto" />
<input type="hidden" name="hid_credito" id="hid_credito" />
<input type="hidden" name="prms" id="prms" />
<div id="div_form"></div>
<div id="div_loading"></div>
</form>