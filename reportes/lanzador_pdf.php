<?php session_start();
//=========================================================================================================================
//Archivo	: lanzador de PDFs
//Elaborado por	: Alexis Ontiveros.
//Description	: Se genera un array de parametros de acuerdo al reporte y se lanza el generador de reportes.
//=========================================================================================================================
require_once('puentePDF.php');
$nombre_reporte = $_GET['nombre_reporte'];
$Parametros = array("SQL_WHERE"=>$_GET['SQL_WHERE']);
generarPDF($nombre_reporte,$Parametros);
?>