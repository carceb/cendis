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
$obj_tipo_formato = new clstipoformato; //Se instancia la clase
echo $obj_tipo_formato->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clstipoformato {
//=========================================================================================================================
//Nombre	     : Clase cls_genero_musical
//Elaborado por  : Carlos Ceballos
//Fecha			 : 06/01/2012
//Description	 : Ingreso y mantenimiento de tipos de formato.
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
    function consultaTipoFormato($str_d='', $case='')    {
        $tabla='tipo_formato';
	$campos = "*";
        $Union = '';
        switch($case){
            case "por_listado":
                $sql_criterio = " WHERE nombre_tipo_formato ".$this->I."LIKE('%".$str_d['nombre_tipo_formatoVM']."%')";
                break;
            case "por_listado_nombre":
                $campos = "nombre_tipo_formato";
                break;
            case "valida_eliminar":
		$Union = ' INNER JOIN proyecto ON tipo_formato.tipo_formato_id = proyecto.tipo_formato_id';
                $sql_criterio = " WHERE tipo_formato.tipo_formato_id = ".$str_d;
            break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
        return $this->obj_consulta->ejecutar($sql_query,'consultaTipoFormato','select');
    }//Fin consultaTipoFormato.

    function cargaGrilla($parametros){
       $str_d = json_decode(stripcslashes($parametros),true);
       $result = $this->consultaTipoFormato($str_d,'por_listado','');
        if ($this->obj_consulta->rstNroFilas($result)) {
	    $A=0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                $data[$A]['nombre_tipo_formato']=$data[$A]['nombre_tipo_formato'];
                $A++;
            }
            $retorno = array('filas' => $data);
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = array('filas' => false);
        }
        return json_encode($retorno);
    }//Fin cargaGrilla.
    
    function availableTags(){
       $result = $this->consultaTipoFormato('','por_listado_nombre','');
        if ($this->obj_consulta->rstNroFilas($result)) {
	    $A=0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                $data[$A]['nombre_tipo_formato']=html_entity_decode($data[$A]['nombre_tipo_formato'], ENT_QUOTES);
                $A++;
            }
            $retorno = array('filas' => $data);
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = array('filas' => false);
        }
        return json_encode($retorno);
    }//Fin availableTags.
	
    function ingresaTipoFormato($parametros){
        $id_x = '';
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("INSERT INTO public.tipo_formato (nombre_tipo_formato)
            VALUES('%s')",
            htmlspecialchars($str_d['nombre_tipo_formato'],3));
        $id_tipo_formato = $this->obj_consulta->ejecutar($sql_query,'ingresaTipoFormato','insert');
        $mensaje = $this->obj_general->msj_insert($id_tipo_formato);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje,'id_tipo_formato'=>$id_tipo_formato);
        return json_encode($retorno);
    }//Fin ingresaTipoFormato
    
    
    function actualizaTipoFormato($parametros)    {
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("UPDATE tipo_formato SET nombre_tipo_formato = '%s' WHERE tipo_formato_id = %s",
                htmlspecialchars($str_d['nombre_tipo_formato'],3),
                $str_d['tipo_formato_id']);
 
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaTipoFormato','update');
        $mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        return json_encode($retorno);
    }//Fin actualizaInstrumento.  

    function eliminarTipoFormato($tipo_formato_id){
        $reg_afectado='';
        $result = $this->consultaTipoFormato($tipo_formato_id,'valida_eliminar');//se verifica si el registro esta relacionado con una persona.
        if(!$this->obj_consulta->rstNroFilas($result)){
            $sql_query = sprintf("DELETE FROM tipo_formato WHERE tipo_formato_id = %s", $tipo_formato_id);
            $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'eliminarTipoFormato','delete');
            $mensaje = $this->obj_general->msj_delete($reg_afectado);
        }else{
            $mensaje = "ERROR: Disculpe, Formato, esta asociado a un Proyecto Musical. No se puede eliminar";
            $this->obj_consulta->free_rst($result);
        }
        $retorno = array('mensaje'=>$mensaje,'reg_afectado'=>$reg_afectado);
        return json_encode($retorno);
    }//Fin eliminarGeneroMusical.

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>