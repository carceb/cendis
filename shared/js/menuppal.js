$(document).ready(function(){
    validaAcc();
    $('#interno').html('');
    var texto_ayuda = '<strong>sisCENDIS</strong> <p>&nbsp;Bienvenidos al sistema integrado de seguimiento a las solicitudes de producciones discográficas, sencillos módulos permiten controlar todo el complejo proceso por el cual transitan las solicitudes de los artistas nacionales.</p>';
    $('#interno').append(texto_ayuda);
    $('.sub_menu').hide();
    $('.sub_catalogo').hide();
    $('#solicitud').show();
    $('#iframe').append('<iframe id="ventana_actual" width="100%" height="100%" frameborder="0" scrolling="no" src="../vista/inicio.php"></iframe>');
});

function sub_menu(nombre){
    var texto_ayuda;
    $('#interno').html('');
    $('#ventana_actual').remove();
    $('.sub_menu').hide();
    switch(nombre){
        case 'solicitud':
            texto_ayuda = '<strong>Solicitud</strong> <p>&nbsp; Coordinación de producción artística, carga la información inicial del artista y del proyecto.</p>';
        break;
        case 'comision':
            texto_ayuda = '<strong>Comisión Artistica</strong> <p>&nbsp;La comisión artística evalúa el proyecto, lo aprueba o rechaza.</p>';
        break;
        case 'produccion':
            $('.sub_catalogo').hide();
            texto_ayuda = '<strong>Produción</strong> <p>&nbsp;Catalogo: solicita documentación a los artistas cuyos proyectos fueron aprobados y carga información adicional acerca del artista y el proyecto.</p> <p>Diseño: realiza la caratula de la producción final.</p> <p>Audio: revisión técnica, grabación.</p>';
        break;
        case 'fabrica':
            texto_ayuda = '<strong>Fabrica</strong> <p>&nbsp;Empaqueta y distribuye el material discográfico elaborado.</p>';
        break;
        case 'salir':
            location.href="usuario_login.php";
			exit();
        break;
    }
    $('#interno').append(texto_ayuda);
    $('#'+nombre).show();
    $('#iframe').append('<iframe id="ventana_actual" width="100%" height="100%" frameborder="0" scrolling="no" src="../vista/'+nombre+'.php"></iframe>');
}

function ventana(nombre){
    var texto_ayuda;
    $('#interno').html('');
    $('#ventana_actual').remove();
    switch(nombre){
        case 'artista':
            texto_ayuda = '<strong>Carga inicial de los datos principales del Interprete, Creador o Grupo para posteriores procesos dentro de la aplicación, es posible modificar los datos ya cargados o realizar busquedas por nombre, o tipo de artista. </strong> <p>&nbsp;.</p>';
           break;
        case 'proyecto':
            texto_ayuda = '<strong>Carga de los datos del proyecto musical, se debe seleccionar el artista, previamente cargado, colocar el nombre del proyecto y el tipo de requrimiento (grabación o replicación). Se debe indicar también la fecha de la solicitud del proyecto e indicar los recaudos minimos requeridos.</strong> <p>&nbsp;.</p>';
           break;
        case 'revision':
            texto_ayuda = '<strong>Revisión de Proyectos por Parte de la Comisión Artística, los proyectos se muestran por orden de llegada, se deben aprobar de la lista haciendo clic en el icono del pulgar arriba o recharlo haciendo clic en icono del pugar abajo, para almacenar los cambios se debe presionar el botón gurdar.</strong> <p>&nbsp;.</p>';
           break;
        case 'linea_editorial':
            texto_ayuda = '<strong>A los proyectos aprobados en la pantalla anterior se les debe asignar la linea editorial, y la cantidad de copias aprobadas para grabación o replicación, seleccione el tipo de línea editorial de la lista junto al proyecto, coloque la cantidad de copias en el cuadro al lado de la lista y presione guardar.</strong> <p>&nbsp;.</p>';
          break;
        case 'rechazados':
            texto_ayuda = '<strong>Los proyectos rechazados por la comisión se muestran en la lista central, haga clic en el icono del pulgar arriba para sacarlos de la lista de rechazados y volverlos a colocar en revisión.</strong> <p>&nbsp;.</p>';
           break;
        case 'catalogo':
            if ($('.sub_catalogo').is (':visible'))
                $('.sub_catalogo').hide();
            else
                $('.sub_catalogo').show();
            texto_ayuda = '<strong>Seleccione el proyecto de la lista, marque las casillas que indiquen los recaudos consignados por el artista, coloque los números de depósito legal y producción, seleccione el tipo de estuche y presione guardar.</strong> <p>&nbsp;.</p>';
           break;
        case 'credito':
            texto_ayuda = '<strong></strong>Seleccione de las listas el tipo de artista, el artista y el proyecto, y coloque los datos de los creditos, para actualizar presione guardar. <p>&nbsp;.</p>';
           break;
        case 'repertorio':
            texto_ayuda = '<strong>Seleccione de las listas el tipo de artista, el artista y el proyecto, coloque cada uno de los valores requeridos en los cuadros de texto, presione guardar, en la lista inferior se iran mostrando cada uno de los temas agreados a la produción, si hace clic en la misma podrá editar el registro seleccionado. </strong> <p>&nbsp;.</p>';
           break;
        case 'interpretes_instrumentista':
            texto_ayuda = '<strong>Interpretes e Instrumentista</strong> <p>&nbsp;.</p>';
            break;
        case 'diseno':
            texto_ayuda = '<strong>Seleccione de la lista el proyecto, y marque la casilla correspondiente al paso finalizado en el proceso de diseño, luego presione guardar para actualizar el registro.</strong> <p>&nbsp;.</p>';
            break;
        case 'audio':
            texto_ayuda = '<strong>Seleccione de la lista el proyecto, y marque la casilla correspondiente al paso finalizado en el proceso de audio, luego presione guardar para actualizar el registro.</strong> <p>&nbsp;.</p>';
            break;
        case 'produccion_industrial':
            texto_ayuda = '<strong>Producci&oacute;n Industrial</strong> <p>&nbsp;.</p>';
            break;
        case 'distribucion':
            texto_ayuda = '<strong>Distribucion</strong> <p>&nbsp;.</p>';
            break;
        case 'genero_musical':
            texto_ayuda = '<strong>Ingrese el nombre del genero musical y presione guardar para actualizar el registro, si desea modificar un registro cargado, presione buscar, seleccionelo de la lista y modifiquelo.</strong> <p>&nbsp;.</p>';
            break;
        case 'motivo_rechazo':
            texto_ayuda = '<strong>Ingrese el nombre del motivo de rechazo y presione guardar para actualizar el registro, si desea modificar un registro cargado, presione buscar, seleccionelo de la lista y modifiquelo.</strong> <p>&nbsp;.</p>';
            break;            
        case 'salir':
            location.href="../index.php";
            break;
    }
    $('#interno').append(texto_ayuda);
    $('#iframe').append('<iframe id="ventana_actual" width="100%" height="100%" frameborder="0" scrolling="no" src="../vista/'+nombre+'.php"></iframe>');
}
