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
<script type="text/JavaScript" src="../controlador/usuario_grupo.js"></script>

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
            	<td colspan="3" >&nbsp;</td>
            </tr>
			<tr>
                <td width="20%" align="right" class="etiqueta"><label for="sel_grupo">Grupo:</label></td>
                <td width="30%" ><select id="sel_grupo" name="sel_grupo" class="select"></select></td>
                <td width="50%" ><label style="width:100%;text-align:left;" id="lbl_nombre_grupo"></label></td>
			</tr>
            <tr>
              <td align="right" class="etiqueta"><label for="sel_usuario">Usuario:</label></td>
              <td><select id="sel_usuario" name="sel_usuario" class="select"></select></td>
              <td><label style="width:100%;text-align:left;" id="lbl_nombre_usuario"></label></td>
            </tr>
		</table>
    </td>
    </tr>
	<tr>
        <td valign="top" style="overflow:auto;width:100px;">
			<div  style="overflow:auto;height:200px;">
				<table id="usuarios" cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr style="background-color:#333333;font-weight:bold;text-align:center;color:#FFFFFF;">
						<td colspan="3">LISTADO DE USUARIOS</td>
					</tr>
					<tr style="background-color:#666666;color:#FFFFFF;font-weight:bold;">
						<td style="width:20%">&nbsp;Usuario</td>
						<td style="width:75%">&nbsp;Nombre</td>
						<td style="width:5%">&nbsp;Opci&oacute;n</td>
					</tr>
					<tr style="background-color:#CCCCCC;" id="1" class="fila_usuarios">
						<td>&nbsp;1</td>
						<td>&nbsp;Reckless Life </td>
						<td id="decision">
						<a href="#" onclick="eliminar(1)"><div class="liked"></div></a>
						</td>
					</tr>
				</table>
			</div>
		</td>
    </tr>
</table>
<input type="hidden" name="hid_grupo" id="hid_grupo" />
<input type="hidden" name="hid_usuario" id="hid_usuario" />
<input type="hidden" name="prms" id="prms" />
<div id="div_form"></div>
<div id="div_loading"></div>
</form>