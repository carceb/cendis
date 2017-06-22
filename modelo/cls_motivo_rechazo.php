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
$obj_motivo_rechazo = new clsmotivorechazo; //Se instancia la clase
echo $obj_motivo_rechazo->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clsmotivorechazo {
//=========================================================================================================================
//Nombre	     : Clase cls_motivo_rechazo
//Elaborado por  : Carlos Ceballos
//Fecha			 : 05/11/2012
//Description	 : Ingreso y mantenimiento de motivos de rechazo por la comision artistica.
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
    function consultaMotivoRechazo($str_d='', $case='')    {
        $tabla='motivo_rechazo';
	$campos = "*";
        $Union = '';
        switch($case){
            case "por_listado":
                $sql_criterio = " WHERE nombre_motivo_rechazo ".$this->I."LIKE('%".$str_d['nombre_motivo_rechazoVM']."%')";
                break;
            case "por_listado_nombre":
                $campos = "nombre_motivo_rechazo";
                break;
            case "valida_eliminar":
		$Union = ' INNER JOIN proyecto ON motivo_rechazo.motivo_rechazo_id = proyecto.motivo_rechazo_id';
                $sql_criterio = " WHERE motivo_rechazo.motivo_rechazo_id = ".$str_d;
            break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
        return $this->obj_consulta->ejecutar($sql_query,'consultaMotivoRechazo','select');
    }//Fin consultaMotivoRechazo.

    function cargaGrilla($parametros){
       $str_d = json_decode(stripcslashes($parametros),true);
       $result = $this->consultaMotivoRechazo($str_d,'por_listado','');
        if ($this->obj_consulta->rstNroFilas($result)) {
	    $A=0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                $data[$A]['nombre_motivo_rechazo']=$data[$A]['nombre_motivo_rechazo'];//$this->obj_general->htmlkarakter()
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
       $result = $this->consultaMotivoRechazo('','por_listado_nombre','');
        if ($this->obj_consulta->rstNroFilas($result)) {
	    $A=0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                $data[$A]['nombre_motivo_rechazo']=html_entity_decode($data[$A]['nombre_motivo_rechazo'], ENT_QUOTES);
                $A++;
            }
            $retorno = array('filas' => $data);
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = array('filas' => false);
        }
        return json_encode($retorno);
    }//Fin availableTags.
	
    function ingresaMotivoRechazo($parametros){
        $id_x = '';
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("INSERT INTO public.motivo_rechazo (nombre_motivo_rechazo)
            VALUES('%s')",
            htmlspecialchars($str_d['nombre_motivo_rechazo'],3));
        $motivo_rechazo_id = $this->obj_consulta->ejecutar($sql_query,'ingresaMotivoRechazo','insert');
        $mensaje = $this->obj_general->msj_insert($motivo_rechazo_id);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje,'motivo_rechazo_id'=>$motivo_rechazo_id);
        return json_encode($retorno);
    }//Fin ingresaMotivoRechazo
    
    
    function actualizaMotivoRechazo($parametros)    {
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("UPDATE motivo_rechazo SET nombre_motivo_rechazo = '%s' WHERE motivo_rechazo_id = %s",
                htmlspecialchars($str_d['nombre_motivo_rechazo'],3),
                $str_d['motivo_rechazo_id']);

        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaMotivoRechazo','update');
        $mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        return json_encode($retorno);
    }//Fin actualizaMotivoRechazo.  

    function eliminarMotivoRechazo($motivo_rechazo_id){
        $reg_afectado='';
        $result = $this->consultaMotivoRechazo($motivo_rechazo_id,'valida_eliminar');//se verifica si el registro esta relacionado con una persona.
        if(!$this->obj_consulta->rstNroFilas($result)){
            $sql_query = sprintf("DELETE FROM motivo_rechazo WHERE motivo_rechazo_id = %s", $motivo_rechazo_id);
            $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'eliminarMotivoRechazo','delete');
            $mensaje = $this->obj_general->msj_delete($reg_afectado);
        }else{
            $mensaje = "ERROR: Disculpe, el motivo de rechazo, está asociado a un proyecto musical. No se puede eliminar";
            $this->obj_consulta->free_rst($result);
        }
        $retorno = array('mensaje'=>$mensaje,'reg_afectado'=>$reg_afectado);
        return json_encode($retorno);
    }//Fin eliminarMotivoRechazo.

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>