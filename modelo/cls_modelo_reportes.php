<?php session_start();
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
$obj_modelo_reportes = new clsmodeloreportes; //Se instancia la clase
echo $obj_modelo_reportes->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clsmodeloreportes {
//=========================================================================================================================
//Nombre	     : Clase cls_modelo_reportes
//Elaborado por  : Carlos Ceballos
//Fecha			 : 09/04/2012
//Description	 : Modelo estandar el cual será utilizado para realizar actualizaciones en la base de datos si algun reporte lo requiere.
//Modificación   :
//=========================================================================================================================
    private $obj_consulta;
    private $obj_general;
    private $I;
    function __construct(){
       require_once('../shared/php/cls_gengralp.php');
       $this->obj_general = new general;
       require_once('../shared/cnx/Db_class.php');
       $this->obj_consulta = new DB(); $this->I='I';
    }

    
    //REPORTE GESTION CENDIS
    //********************************************************************************************************************************************************
    function ingresaGestionCendis($parametros){
        $id_x = '';
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("INSERT INTO public.reporte_gestion_cendis (nombre_genero_musical, nombre_mes, cantidad_catalogo_ddp, cantidad_diseno_imprenta, cantidad_masterizacion, cantidad_replicacion, cantidad_impresion, cantidad_distribucion)
            VALUES('%s')",
            htmlspecialchars($str_d['nombre_genero_musical'],3));
        $id_genero_musical = $this->obj_consulta->ejecutar($sql_query,'ingresaGestionCendis','insert');
        $mensaje = $this->obj_general->msj_insert($id_genero_musical);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje,'id_genero_musical'=>$id_genero_musical);
        return json_encode($retorno);
    }//Fin ingresaArtista
    

    function eliminarGeneroMusical($genero_musical_id){
        $reg_afectado='';
        $result = $this->consultaGeneroMusical($genero_musical_id,'valida_eliminar');//se verifica si el registro esta relacionado con una persona.
        if(!$this->obj_consulta->rstNroFilas($result)){
            $sql_query = sprintf("DELETE FROM genero_musical WHERE genero_musical_id = %s", $genero_musical_id);
            $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'eliminarGeneroMusical','delete');
            $mensaje = $this->obj_general->msj_delete($reg_afectado);
        }else{
            $mensaje = "ERROR: Disculpe, El Genero musical, esta asociado a un Proyecto Musical. No se puede eliminar";
            $this->obj_consulta->free_rst($result);
        }
        $retorno = array('mensaje'=>$mensaje,'reg_afectado'=>$reg_afectado);
        return json_encode($retorno);
    }//Fin eliminarGeneroMusical.

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>