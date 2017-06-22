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
<script type="text/JavaScript" src="../controlador/repertorio.js"></script>

<form>
<table id="formulario" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td id="titulo" colspan="5" class="etiqueta">Titulo del formulario...</td>
    </tr>
    <?php include('menu_formulario.php'); ?>
    <tr>
    <td height="133" valign="top">
	  <div  style="overflow:auto;height:456px;">
	  <table cellpadding="0" cellspacing="0" border="0" width="835px">
        <tr>
          <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td class="etiqueta"><label for="sel_tipo_artista">Tipo Artista:</label></td>
          <td><select name="sel_tipo_artista" id="sel_tipo_artista" class="select">
          </select></td>
          <td width="2%" rowspan="5">&nbsp;</td>
          <td align="right"><label for="sel_artista">Artista:</label></td>
          <td><select name="sel_artista" id="sel_artista" class="select">
          </select></td>
        </tr>
        <tr>
          <td class="etiqueta"><label for="sel_tipo_artista">Proyecto:</label></td>
          <td><select name="sel_proyecto" id="sel_proyecto" class="select">
          </select></td>
          <td>&nbsp;</td>
          <td><label id="lbl_nombre_proyecto" style="width:auto;text-align:left"></label></td>
        </tr>
        <tr>
          <td width="20%" class="etiqueta"><label for="txt_nombre_tema"><span class="requerido">*</span> Titulo del tema :</label></td>
          <td width="29%"><input name="txt_nombre_tema" type="text" class="input" id="txt_nombre_tema" maxlength="256" /></td>
          <td width="20%" align="right"><label for="txt_autor_letra"><span class="requerido">*</span> Autor Letra:</label></td>
          <td width="29%"><input name="txt_autor_letra" type="text" class="input" id="txt_autor_letra" maxlength="100"/></td>
        </tr>
        <tr>
          <td align="right" class="etiqueta"><label for="txt_autor_musica"><span class="requerido">*</span> Autor Musica:</label></td>
          <td><input name="txt_autor_musica" type="text" class="input" id="txt_autor_musica" maxlength="100" /></td>
          <td><label for="txt_arreglo"><span class="requerido">*</span> Arreglo:</label></td>
          <td><input name="txt_arreglo" type="text" class="input" id="txt_arreglo" maxlength="100" /></td>
        </tr>
        <tr>
          <td align="right" class="etiqueta"><label for="sel_genero_musical"><span class="requerido">*</span> Genero Músical:</label></td>
          <td><select id="sel_genero_musical" name="sel_genero_musical" class="select">
          </select></td>
          <td><label for="txt_duracion"><span class="requerido">*</span> Duración:</label></td>
          <td><input name="txt_duracion" type="text" class="input" id="txt_duracion" maxlength="10" /></td>
        </tr>
        <tr>
          <td align="right" class="etiqueta"><label for="sel_genero_musical">Track:</label></td>
          <td><select name="select" class="select" id="sel_track" style="width:40px;">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">1</option>
              <option value="26">2</option>
              <option value="27">3</option>
              <option value="28">4</option>
              <option value="29">5</option>
              <option value="30">6</option>
              <option value="31">7</option>
              <option value="32">8</option>
              <option value="33">9</option>
              <option value="34">10</option>
              <option value="35">11</option>
              <option value="36">12</option>
              <option value="37">13</option>
              <option value="38">14</option>
              <option value="39">15</option>
              <option value="40">16</option>
              <option value="41">17</option>
              <option value="42">18</option>
              <option value="43">19</option>
              <option value="44">20</option>
              <option value="45">21</option>
              <option value="46">22</option>
              <option value="47">23</option>
              <option value="48">24</option>            
              <option value="49">24</option>            
              <option value="50">24</option>            
          </select></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td colspan="5">
		  	<div  style="overflow:auto;height:200px;">
			<table id="temas" cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td colspan="8">&nbsp;</td>
				</tr>
				<tr style="background-color:#333333;font-weight:bold;text-align:center;color:#FFFFFF;">
					<td colspan="8">LISTADO DE REPERTORIO</td>
				</tr>
				<tr style="background-color:#666666;color:#FFFFFF;font-weight:bold;">
					<td style="width:5%">N&deg;</td>
					<td style="width:15%">Nombre</td>
					<td style="width:20%">Letra</td>
					<td style="width:20%">Musica</td>
					<td style="width:20%">Arreglo</td>
					<td style="width:5%">Duración</td>
					<td style="width:10%">&nbsp;Genero</td>
					<td style="width:5%">&nbsp;Opci&oacute;n</td>
				</tr>
				<tr style="background-color:#CCCCCC;" id="1" class="fila_temas">
					<td>1</td>
					<td>&nbsp;Reckless Life </td>
					<td>&nbsp;Guns N' Roses</td>
					<td>&nbsp;Guns n" Roses</td>
					<td>&nbsp;Guns N' Roses</td>
					<td>3:26</td>
					<td>&nbsp;Rock</td>
					<td id="decision">
						<a href="#" onclick="modificar(1)"><div class="like"></div></a>
						<a href="#" onclick="eliminar(1)"><div class="liked"></div></a>                </td>
				</tr>
			</table>
			</div>
			</td>
        </tr>
      </table>
	  </div>
	  </td>
    </tr>
</table>
<input type="hidden" name="hid_proyecto" id="hid_proyecto" />
<input type="hidden" name="hid_tema" id="hid_tema" />
<input type="hidden" name="prms" id="prms" />
<div id="div_form"></div>
<div id="div_loading"></div>
</form>