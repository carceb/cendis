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
$obj_Grupo = new clsGrupo; //Se instancia la clase
echo $obj_Grupo->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clsGrupo{
//=========================================================================================================================
//Nombre	     : Clase clsartista
//Elaborado por  : Juan Carlos Díaz
//Fecha			 : 22/10/2011
//Description	 : Ingreso y mantenimiento de Cargos del personal.
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
    function consultaGrupo($str_d='', $case=''){
    	$tabla='seguridad.grupo';
	$campos = "*";
        $Union = '';
        $sql_criterio ='';
        switch($case){
            case "por_listado":
                $sql_criterio = " WHERE nombre_grupo ".$this->I."LIKE('%".$str_d['nombre_grupoVM']."%')";
		$sql_criterio .= " ORDER BY grupo_id";
                break;
            case "por_ventanas":
                $tabla='seguridad.ventana';
                break;
            case "valida_eliminar":
		$Union = ' INNER JOIN seguridad.usuario_grupo ON grupo.grupo_id = usuario_grupo.grupo_id';
                $sql_criterio = " WHERE grupo.grupo_id = ".$str_d;
            break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
        return $this->obj_consulta->ejecutar($sql_query,'consultaFinalidad','select');
    }//Fin consultaGrupo.

    function cargaGrilla($parametros){
       $str_d = json_decode(stripcslashes($parametros),true);
       $result = $this->consultaGrupo($str_d,'por_listado','');
       if ($this->obj_consulta->rstNroFilas($result)) {
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
            }
            $retorno = array('filas' => $data);
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = array('filas' => false);
        }
        return json_encode($retorno);
    }//Fin cargaGrilla.
	
    function ingresaGrupo($parametros){
        $id_x = '';
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("INSERT INTO seguridad.grupo (nombre_grupo, descripcion_grupo, usuario_idreg, grupo_fechareg)
            VALUES('%s', '%s', %s, '%s')",
            htmlspecialchars($str_d['nombre_grupo'],3),
            $str_d['descripcion_grupo'],
            $_SESSION['id_user'],
            $str_d['grupo_fechareg']);
        $str_d['grupo_id'] = $this->obj_consulta->ejecutar($sql_query,'ingresaGrupo','insert');
        $mensaje = $this->obj_general->msj_insert($str_d['grupo_id']);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje,'grupo_id'=>$str_d['grupo_id']);
        $this->ingresaPermisos($str_d);
        return json_encode($retorno);
    }//Fin ingresaGrupo.
	
    function actualizaGrupo($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("UPDATE seguridad.grupo SET nombre_grupo = '%s', descripcion_grupo = '%s', usuario_idreg = %s, 
		    grupo_fechareg = '%s' WHERE grupo_id = %s",
                    htmlspecialchars($str_d['nombre_grupo'],3),
                    $str_d['descripcion_grupo'],
                    $_SESSION['id_user'],
                    $str_d['grupo_fechareg'],
                    $str_d['grupo_id']);
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaGrupo','update');//echo $sql_query;      
        $mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        $this->ingresaPermisos($str_d);
        return json_encode($retorno);
    }//Fin actualizaGrupo.

    function eliminarGrupo($grupo_id){
        $reg_afectado='';
        $result = $this->consultaGrupo($grupo_id,'valida_eliminar');//se verifica si el registro esta relacionado con una persona.
        if(!$this->obj_consulta->rstNroFilas($result)){
            $sql_query = sprintf("DELETE FROM seguridad.grupo WHERE grupo_id = %s", $grupo_id);
            $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'eliminarGrupo','delete');
            $mensaje = $this->obj_general->msj_delete($reg_afectado);
        }else{
            $mensaje = "ERROR: Disculpe, El Grupo, esta asociado a un Grupo de Usuario. No se puede eliminar";
            $this->obj_consulta->free_rst($result);
        }
        $retorno = array('mensaje'=>$mensaje,'reg_afectado'=>$reg_afectado);
        return json_encode($retorno);
    }//Fin eliminarGrupo.
	
	function ingresaPermisos($str_d){
		$result = $this->consultaGrupo($str_d,'por_ventanas','');
		$A=0;
		while ($filas = $this->obj_consulta->rstRegistros($result)) {
                    $data[] = $filas;
                    if ($this->grupoConPermiso($str_d['grupo_id'],$data[$A]['ventana_id'])==false){
                        $sql_query = sprintf("INSERT INTO seguridad.permisos (grupo_id, ventana_id, aplicacion_id, usuario_idreg, permisos_fechareg)
                                VALUES(%s, %s, %s, %s, '%s')",
                                $str_d['grupo_id'],
                                $data[$A]['ventana_id'],
                                1,//Aplicacion sisCendis
                                $_SESSION['id_user'],
                                $str_d['grupo_fechareg']);
                        $grupo_id = $this->obj_consulta->ejecutar($sql_query,'ingresaGrupo','insert');
                    }
                    $A++;
		}
        return;
    }//Fin ingresaGrupo.
    function grupoConPermiso($grupo_id, $ventana_id){
        $retorno = FALSE;
        $sql_query ="SELECT * FROM seguridad.permisos WHERE grupo_id = $grupo_id AND ventana_id = $ventana_id";
        $result = $this->obj_consulta->ejecutar($sql_query,'grupoConPermiso','select');
        while ($filas = $this->obj_consulta->rstRegistros($result)){
            $retorno = TRUE;
        }
        return $retorno;
    }

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>