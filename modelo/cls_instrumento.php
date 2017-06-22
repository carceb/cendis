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
$obj_instrumento = new clsinstrumento; //Se instancia la clase
echo $obj_instrumento->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clsinstrumento {
//=========================================================================================================================
//Nombre	     : Clase cls_genero_musical
//Elaborado por  : Carlos Ceballos
//Fecha			 : 06/01/2012
//Description	 : Ingreso y mantenimiento de generos musicales.
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
    function consultaInstrumento($str_d='', $case='')    {
        $tabla='instrumento';
	$campos = "*";
        $Union = '';
        switch($case){
            case "por_listado":
                $sql_criterio = " WHERE nombre_instrumento ".$this->I."LIKE('%".$str_d['nombre_instrumentoVM']."%')";
                break;
            case "por_listado_nombre":
                $campos = "nombre_instrumento";
                break;
            case "valida_eliminar":
		$Union = ' INNER JOIN interprete_instrumentista ON instrumento.instrumento_id = interprete_instrumentista.instrumento_id';
                $sql_criterio = " WHERE instrumento.instrumento_id = ".$str_d;
            break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
        return $this->obj_consulta->ejecutar($sql_query,'consultaInstrumento','select');
    }//Fin consultaInstrumento.

    function cargaGrilla($parametros){
       $str_d = json_decode(stripcslashes($parametros),true);
       $result = $this->consultaInstrumento($str_d,'por_listado','');
        if ($this->obj_consulta->rstNroFilas($result)) {
	    $A=0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                $data[$A]['nombre_instrumento']=$data[$A]['nombre_instrumento'];
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
       $result = $this->consultaInstrumento('','por_listado_nombre','');
        if ($this->obj_consulta->rstNroFilas($result)) {
	    $A=0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                $data[$A]['nombre_instrumento']=html_entity_decode($data[$A]['nombre_instrumento'], ENT_QUOTES);
                $A++;
            }
            $retorno = array('filas' => $data);
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = array('filas' => false);
        }
        return json_encode($retorno);
    }//Fin availableTags.
	
    function ingresaInstrumento($parametros){
        $id_x = '';
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("INSERT INTO public.instrumento (nombre_instrumento)
            VALUES('%s')",
            htmlspecialchars($str_d['nombre_instrumento'],3));
        $id_instrumento = $this->obj_consulta->ejecutar($sql_query,'ingresaInstrumento','insert');
        $mensaje = $this->obj_general->msj_insert($id_instrumento);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje,'id_instrumento'=>$id_instrumento);
        return json_encode($retorno);
    }//Fin ingresaInstrumento
    
    
    function actualizaInstrumento($parametros)    {
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("UPDATE instrumento SET nombre_instrumento = '%s' WHERE instrumento_id = %s",
                htmlspecialchars($str_d['nombre_instrumento'],3),
                $str_d['instrumento_id']);
 
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaInstrumento','update');
        $mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        return json_encode($retorno);
    }//Fin actualizaInstrumento.  

    function eliminarInstrumento($instrumento_id){
        $reg_afectado='';
        $result = $this->consultaInstrumento($instrumento_id,'valida_eliminar');//se verifica si el registro esta relacionado con una persona.
        if(!$this->obj_consulta->rstNroFilas($result)){
            $sql_query = sprintf("DELETE FROM instrumento WHERE instrumento_id = %s", $instrumento_id);
            $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'eliminarInstrumento','delete');
            $mensaje = $this->obj_general->msj_delete($reg_afectado);
        }else{
            $mensaje = "ERROR: Disculpe, Instrumento Musical, esta asociado a un Proyecto Musical. No se puede eliminar";
            $this->obj_consulta->free_rst($result);
        }
        $retorno = array('mensaje'=>$mensaje,'reg_afectado'=>$reg_afectado);
        return json_encode($retorno);
    }//Fin eliminarGeneroMusical.

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>