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
$obj_Usuario = new clsUsuario; //Se instancia la clase
echo $obj_Usuario->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clsUsuario {
//=========================================================================================================================
//Nombre	     : Clase clsUsuario
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
    function consultaUsuario($str_d='', $case='')    {
    	$tabla='seguridad.usuario';
		$campos = "*";
        $Union = '';
        switch($case){
			case "por_listado":
				$sql_criterio = " WHERE usuario_cedula || ' ' || usuario_nombre || ' ' || usuario_apellido || ' ' || usuario_user ".$this->I."LIKE('%".$str_d['todoVM']."%')";
				$sql_criterio .= " ORDER BY usuario_id";
				break;
			case "cambio_clave":
				$sql_criterio = " WHERE usuario_id = ".$_SESSION['id_user'];
				break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";//echo $sql_query;
        return $this->obj_consulta->ejecutar($sql_query,'consultaFinalidad','select');
    }//Fin consultaArtista.

    function cargaGrilla($parametros){
       $str_d = json_decode(stripcslashes($parametros),true);
       $result = $this->consultaUsuario($str_d,'por_listado','');
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
	
    function ingresaUsuario($parametros){
        $id_x = '';
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("INSERT INTO seguridad.usuario (usuario_cedula, usuario_nombre, usuario_apellido, usuario_user, usuario_pws, usuario_estatus_id, usuario_idreg, usuario_fechareg)
            VALUES('%s', '%s', '%s', '%s', '%s', %s, %s, '%s')",
            $str_d['usuario_cedula'],
            $str_d['usuario_nombre'],
            $str_d['usuario_apellido'],
            $str_d['usuario_user'],
            md5($str_d['usuario_pws']),
            $str_d['usuario_estatus_id'],
            $_SESSION['id_user'],
            $str_d['usuario_fechareg']);
        $usuario_id = $this->obj_consulta->ejecutar($sql_query,'ingresaUsuario','insert');
        $mensaje = $this->obj_general->msj_insert($usuario_id);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje,'usuario_id'=>$usuario_id);
        return json_encode($retorno);
    }//Fin ingresaArtista.
	
    function actualizaUsuario($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("UPDATE seguridad.usuario SET usuario_cedula = '%s', usuario_nombre = '%s', usuario_apellido = '%s', usuario_user = '%s', usuario_estatus_id = %s, usuario_idreg = %s, usuario_fechareg = '%s' WHERE usuario_id = %s",
            $str_d['usuario_cedula'],
            $str_d['usuario_nombre'],
            $str_d['usuario_apellido'],
            $str_d['usuario_user'],
            $str_d['usuario_estatus_id'],
            $_SESSION['id_user'],
            $str_d['usuario_fechareg'],
			$str_d['usuario_id']);
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaUsuario','update');//echo $sql_query;
        $mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        return json_encode($retorno);
    }//Fin actualizaArtista.
	
	function cambioClave($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $result = $this->consultaUsuario('','cambio_clave');//se verifica si el registro esta relacionado con una persona.
        if ($this->obj_consulta->rstNroFilas($result)) {
			extract($this->obj_consulta->rstRegistros($result));
			if (md5($str_d['usuario_pws_old']) == $usuario_pws){
				$sql_query = sprintf("UPDATE seguridad.usuario SET usuario_pws = '%s' WHERE usuario_id = %s",
					md5($str_d['usuario_pws']),
					$_SESSION['id_user']);
				$reg_afectado = $this->obj_consulta->ejecutar($sql_query,'cambioClave','update');//echo $sql_query;
				$mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
				$retorno = array('mensaje'=>$mensaje);
			}else{
				$retorno = array('mensaje'=>'ERROR: La clave anterior no coincide');
			}				
		}
		$this->obj_consulta->free_rst($result);
        return json_encode($retorno);
    }//Fin cambioClave.

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>