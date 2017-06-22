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
<link type="text/css" href="../shared/css/estilosv.css" rel="stylesheet" />

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
<script type="text/JavaScript" src="../controlador/rpt_reportes_varios.js"></script>

<form name="frm_gestion_cendis" id="frm_gestion_cendis">
<table id="formulario" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td id="titulo" colspan="5" class="etiqueta">Titulo del formulario...</td>
    </tr>
    <?php include('menu_formulario.php'); ?>
    <tr>
    <td valign="top">
                <table width="835px" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="width:30%;">&nbsp;</td>
                        <td style="width:30%;">&nbsp;</td>
                        <td style="width:30%;">&nbsp;</td>
                        <td style="width:20%;">&nbsp;</td>
                        <td style="width:30%;">&nbsp;</td>
                  </tr>
                <tr>
                    <td align="right" class="etiqueta"><label for="sel_tipo_reporte">Tipo:</label></td>
                    <td width="1%">&nbsp;</td>
                  <td><select id="sel_tipo_reporte" name="sel_tipo_reporte" class="select">
                    <option value="1">Nº de titulos por genero musical</option>
                    <option value="2">Nº de titulos por estado</option>
                    <option value="3">Nº de titulos por municipio</option>
                    <option value="4">Nº de artistas femeninas</option>
                    <option value="5">Nº de titulos por linea editorial</option>
                    <option value="6">Nº de titulos por tipo de empaque</option>
                    <!--VALIDAR SI ESTE CRITERIO DEBE IR-->
                    <!--<option value="7">Nº de beneficiados</option>-->
                    <option value="8">Nº de aprobados por comisi&oacute;n art&iacute;stica</option>
                    <option value="9">Nº de rechazados por comisi&oacute;n art&iacute;stica</option>
                  </select></td>
                    <td><label for="txt_fecha_desde"><span class="requerido">*</span> Fecha Desde:</label></td>
                    <td><input name="txt_fecha_desde" type="text" class="input" id="txt_fecha_desde" style="width:80px;" size="10" maxlength="0" value="<?php echo date("d/m/Y");?>" /></td>
                    <td width="50px"><label for="txt_fecha_hasta"><span class="requerido">*</span> Fecha Hasta:</label></td>
                    <td><input name="txt_fecha_hasta" type="text" class="input" id="txt_fecha_hasta" style="width:80px;" size="10" maxlength="0" value="<?php echo date("d/m/Y");?>" /></td>
                </tr>
                <tr>
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                </table>
        </td>
    </tr>
</table>
<input type="hidden" name="hid_proyecto" id="hid_proyecto" />
<input type="hidden" name="hid_produccion_industrial" id="hid_produccion_industrial" />
<input type="hidden" name="prms" id="prms" /><div id="div_form"></div>
<div id="div_loading"></div>
</form>