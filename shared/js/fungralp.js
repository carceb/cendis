// ActionScript Remote Document
document.oncontextmenu = function(){return false;};//Inactiva el click derecho del mouse.
document.onkeydown = function(e){//Inactiva la tecla F5.
    if(e)
        document.onkeypress = function(){return true;};

        var evt = e?e:event;
        if(evt.keyCode==116){
                if(e)
                  document.onkeypress = function(){return false;};
        else
        {
            evt.keyCode = 0;
            evt.returnValue = false;
        }
    }
};

function validaAcc(){
    $.post("../shared/php/cls_accss.php",{metodo:"valida_acceso",parametros:nombreArchivo()},function(resp_x){
        if(resp_x.pms_acceso == 'f'){
            alert(resp_x.mensaje);
            location.href="usuario_login.php";
        }
    }, "json")
}
function AcceVent(){
    $.post("../shared/php/cls_accss.php",{metodo:"valida_acceso",parametros:nombreArchivo()},function(result){
        //alert(result);
        if(result.pms_acceso == 'f'){
            alert('Disculpe, No tienes acceso a esa ventana');
            parent.$('#ventana_actual').remove();
        }else{
            var objeto = {pms_ingresar:result.pms_ingresar,pms_buscar:result.pms_buscar,pms_modificar:result.pms_modificar,
            pms_eliminar:result.pms_eliminar,pms_imprimir:result.pms_imprimir,pms_listar:result.pms_listar,
            pms_acceso:result.pms_acceso,id_ventana:result.id_ventana}
            $('#prms').data(objeto);
        }
     }, "json")//
}
function msjAccss(){
    jAlert('Disculpe, no tienes permiso para realizar esa operación', 'Información del Sistema');
}
function nombreArchivo(){//Retorna el nombre del archivo actual.
    var url_x = "'"+window.location;
    var cadena_x = url_x.substring(8);
    var cadena = cadena_x.split('/');
    return cadena[cadena.length-1];
}

function estatusDesc(valor){
    var retornar;
    switch (valor) {
        case '0':
            retornar = 'Egresado';
        break;
        case '1':
            retornar = 'Activo';
        break;
        case '2':
            retornar = 'En Comisión Servicio';
        break;
        case '3':
            retornar = 'Pensionado';
        break;
        case '4':
            retornar = 'Jubilado';
        break;
        case '5':
            retornar = 'Destacado';
        break;
        case '6':
            retornar = 'Apoyo Institucional';
        break;
    }
    return retornar;
}

function ocultarIconos(){
    $('#iconEliminar').hide();$('#iconImprimir').hide();$('#iconEditContact').hide();$('#iconCal').hide();$('#iconJubpen').hide();$('#iconReversar').hide();$('#iconListar').hide();
}
function ocultarIconosMenuVm(){
    $('#iconVmEliminar').hide();$('#iconVmImprimir').hide();$('#iconVmEditContact').hide();$('#iconVmCal').hide();
}
function tipoValor(valor){
    var retornar;
    switch (valor) {
        case 'E':
            retornar = 'Entero';
        break;
        case 'P':
            retornar = 'Porcentaje';
        break;

    }
    return retornar;
}

function cargaMontos(nombre_hide, filtro){
    $.post("../modelos/cls_montos.php",{metodo:"buscaMonto",parametros:filtro},function(data){//se ejecula la b�squeda.
        loading_cerrar();
        if(data.fila){//si trae resultado, entra.
            $('#'+nombre_hide).val(data.fila.montos_valor);
        }else{
            alert('Disculpe, no se encontraron coincidencias');
        }
    }, "json");//Fin getJSON.
}

function checkar(nombre_check){//checa un checkbox
    $('#'+nombre_check).attr("checked","true");
}

function desChecked(nombre_check){//Deschequéa un checkbox
    $('#'+nombre_check).attr("checked","");
}

function val_integer(nombre_text){
    if($('#'+nombre_text).val() == '')
        return 0;
    else
        return $('#'+nombre_text).val();
}

function valorCheck(check_nombre){//retorna 1 ó 0
    var retornar;
    if($('#'+check_nombre).is(':checked')){retornar='t';}else{retornar='f';}return retornar;
}

function checkAll(field){
    for (i = 0; i < field.length; i++)
	field[i].checked = true ;
}

function uncheckAll(field){
    for (i = 0; i < field.length; i++)
	field[i].checked = false ;
}

function checked(value){
     retorna = (value == 't')?'checked':'';
	 return retorna;
}

function capturaNombreOpcion(nombre_combo,valor){
    return $("#"+nombre_combo).find("option[value='"+valor+"']").text();
}

