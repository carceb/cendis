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
<script language="JavaScript" type="text/JavaScript" src="../controlador/instrumento_catalogo.js"></script>
<form name="form1" method="post" action="" />
    <table width="410" border="0" align="center" cellpadding="0" cellspacing="0" class="contorno">
        <tr id="menu">
            <td colspan="2"><div class="_form_close_bar"><img id="vm_Salir" class="vm_salir"/></div></td>
        </tr>
        <tr id="top">
          <td height="1" colspan="2" style="background-color:#CCCCCC"></td>
        </tr>
        <tr class="titulo_catalogo">
            <td height="22" colspan="2" align="center">Catalogo de Instrumentos Musicales </td>
        </tr>
        <tr>
            <td width="150" height="22" align="right">Nombre Instrumento Musical:</td>
            <td width="250"><input name="txt_instrumentoVM" type="text" id="txt_instrumentoVM" size="25" class="input" /></td>
        </tr>
        <tr>
      <td height="40" colspan="2" align="center" valign="bottom"><table width="400" border="0" class="formato-blanco">
        <tr>
          <td width="96" align="center"><input type="button" name="vm_Buscar" id="vm_Buscar" value="Buscar" class="input" /></td>
          <td width="96" align="center"><input type="button" name="vm_Limpiar" id="vm_Limpiar" value="Limpiar" alt="Haga para limpiar" title="Haga para limpiar" class="input" /></td>
        </tr>
      </table></td>
  </tr>
  </table>
  <br />
  <table id="tb_cabeceragrilla" width="400" border="0" align="center" cellpadding="0" cellspacing="2" class="contorno">
    <tr>
      <td align="center">
      <div id="scrolltb" class="scroll_tabla" style="height:140px"></div>      
      </td>
    </tr>
  </table>