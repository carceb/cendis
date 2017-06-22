$(document).ready(function(){
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
    $('#txt_usuario').focus();
    function creaPrametros(){
        var objeto={user_x:$('#txt_usuario').val(),pw_x:$('#txt_clave').val()};
        return JSON.stringify(objeto);
    }
    /*$('#cambia_pwr').click(function(){
        f=document.form1;
            f.txt_clave.value = "";
        if(!$('#txt_usuario').val()){
            jAlert("Disculpe, ingrese el nombre de usuario primero y luego haga click en cambiar clave","Confirmación de Proceso");
        }else{
            f.action='../admin/vistas/actualiza_pw.php';
            f.submit();
        }
    });*/
    $('#Entrar').click(validarUsuario);
    $('#txt_clave').keypress(function(e){
        var tecla='';
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==13){
           validarUsuario();
        }
    });
    function validarUsuario(){
        if(!$('#txt_usuario').val()){
            jAlert("Disculpe, ingrese el nombre de usuario por favor","Confirmación de datos de acceso");
        }else if(!$('#txt_clave').val()){
            jAlert("Disculpe, ingrese su clave de acceso por favor","Confirmación de datos de acceso");
        }else{
            $.post("../shared/php/cls_accss.php",{metodo:"login",parametros:creaPrametros()},function(resp_x){
                if(resp_x.login===true){
                    location.href="index.php";
                }else{
                    jAlert(resp_x.login, 'Confirmación de Proceso');
                }
                $('#txt_usuario').val('');
                $('#txt_clave').val('');
            }, "json");//
        }
    }
});