function llenaCombox(nombre_combo,tabla,opcionDefault,valor_filtro,opcionOcultar,fuentedata){
    if(!fuentedata){fuentedata='../shared/php/cls_comboGrilla.php';}
    if(!valor_filtro){
		dependencia=false;
		dependencia_id=false;
		dependencia2=false;
		dependencia_id2=false;
		dependencia3=false;
	}else{
		dependencia=valor_filtro.dependencia;
		dependencia_id=valor_filtro.dependencia_id;
		if (valor_filtro.dependencia2){
			dependencia2=valor_filtro.dependencia2;
			dependencia_id2=valor_filtro.dependencia_id2;
		}else{
			dependencia2=false;
			dependencia_id2=false;
		}
		if (valor_filtro.dependencia3){dependencia3=valor_filtro.dependencia3;}else{dependencia3=false;}
	}
	//OBTENER EL SCHEMA SI SE PASA POR PARAMETRO
	var schema = tabla.split(".");
	if (schema.length == 1){
		schema = 'public';
	}else{
		tabla = schema[1];
		schema = schema[0];
	}
    if(/VM/.test(tabla)){
        var tablaF = tabla.replace('VM','');
    }else{
        var tablaF = tabla;
    }
    var objeto = {tabla:tablaF,dependencia:dependencia,dependencia_id:dependencia_id,dependencia2:dependencia2,dependencia_id2:dependencia_id2,dependencia3:dependencia3,schema:schema};
    if (nombre_combo == '') nombre_combo = 'sel_'+tabla;
    $('#'+nombre_combo).html("");
    $.post(fuentedata,{metodo:"cargaCombo",parametros:JSON.stringify(objeto)},function(data){//se ejecula la búsqueda.
         if(data.filas){//si trae resultado, entra.
            $('#'+nombre_combo).append('<option value="">--Seleccione--</option>');
            $.each(data.filas, function(i,fila){//se recorre el json.
                if (fila.nombre == 'N/D' || fila.nombre == 'N/A'){}
                else{
                    $('#'+nombre_combo).append('<option value="'+fila.id+'">'+fila.nombre+'</option>');
                }                    
            });//Fin $.each
            if(opcionDefault){$('#'+nombre_combo).val(opcionDefault);}
        }else{
            $('#'+nombre_combo).append('<option value="">--No hay--</option>');
        }
        if(opcionOcultar){
            ocultaOpcionCombox('sel_'+tabla,opcionOcultar);
        }
    },"json");//Fin post.
}

function valorCombox(nombre_combo,posicion){//Retorna el valor de combo a la posición del valor en Value.
    if($('#'+nombre_combo).val()){
        var elemento = $('#'+nombre_combo).val().split(',');
        return elemento[posicion];
    }else{
        return '';
    }
}

function open_form(forma,ancho,alto,argumento,destino) {
    //Habilitar seleccionar texto
    var ancho_total = $(document).width()+20;
    var alto_total = $(document).height();
    // Crear al div de fondo
    var div_fondo = $('<div>')
    .attr('id', '_n_u_fondo')
    .attr('style', "width: "+ancho_total+"px; height: "+alto_total+"px;")
    .appendTo('#'+destino);
    // Crear al div del formulario
    var div_from = $('<div>')
    .attr('id', '_n_u_form')
    .attr('style', "margin-top:-"+(alto/2)+"px;margin-left:-"+(ancho/2)+"px;height:"+alto+"px;width:"+ancho+"px;")
    .appendTo('#_n_u_fondo')
    .load(forma + '.php',argumento)
    .hide()
    .fadeIn('fast');
}

function close_form() {
    $('#_n_u_form').remove();
    $('#_n_u_fondo').remove();
}

function fechaActual() {
    fecha_actual = new Date();
    return fecha_actual.getDate() + "/" + (fecha_actual.getMonth() +1) + "/" + fecha_actual.getFullYear();
}

function remplaceEnter(cadena){//Quita los enter de una cadena.
	if (cadena){
		return cadena.replace(/U000A/gi, '\n');
	}
}
 
function isDate(date){
    var Fecha= new String(date)   // Crea un string  
    var RealFecha= new Date()   // Para sacar la fecha de hoy  
    // Cadena Año  
    var Ano= new String(Fecha.substring(Fecha.lastIndexOf("/")+1,Fecha.length))  
    // Cadena Mes  
    var Mes= new String(Fecha.substring(Fecha.indexOf("/")+1,Fecha.lastIndexOf("/")))  
    // Cadena Día  
    var Dia= new String(Fecha.substring(0,Fecha.indexOf("/")))  
  
    // Valido el año  
    if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900){
        return false  
    }  
    // Valido el Mes  
    if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){
        return false  
    }  
    // Valido el Dia  
    if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){
        return false  
    }  
    if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {  
        if (Mes==2 && Dia > 29 || Dia>30) {  
            return false  
        }  
    }  
  return true
}

function formateaMonto(num, mostrarCentimos){
    num = num.toString().replace(/\$|\,/g, '')
    if (isNaN(num)) num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10) cents = '0' + cents;

    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++) {
      num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3))
    }
    
    if(mostrarCentimos == ''){
        return (((sign) ? '' : '-') + '' + num)    
    }
    else
    {
        return (((sign) ? '' : '-') + '' + num + ',' + cents) 
    }

}

function escapaComiSen(cadena){//Escapa las comillas dobles
    return cadena.replace(/&#039;/g,"\\'");
}

function escapaComiSen2(cadena){//Escapa las comillas simples
    return cadena.replace(/&#039;/g,"\'");
}