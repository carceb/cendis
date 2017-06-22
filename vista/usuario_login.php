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
<?php
session_start();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema integrado de seguimiento sisCENDIS</title>
<link type="text/css" href="../shared/css/estilo.css" rel="stylesheet" />
<link type="text/css" href="../shared/css/formulario.css" rel="stylesheet" />
<link type="text/css" href="../shared/lib/jquery/css/alerts/jquery.alerts.css" rel="stylesheet" media="screen" />
<script type="text/javascript" src="../shared/lib/jquery/js/jquery.js"></script>
<script type="text/javascript" src="../shared/lib/jquery/js/alerts/jquery.alerts.js" ></script>
<script type="text/JavaScript" src="../controlador/autentic.js" language="JavaScript"></script>
</head>

<body>
    <div id="login">
        <div id="login_superior">Usuario</div>
        <div id="login_inferior">
            <div id="login_interno">
                <table cellpadding="0" cellspacing="0" style="width:390px;padding-left: 5px;">
                    <tbody>
                        <tr>
                            <td colspan="2"><div style="margin-left: 120px;" id="img_CENDIS"></div></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center"><h1>Iniciar sesi&oacute;n</h1></td>
                        </tr>
                        <tr>
                            <td style="white-space: nowrap; padding-bottom: 9px;text-align:right">Usuario:</td>
                            <td style="white-space: nowrap; width: 250px; padding: 2px 0 9px 7px"><input type="text" name="txt_usuario" id="txt_usuario" /></td>
                        </tr>
                        <tr>
                            <td style="white-space: nowrap; padding-bottom: 9px;text-align:right">Contrase&ntilde;a:</td>
                            <td style="white-space: nowrap; padding: 2px 0 9px 7px"><input type="password" name="txt_clave" id="txt_clave" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;"><input type="button" id="Entrar" value="Continuar"></input></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center">﻿Sistema integrado de seguimiento sisCENDIS</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
