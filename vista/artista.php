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
<script type="text/javascript" src="../shared/lib/jquery/js/jquery.numeric.js"></script>

<script type="text/javascript" src="../shared/lib/jquery/js/alerts/jquery.alerts.js" ></script>

<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.autocomplete.js"></script>
<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.position.js"></script>
<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../shared/lib/jquery/js/ui/jquery.ui.datepicker-es.js"></script>

<script type="text/JavaScript" src="../shared/js/fungralp.js"></script>
<script type="text/JavaScript" src="../controlador/artista.js"></script>

<form>
<table id="formulario" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td id="titulo" colspan="5" class="etiqueta">Titulo del formulario...</td>
    </tr>
    <?php include('menu_formulario.php'); ?>
    <tr>
    <td valign="top">
		<div  style="overflow:auto;height:456px;">
        <table cellpadding="0" cellspacing="0" border="0">
            <tr>
            	<td colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <td width="20%" align="right" class="etiqueta"><label for="txt_nombre_artista"><span class="requerido">*</span> Nombre:</label></td>
                <td width="29%"><input name="txt_nombre_artista" type="text" class="input" id="txt_nombre_artista" maxlength="256" />
                <div style="display: none;" class="demo-description">
          </td>
                <td width="2%" rowspan="7">&nbsp;</td>
                <td width="20%" align="right"><label class="cedula_artista" for="txt_cedula_artista"><span class="requerido">*</span> Cedula:</label></td>
            <td width="29%"><div class="cedula_artista"><input name="txt_cedula_artista" type="text" class="input" id="txt_cedula_artista" maxlength="10"/>
            </div></td>
            </tr>
            <tr>
              <td align="right" class="etiqueta"><label for="sel_tipo_artista"><span class="requerido">*</span> Tipo Artista:</label></td>
              <td colspan="3"><select id="sel_tipo_artista" name="sel_tipo_artista" class="select"></select></td>
            </tr>
            <tr>
              <td align="right" class="etiqueta"><label class="representante" for="txt_cedula_representante_artistico">Cedula Representante:</label></td>
              <td><div class="representante"><input name="txt_cedula_representante_artistico" type="text" class="input" id="txt_cedula_representante_artistico" maxlength="10" /></div></td>
              <td align="right"><label class="representante" for="txt_nombre_representante_artistico"><span class="requerido">*</span> Nombre Representante:</label></td>
              <td><div class="representante"><input name="txt_nombre_representante_artistico" type="text" class="input" id="txt_nombre_representante_artistico" maxlength="100" /></div></td>
            </tr>
            <tr>
                <td align="right" class="etiqueta"><label for="sel_nacionalidad"><span class="requerido">*</span> Nacionalidad:</label></td>
                <td><select id="sel_nacionalidad" name="sel_nacionalidad" class="select"></select></td>
                <td align="right"><label for="sel_pais"><span class="requerido">*</span> País de Origen:</label></td>
                <td><select id="sel_pais" name="sel_pais" class="select"></select></td>
            </tr>
            <tr>
              <td align="right" class="etiqueta"><label for="sel_sexo"><span class="requerido">*</span> Sexo:</label></td>
              <td><select id="sel_sexo" name="sel_sexo" class="select"></select></td>
              <td align="right"><label for="txt_fecha_ingreso_artista"><span class="requerido">*</span> Fecha Ingreso:</label></td>
              <td><input name="txt_fecha_ingreso_artista" type="text" class="input" id="txt_fecha_ingreso_artista" style="width:80px;" size="10" maxlength="0"/></td>
            </tr>
            <tr>
                <td align="right" class="etiqueta"><label for="txt_telefono_habitacion"><span class="requerido">*</span> Tel&eacute;fono Habitaci&oacute;n</label></td>
                <td><input name="txt_telefono_habitacion" type="text" class="input" id="txt_telefono_habitacion" maxlength="64" /></td>
                <td align="right"><label for="txt_telefono_celular"><span class="requerido">*</span> Tel&eacute;fono Celular</label></td>
                <td><input name="txt_telefono_celular" type="text" class="input" id="txt_telefono_celular" maxlength="64" /></td>
            </tr>
            <tr>
                <td align="right" class="etiqueta"><label for="txt_telefono_otro">Tel&eacute;fono Otro</label></td>
                <td><input name="txt_telefono_otro" type="text" class="input" id="txt_telefono_otro" maxlength="64" /></td>
                <td align="right"><label for="txt_email_artista">Correo</label></td>
                <td><input type="text" name="txt_email_artista" id="txt_email_artista" class="input" /></td>
            </tr>
            <tr>
                <td style="vertical-align: top;"><label for="txt_direccion_artista"><span class="requerido">*</span> Direcci&oacute;n</label></td>
                <td colspan="4"><textarea name="txt_direccion_artista" id="txt_direccion_artista" maxlength="256" cols="45" rows="5"></textarea></td>
            </tr>
            <tr>
                <td align="right" class="etiqueta"><label for="sel_estado">Estado:</label></td>
                <td><select id="sel_estado" name="sel_estado" class="select"></select></td>
                <td width="1%">&nbsp;</td>
                <td align="right"><label for="sel_municipio">Municipio:</label></td>
                <td><select id="sel_municipio" name="sel_municipio" class="select"></select></td>
            </tr>
        </table>
		</div>
    </td>
    </tr>
</table>
-
<input type="hidden" name="hid_artista" id="hid_artista" />
<input type="hidden" name="prms" id="prms" />
<div id="div_form"></div>
<div id="div_loading"></div>
</form>