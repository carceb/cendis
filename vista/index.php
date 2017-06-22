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
<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sistema integrado de seguimiento sisCENDIS</title>
    <link type="text/css" href="../shared/css/estilo.css" rel="stylesheet" />
    <script type="text/javascript" src="../shared/lib/jquery/js/jquery-1.4.2.min.js"></script>
    <script type="text/JavaScript" src="../shared/js/menuppal.js"></script>
    <script type="text/JavaScript" src="../shared/js/fungralp.js"></script>
</head>
<body>
	<div id="contenedor">
    	<div id="menu">
            <a href="javascript: sub_menu('solicitud');" class="item">Solicitudes</a>
            <a href="javascript: sub_menu('comision');" class="item" style="width: 150px;">Comisi&oacute;n Art&iacute;stica</a>
            <a href="javascript: sub_menu('produccion');" class="item">Producción</a>
            <!--
            Se eliminó este menú debido a que ahora el proceso de fabrica se realizara en modulos
            independietes: Operaciones y Distribucion
            23-07-12
            <a href="javascript: sub_menu('fabrica');" class="item">Fabrica</a>
            -->
            <a href="javascript: sub_menu('ajustes');" class="item">Ajustes</a>
            <a href="javascript: sub_menu('reporte');" class="item">Reportes</a>
            <a href="javascript: sub_menu('seguridad');" class="item">Seguridad</a>
            <a href="javascript: sub_menu('salir');" class="item">Salir</a>
            <div id="usuario">Usuario:&nbsp;<?php echo $_SESSION['usuario_nombre'];?>&nbsp;<a id="perfil" href="#"></a></div>
        </div>
        <div id="iframe">
            
        </div>
        <div id="botonera">
            <div id="cont_botonera">
                <div id="solicitud" class="sub_menu">
                    <a id="boton" href="javascript: ventana('artista');"><div id="flecha"></div>Artista o Grupo</a>
                    <a id="boton" href="javascript: ventana('proyecto');"><div id="flecha"></div>Proyecto Musical</a>
                </div>
                <div id="comision" class="sub_menu">
                    <a id="boton" href="javascript: ventana('revision');"><div id="flecha"></div>Revisión de Proyectos</a>
                    <a id="boton" href="javascript: ventana('linea_editorial');"><div id="flecha"></div>L&iacute;nea Editorial</a>
                    <a id="boton" href="javascript: ventana('rechazados');"><div id="flecha"></div>Rechazados</a>
                </div>
                <div id="produccion" class="sub_menu">
                    <a id="boton" href="javascript: ventana('catalogo');"><div id="flecha"></div>Catalogo</a>
                    <div class="sub_catalogo">
                        <a id="boton" href="javascript: ventana('repertorio');"><div id="flecha"></div>Repertorio</a>
                        <a id="boton" href="javascript: ventana('credito');"><div id="flecha"></div>Creditos</a>
                        <!-- COMENTARIO:
                        fecha:10/12/2011
                        descripcion:desabilitado debido a requerimiento del cendis, los interpretes e instrumentista se cargan en credito en un campo sin tabulacion
                        codigo:<a id="boton" href="javascript: ventana('interpretes_instrumentista');"><div id="flecha"></div>Interpretes e Instrumentistas</a>-->
                    </div>
                    <a id="boton" href="javascript: ventana('diseno');"><div id="flecha"></div>Dise&ntilde;o</a>
                    <a id="boton" href="javascript: ventana('audio');"><div id="flecha"></div>Audio</a>
                </div>
                <div id="fabrica" class="sub_menu">
                    <a id="boton" href="javascript: ventana('produccion_industrial');"><div id="flecha"></div>Producci&oacute;n Industrial</a>
                    <a id="boton" href="javascript: ventana('distribucion');"><div id="flecha"></div>Distribuci&oacute;n</a>
                </div>
                <div id="ajustes" class="sub_menu">
                    <a id="boton" href="javascript: ventana('genero_musical');"><div id="flecha"></div>Genero Musical</a>
                                            <!-- COMENTARIO:
                    fecha:10/12/2011
                    descripcion:desabilitado debido a requerimiento del cendis, los interpretes e instrumentista se cargan en credito en un campo sin tabulacion
                    <a id="boton" href="javascript: ventana('instrumento');"><div id="flecha"></div>Instrumentos Musicales</a>
                    codigo:<a id="boton" href="javascript: ventana('interpretes_instrumentista');"><div id="flecha">-->
                    <a id="boton" href="javascript: ventana('tipo_formato');"><div id="flecha"></div>Tipo Formato</a>
                    <a id="boton" href="javascript: ventana('motivo_rechazo');"><div id="flecha"></div>Motivos de Rechazo</a>
                </div>
                <div id="reporte" class="sub_menu">
                    <a id="boton" href="javascript: ventana('cons_seguimiento_proyectos');"><div id="flecha"></div>Consulta de Proyectos</a>
                    <a id="boton" href="javascript: ventana('rpt_proyecto');"><div id="flecha"></div>Listados de Proyectos</a>
                    <a id="boton" href="javascript: ventana('rpt_informe_discografico');"><div id="flecha"></div>Informe Discogr&aacute;fico</a>
                    <a id="boton" href="javascript: ventana('rpt_orden_produccion');"><div id="flecha"></div>Orden de Producci&oacute;n</a>
                    <a id="boton" href="javascript: ventana('rpt_gestion_cendis');"><div id="flecha"></div>Reporte Gesti&oacute;n Cendis</a>                    
                    <a id="boton" href="javascript: ventana('rpt_reportes_varios');"><div id="flecha"></div>Reportes Varios</a>                    
                </div>
                <div id="seguridad" class="sub_menu">
                    <a id="boton" href="javascript: ventana('grupo');"><div id="flecha"></div>Grupo</a>
                    <a id="boton" href="javascript: ventana('usuario');"><div id="flecha"></div>Usuario</a>
                    <a id="boton" href="javascript: ventana('usuario_grupo');"><div id="flecha"></div>Usuario Grupo</a>
                    <a id="boton" href="javascript: ventana('permisos');"><div id="flecha"></div>Permisos Grupo</a>
                    <a id="boton" href="javascript: ventana('cambio_clave');"><div id="flecha"></div>Cambio de Clave</a>
                </div>
            </div>
            <div id="ayuda_superior">Ayuda<div id="ayuda_imgen"></div></div>
            <div id="ayuda_inferior">
                <div id="interno">
                    
                </div>
            </div>
        </div>
        <div id="img_CENDIS"></div>
       </div>
    <div id="pie">
        <br> Asociación Cooperativa Servicios y Bienes Kabuna R.L.</br>
        <br>Tlf:(0416) 721.06.63 - (0414) 250.16.31 - (0412) 634.39.77 RIF: J-29715558-9</br>
    </div>

</body>
</html>
