<script language="JavaScript" type="text/JavaScript" src="../controlador/qr_generador.js"></script>
<?php

    //echo "<h1>C&oacute;digo QR para el Artista y su Proyecto</h1>";
    //echo '<h2>'.$_POST['qr_proyecto'].'</h2><hr/>';
    
    //*******************************************************    
    //SE ELIMINÓ DE LA LINEA ORIGINAL PARA GUARDAR DIRECTAMENTE EN EL TEMP DE phpqrcode DENTRO DE /shared/php/    
    //set it to writable location, a place for temp generated PNG files
    //$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //*******************************************************

    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = "../shared/lib/phpqrcode/temp/";
    
    //*******************************************************
    //TAMBIEN SE ELIMINÓ
    //html PNG location prefix
    //$PNG_WEB_DIR = 'temp/';
    //*******************************************************
    
    //html PNG location prefix
    $PNG_WEB_DIR = '../shared/lib/phpqrcode/temp/';

    include "../shared/lib/phpqrcode/qrlib.php";    

    //*******************************************************    
    removeDirectory($PNG_TEMP_DIR);    //AGREGADO POR CARLOS CEBALLOS 24-07-12
    //*******************************************************

    //ofcourse we need rights to create temp dir    
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';

    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($_POST['qr_proyecto'])) { 
    
        //it's very important!
        if (trim($_POST['qr_proyecto']) == '')
            die('El codigo no puede estar vacio. <a href="?">back</a>');
            
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_POST['qr_proyecto'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_POST['qr_proyecto'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } else {    
    
        //default data
        echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
        QRcode::png('www.cendis.gob.ve', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }    
        
    //display generated file
    echo '<img id="qr_image" src="'.$PNG_WEB_DIR.basename($filename).'" />';
    
    function removeDirectory($path)
    {
        $path = rtrim( strval( $path ), '/' ) ;

        $d = dir( $path );

        if( ! $d )
            return false;

        while ( false !== ($current = $d->read()) )
        {
            if( $current === '.' || $current === '..')
                continue;

            $file = $d->path . '/' . $current;

            if( is_dir($file) )
                removeDirectory($file);

            if( is_file($file) )
                unlink($file);
        }

        rmdir( $d->path );
        $d->close();
        return true;
    }    
?>
