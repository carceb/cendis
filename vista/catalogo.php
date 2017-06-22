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
<script type="text/JavaScript" src="../controlador/catalogo.js"></script>
<form name="frm_catalogo">

<table id="formulario" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td id="titulo" colspan="5" class="etiqueta">Titulo del formulario...</td>
    </tr>
    <?php include('menu_formulario.php'); ?>
    <tr>
    <td valign="top">
		<div  style="overflow:auto;height:475px;">
		<table width="835px" border="0" cellspacing="0" cellpadding="0">
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
			<td><img src="../imagenes/qrcode_icon.png" width="29" height="28" alt="Codigo QR"  id="iconQR" align="right"/></td>
                        <td><label id="lbl_nombre_proyecto" style="width:auto;text-align:left"></label></td>
		  </tr>
		  <tr>
			<td style="text-align:center"><h4>FECHA REGISTRO</h4></td>
			<td style="width:3%;"><input type="checkbox" name="ckb_todos" id="ckb_todos" class="input" /></td>
			<td colspan="3"><h4>REQUISITOS</h4></td>
		  </tr>
		  <tr>
			<td><label id="direccion_fecha" style="text-align:center" class="label_fecha"></label></td>
			<td><input type="checkbox" name="lista_requisito" id="ckb_direccion" class="input" /></td>
			<td colspan="3"><label for="ckb_direccion" style="width:auto;text-align:left;font-size:11px;">DIRECCIÓN DE HABITACIÓN (COMPLETA)</label></td>
		  </tr>
		  <tr>
			<td><label id="carta_compromiso_autoria_fecha" style="text-align:center" class="label_fecha"></label></td>
			<td><input type="checkbox" name="lista_requisito" id="ckb_carta_compromiso_autoria" class="input" /></td>
			<td colspan="3"><label for="ckb_carta_compromiso_autoria" style="width:auto;text-align:left;font-size:11px;">CARTA DE COMPROMISO DE AUTORIA</label></td>
		  </tr>
		  <tr>
		    <td><label id="carta_buena_fe_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_requisito" id="ckb_carta_buena_fe" class="input" style="text-align:right;" /></td>
		    <td colspan="3"><label for="ckb_carta_buena_fe" style="width:auto;text-align:left;font-size:11px;">ACTA DE COMPROMISO </label></td>
	      </tr>
		  <tr>
		    <td><label id="deposito_legal_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_requisito" id="ckb_deposito_legal" class="input" /></td>
		    <td><label for="ckb_deposito_legal" style="width:auto;text-align:left;font-size:11px;"><span class="requerido">*</span> COPIA DEPOSITO LEGAL</label></td>
	        <td colspan="2"><input name="txt_numero_deposito_legal" type="text" class="input" id="txt_numero_deposito_legal" maxlength="50"/></td>
          </tr>
		  <tr>
		    <td><label id="representante_legal_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_requisito" id="ckb_representante_legal" class="input" /></td>
		    <td colspan="3"><label for="ckb_representante_legal" style="width:auto;text-align:left;font-size:11px;">CARTA O DOCUMENTO DONDE SE CERTIFIQUE QUE EL ARTISTA POSEE REPRESENTANTE LEGAL (OPCIONAL)</label></td>
	      </tr>
		  <tr>
		    <td><label id="acta_constitutiva_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_requisito" id="ckb_acta_constitutiva" class="input" /></td>
		    <td colspan="3"><label for="ckb_acta_constitutiva" style="width:auto;text-align:left;font-size:11px;">COPIA ACTA CONSTITUTIVA SI ES UNA AGRUPACÓN O INSTITUCIÓN</label></td>
	      </tr>
		  <tr>
		    <td><label id="copia_rif_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_requisito" id="ckb_copia_rif" class="input" /></td>
		    <td colspan="3"><label for="ckb_copia_rif" style="width:auto;text-align:left;font-size:11px;">COPIA DEL RIF DE LA INSTITUCIÓN Y SU REPRESENTANTE</label></td>
	      </tr>
		  <tr>
		    <td><label id="copia_cedula_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_requisito" id="ckb_copia_cedula" class="input" /></td>
		    <td colspan="3"><label for="ckb_copia_cedula" style="width:auto;text-align:left;font-size:11px;">COPIA CEDULA DE IDENTIDAD DEL REPRESENTANTE Y/O ARTISTA</label></td>
	      </tr>
		  <tr>
		    <td><label id="letras_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_requisito" id="ckb_letras" class="input" /></td>
		    <td colspan="3"><label for="ckb_letras" style="width:auto;text-align:left;font-size:11px;">LETRAS DE LOS TEMAS (COMPLETAS)</label></td>
	      </tr>
		  <tr>
		    <td><label id="listado_interprete_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_requisito" id="ckb_listado_interprete" class="input" /></td>
		    <td colspan="3"><label for="ckb_listado_interprete" style="width:auto;text-align:left;font-size:11px;">PLANILLA DE LISTADO DE INTERPRETE E INSTRUMENTISTAS</label></td>
	      </tr>
		  <tr>
		    <td><label id="autorizacion_replica_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_requisito" id="ckb_autorizacion_replica" class="input" /></td>
		    <td colspan="3"><label for="ckb_autorizacion_replica" style="width:auto;text-align:left;font-size:11px;">PLANILLA DE AURORIZACIÓN DE REPLICA</label></td>
	      </tr>
		  <tr>
		    <td><label id="exoneracion_derecho_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_requisito" id="ckb_exoneracion_derecho" class="input" /></td>
		    <td colspan="3"><label for="ckb_exoneracion_derecho" style="width:auto;text-align:left;font-size:11px;">PLANILLA DE EXONERACIÓN DE DERECHOS DE AUTOR DE CADA UNO DE LOS TEMAS</label></td>
	      </tr>
		  <tr>
		    <td><label id="nombre_definitivo_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_requisito" id="ckb_nombre_definitivo" class="input" /></td>
		    <td colspan="3"><label for="ckb_nombre_definitivo" style="width:auto;text-align:left;font-size:11px;">NOMBRE DE LA PRODUCCIÓN DEFINITIVO</label></td>
	      </tr>
		  <tr>
		    <td><label id="master_produccion_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td><input type="checkbox" name="lista_requisito" id="ckb_master_produccion" class="input" /></td>
		    <td colspan="3"><label for="ckb_master_produccion" style="width:auto;text-align:left;font-size:11px;">MASTER DE LA PRODUCCIÓN DISCOGRÁFICA (EN CASO DE REPLICA)</label></td>
	      </tr>
            <tr>
                <td><label id="fotografias_fecha" style="text-align:center" class="label_fecha"></label></td>
                <td><input type="checkbox" name="lista_requisito" id="ckb_fotografias" class="input" /></td>
                <td colspan="3"><label for="ckb_fotografias" style="width:auto;text-align:left;font-size:11px;">FOTOGRAFIAS PARA LA ELABORACIÓN DEL DISEÑO DE LA PRODUCIÓN DISCOGRÁFICA</label></td>
            </tr>
		  <tr>
		    <td><label id="numero_prouduccion_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td></td>
		    <td><label style="width:auto;text-align:left;font-size:11px;"><span class="requerido">*</span> NUMERO DE PRODUCCION:</label></td>
	        <td colspan="2"><input name="txt_numero_produccion" type="text" class="input" id="txt_numero_produccion" maxlength="50"/></td>
          </tr>
	  <tr>
		    <td><label id="numero_tipo_estuche_fecha" style="text-align:center" class="label_fecha"></label></td>
		    <td></td>
		    <td><label style="width:auto;text-align:left;font-size:11px;"><span class="requerido">*</span> TIPO DE ESTUCHE:</label></td>
	              <td colspan="3"><select id="sel_tipo_estuche" name="sel_tipo_estuche" class="select"></select></td>
          </tr>          
		</table>
		</div>
    </td>
    </tr>
</table>
<input type="hidden" name="prms" id="prms" />
<input type="hidden" name="hid_catalogo" id="hid_catalogo" />
<input type="hidden" name="hid_proyecto" id="hid_proyecto" />
<input type="hidden" name="h_qr_proyecto" id="h_qr_proyecto" />
<div id="div_form"></div>
<div id="div_loading"></div>
</form>