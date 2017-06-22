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
<script type="text/JavaScript" src="../controlador/usuario.js"></script>

<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
<form>
<table id="formulario" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td id="titulo" colspan="5" class="etiqueta">Titulo del formulario...</td>
    </tr>
    <?php include('menu_formulario.php'); ?>
    <tr>
    <td valign="top">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>
			<tr>
				<td width="30%" align="right" class="etiqueta"><label for="txt_usuario_nombre"><span class="requerido">*</span> Nombre:</label></td>
				<td><input type="text" name="txt_usuario_nombre" id="txt_usuario_nombre" class="input" /></td>
			</tr>
			<tr>
				<td align="right" class="etiqueta"><label for="txt_usuario_apellido"><span class="requerido">*</span> Apellido:</label></td>
				<td><input type="text" name="txt_usuario_apellido" id="txt_usuario_apellido" class="input" /></td>
			</tr>
			<tr>
				<td align="right" class="etiqueta"><label for="txt_usuario_cedula" style="width:auto"><span class="requerido">*</span> Cedula Identida o Pasaporte:</label></td>
				<td><input type="text" name="txt_usuario_cedula" id="txt_usuario_cedula" class="input" /></td>
			</tr>
			<tr>
				<td align="right" class="etiqueta"><label for="txt_usuario_user"><span class="requerido">*</span> Usuario:</label></td>
				<td><input type="text" name="txt_usuario_user" id="txt_usuario_user" class="input" /></td>
			</tr>
			<tr>
				<td align="right" class="etiqueta"><label for="txt_usuario_pws"><span class="requerido">*</span> Contrase&ntilde;a:</label></td>
				<td><div class="psw"><input type="password" name="txt_usuario_pws" id="txt_usuario_pws" class="input" /></div></td>
			</tr>
			<tr>
			  <td align="right" class="etiqueta"><label for="txt_confirme_usuario_pws"><span class="requerido">*</span> Confirme Contrase&ntilde;a:</label></td>
			  <td><div class="psw"><input type="password" name="txt_confirme_usuario_pws" id="txt_confirme_usuario_pws" class="input" /></div></td>
		  </tr>
			<tr>
				<td align="right" class="etiqueta"><label for="sel_usuario_estatus"><span class="requerido">*</span> Estatus:</label></td>
				<td><select id="sel_usuario_estatus" name="sel_usuario_estatus" class="select"></select></td>
			</tr>
		</table>
    </td>
    </tr>
</table>
<input type="hidden" name="hid_usuario" id="hid_usuario" />
<input type="hidden" name="prms" id="prms" />
<div id="div_form"></div>
<div id="div_loading"></div>
</form>