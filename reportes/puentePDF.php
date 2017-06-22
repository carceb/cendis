<?php
function generarPDF($nomb_reporte,$ArrayParametros){
    
    $serverx='127.0.0.1';
    $bdx='sis_cendis';
    $userx='postgres'; $pwx='123456';
    
    set_time_limit(0);
    ini_set('display_errors', 1);
    
    //require_once("/var/www/JavaBridge/java/Java.inc");
    require_once("/Users/carlosceballos/Sites/JavaBridge/java/Java.inc");

    //Especificamos la dirección donde guardamos el reporte
    
    //$dir ="/var/www/cendis/reportes/";
    $dir ="/Users/carlosceballos/Sites/cendis/reportes/";
            
    //Describimos la dirección de las librerías
    //$jrDirLib = "/var/www/lib_reportes/";
    $jrDirLib = "/Users/carlosceballos/Sites/lib_reportes/";

    //Creamos una variable que va a contener todas las librerías que están en la carpeta lib_reportes
    $handle = @opendir($jrDirLib);

    $classpath="";

    while(($lib = readdir($handle)) !== false) {
        $classpath .= 'file:'.$jrDirLib.''.$lib .';';
    }

    java_require($classpath);//Añadimos las librerías
    $Conn = new Java("org.altic.jasperReports.JdbcConnection");

    //Seteamos el driver mysql
    //$Conn->setDriver("com.mysql.jdbc.Driver");
    $Conn->setDriver("org.postgresql.Driver");
    //Especificamos los datos de la conexión
    $Conn->setConnectString("jdbc:postgresql://$serverx:5432/$bdx");
    $Conn->setUser($userx);
    $Conn->setPassword($pwx);

    //Creamos una variable tipo arreglo que contendrá los parámetros
    $parametrosMap = new Java("java.util.HashMap");
    //Se recorre el arreglo de parámetros.
    foreach ($ArrayParametros as $key => $value) {
        if(is_numeric($value)){//Si el valor es numérico entra.
            $parametrosMap->put($key, new Java('java.lang.Integer', $value));
        }else{//Si es una cadena entra.
            $parametrosMap->put($key, new Java('java.lang.String', $value));
        }
    }
    //Creamos el objeto JasperReport que permite obtener el reporte
    $sJfm = new JavaClass("net.sf.jasperreports.engine.JasperFillManager");

    //Guardamos el reporte en una variable $print para luego exportarla
    //echo "$dir$nomb_reporte.jasper";
    $print = $sJfm->fillReportToFile(
            $dir .$nomb_reporte.".jasper",
            $parametrosMap,
            $Conn->getConnection()
    );
    //Exportamos el informe y lo guardamos como pdf en el directorio donde están los reportes
    $sJem = new JavaClass("net.sf.jasperreports.engine.JasperExportManager");
    $time=microtime();
    $sJem->exportReportToPdfFile($print, "/tmp/".$nomb_reporte.$time.".pdf");

    //Este código sirve para abrir el archivo generado desde el explorador
    if (file_exists("/tmp/".$nomb_reporte.$time.".pdf")){
            header("Content-disposition: attachment; filename=".$nomb_reporte.$time.".pdf");
            header("Content-Type: application/pdf");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: ". @filesize("/tmp/" .$nomb_reporte.$time.".pdf"));
            header("Pragma: no-cache");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Expires: 0");
            set_time_limit(0);
            @readfile("/tmp/" .$nomb_reporte.$time.".pdf") or die("problem occurs.");
    }
}
?>