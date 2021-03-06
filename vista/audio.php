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
<script type="text/JavaScript" src="../controlador/audio.js"></script>
<form name="frm_audio" id="frm_audio">
<table id="formulario" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td id="titulo" colspan="5" class="etiqueta">Titulo del formulario...</td>
    </tr>
    <?php include('menu_formulario.php'); ?>
    <tr>
    <td valign="top">
	  	<div  style="overflow:auto;height:456px;">
		<table width="835" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="width:30%;">&nbsp;</td>
			<td style="width:20%;">&nbsp;</td>
			<td style="width:30%;">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan="2" style="width:20%;"><label for="sel_tipo_artista">Tipo Artista:</label></td>
			<td><select name="sel_tipo_artista" id="sel_tipo_artista" class="select"></select></td>
			<td style="text-align:center"><label for="sel_artista">Artista:</label></td>
			<td><select name="sel_artista" id="sel_artista" class="select"></select></td>
		  </tr>
		  <tr>
				<td colspan="2"><label for="sel_proyecto">Proyecto:</label></td>
				<td><select name="sel_proyecto" id="sel_proyecto" class="select"></select></td>
				<td><label>Proyecto:</label></td>
		        <td><label id="lbl_nombre_proyecto" style="text-align:left"></label></td>
		  </tr>			 
		  <tr>
				<td colspan="2"><label>Nº Copias:</label></td>
				<td><label id="lbl_numero_copias" style="text-align:left"></label></td>
				<td><label>Nº Legal:</label></td>
		        <td><label id="lbl_numero_deposito_legal" style="text-align:left"></label></td>
		  </tr>                 

		  <tr>
				<td colspan="2"><label>Nº Producci&oacute;n:</label></td>
				<td><label id="lbl_numero_produccion" style="text-align:left"></label></td>
				<td colspan="2">&nbsp;</td>
	      </tr>   
		  <tr>
			<td style="text-align:center"><h4>FECHA REGISTRO</h4></td>
			<td style="width:3%;"><input type="checkbox" name="ckb_todos" id="ckb_todos" class="input" /></td>
			<td colspan="3"><h4>Fases del Proceso de Audio </h4></td>
		  </tr>
		  <tr class="Replicacion">
			<td><label id="revision_tecnica_replicacion_fecha" style="text-align:center" class="label_fecha"></label></td>
			<td><input type="checkbox" name="lista_audio" id="ckb_revision_tecnica_replicacion" class="input" /></td>
			<td><label for="ckb_revision_tecnica_replicacion" style="width:auto;text-align:left;font-size:11px;">REVISI&Oacute;N T&Eacute;CNICA</label></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr class="Replicacion">
			<td><label id="ddp_replicacion_fecha" style="text-align:center" class="label_fecha"></label></td>
			<td><input type="checkbox" name="lista_audio" id="ckb_ddp_replicacion" class="input" /></td>
			<td><label for="ckb_ddp_replicacion" style="width:auto;text-align:left;font-size:11px;">DDP</label></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr class="Replicacion">
			<td><label id="envio_fabrica_replicacion_fecha" style="text-align:center" class="label_fecha"></label></td>
			<td><input type="checkbox" name="lista_audio" id="ckb_envio_fabrica_replicacion" class="input" /></td>
			<td><label for="ckb_envio_fabrica_replicacion" style="width:auto;text-align:left;font-size:11px;">ENVIO A FABRICA</label></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr class="Grabacion">
			<td><label id="reunion_produccion_grabacion_fecha" style="text-align:center" class="label_fecha"></label></td>
			<td><input type="checkbox" name="lista_audio" id="ckb_reunion_produccion_grabacion" class="input" /></td>
			<td><label for="ckb_reunion_produccion_grabacion" style="width:auto;text-align:left;font-size:11px;">REUNION DE PRODUCCION</label></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr class="Grabacion">
			<td><label id="grabacion_grabacion_fecha" style="text-align:center" class="label_fecha"></label></td>
			<td><input type="checkbox" name="lista_audio" id="ckb_grabacion_grabacion" class="input" /></td>
			<td><label for="ckb_grabacion_grabacion" style="width:auto;text-align:left;font-size:11px;">GRABACION</label></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr class="Grabacion">
		    <td><label id="post_produccion_grabacion_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_audio" id="ckb_post_produccion_grabacion" class="input" /></td>
		    <td><label for="ckb_post_produccion_grabacion" style="width:auto;text-align:left;font-size:11px;">POST PRODUCCION</label></td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr class="Grabacion">
		    <td><label id="envio_fabrica_grabacion_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_audio" id="ckb_envio_fabrica_grabacion" class="input" /></td>
		    <td><label for="ckb_envio_fabrica_grabacion" style="width:auto;text-align:left;font-size:11px;">DDP</label></td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		</table>
		</div>
	  </td>
    </tr>
</table>
<input type="hidden" name="hid_proyecto" id="hid_proyecto" />
<input type="hidden" name="hid_tipo_proyecto" id="hid_tipo_proyecto" />
<input type="hidden" name="hid_audio" id="hid_audio" />
<input type="hidden" name="prms" id="prms" /><div id="div_form"></div>
<div id="div_loading"></div>
</form>