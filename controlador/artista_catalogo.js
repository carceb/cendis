$(document).ready(function(){						   
    //$('body').append(cargando);//adiciona el mensaje de carga de datos.
    $('#tb_cabeceragrilla').hide();//oculta el encabezado de la grilla.
    $('#vm_Limpiar').click(function(){//Limpia el catalogo.
        $('#txt_nombre_artistaVM').val('');
        $('#grilla').remove();
        $('#tb_cabeceragrilla').hide();
    });
    $('#vm_Buscar').click(function(){//busca �l o los registros
        if($('#grilla')){$('#grilla').remove();}//si la grilla est� pintada la borra
        //loading('cargando');
        $.post("../modelo/cls_artista.php",{metodo:"cargaGrilla",parametros:creaParametrosvm()},function(data){//se ejecula la b�squeda.
            //alert(data);
            //loading_cerrar();
            if(data.filas){//si trae resultado, entra.
                $('#tb_cabeceragrilla').show();//se visualiza el encabezado de la grilla.
                $.each(data.filas, function(cant_reg,detalle){//se recorre el json.
                    if(cant_reg==0){$('#scrolltb').append(tbgrilla());}//se pinta la grilla.
                    var str = detalle.artista_id+","+detalle.tipo_artista_id+",'"+escapaComiSen(detalle.nombre_artista)+"',"+detalle.sexo_id+","+detalle.nacionalidad_id+","+detalle.cedula_artista+",'"+detalle.cedula_representante_artistico+"','"+escapaComiSen(detalle.nombre_representante_artistico)+"',"+detalle.pais_id+","+detalle.estado_id+","+detalle.municipio_id+",'"+detalle.telefono_habitacion+"','"+detalle.telefono_celular+"','"+detalle.telefono_otro+"','"+detalle.email_artista+"','"+escapaComiSen(detalle.direccion_artista)+"','"+detalle.fecha_ingreso_artista+"'";
                    //se agrega la fila con sus datos a la grilla.
                    $('#grilla tbody').append('<tr id="consulta"><td id="fila" align="left" width="370"><a href="#" onclick="aceptar('+str+')">'+detalle.nombre_artista+'</a></td></tr>');
                    $('#grilla tbody').append('<tr><td height="1" bgcolor="#BBBBBB" align="center"></td>');//separador de fila.
                });//Fin $.each
            }else{
                alert('Disculpe, no se encontraron coincidencias');
            }
        },"json");//    Fin getJSON.
    });// Fin $('#vm_Buscar').

    $('#vm_Salir').click(function(){// sale del catalogo.
        close_form();
    });
});

function tbgrilla(){//tabla para la grilla.
    return '<table id="grilla" width="370" height="16" border="0" align="center" cellpadding="0" cellspacing="2"><tr></tr></table>';
}


function aceptar(artista_id,tipo_artista_id,nombre_artista,sexo_id,nacionalidad_id,cedula_artista,cedula_representante_artistico,nombre_representante_artistico,pais_id,estado_id,municipio_id,telefono_habitacion,telefono_celular,telefono_otro,email_artista,direccion_artista,fecha_ingreso_artista){//se carga los datos en formulario que los solicit� al clicar en el registro solicitado y cierra el cat�logo.
    montarDatosArtista(artista_id,tipo_artista_id,nombre_artista,sexo_id,nacionalidad_id,cedula_artista,cedula_representante_artistico,nombre_representante_artistico,pais_id,estado_id,municipio_id,telefono_habitacion,telefono_celular,telefono_otro,email_artista,direccion_artista,fecha_ingreso_artista);
    close_form();
}

function creaParametrosvm(){
    //Retorna los parárametros en notación JSON.
    var objeto = {nombre_artistaVM:$('#txt_nombre_artistaVM').val()};
    return JSON.stringify(objeto);
}