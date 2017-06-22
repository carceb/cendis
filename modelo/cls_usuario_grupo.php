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
$obj_Usuario_Grupo = new clsUsuario_Grupo; //Se instancia la clase
echo $obj_Usuario_Grupo->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clsUsuario_Grupo {
//=========================================================================================================================
//Nombre	     : Clase clsUsuario_Grupo
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
    function consultaUsuarioGrupo($str_d='', $case=''){
    	$tabla='seguridad.usuario_grupo';
	    $campos = "*";
        $Union = '';
        switch($case){
            case "combo_usuario":
                $tabla = "seguridad.usuario";
                $campos = "usuario_id AS id, (usuario_nombre || ' ' || usuario_apellido) AS nombre";
                break;
            case "por_usuarios":
				$tabla='seguridad.usuario_grupo';
                $campos = "usuario.*,(usuario.usuario_nombre || ' ' || usuario.usuario_apellido) AS nombre,usuario_grupo.*";
                $Union = 'INNER JOIN seguridad.usuario ON usuario_grupo.usuario_id = usuario.usuario_id ';
                $sql_criterio = " WHERE (usuario_grupo.grupo_id = $str_d)";
                break;
            case "valida_eliminar":
            	break;
            case "valida_ingresar":
                $sql_criterio = " WHERE usuario_grupo.usuario_id = ".$str_d['usuario_id'];
                break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
        return $this->obj_consulta->ejecutar($sql_query,'consultaFinalidad','select');
    }//Fin consultaArtista.
	
	function cargaGrilla($parametros){
       $result = $this->consultaUsuarioGrupo('','combo_usuario','');
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
	
	function LlenarUsuarios($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $result = $this->consultaUsuarioGrupo($str_d['grupo_id'],'por_usuarios','');
        while ($filas = $this->obj_consulta->rstRegistros($result)) {
            if ($i%2==0){
                $background = '';
            }else{
                $background = 'background-color:#CCCCCC';
            }
            $div = '<tr style="'.$background.'" class="fila_usuarios">';
			$div .= '<td>&nbsp;'.$filas['usuario_user'].'</td>';
			$div .= '<td>&nbsp;'.$filas['nombre'].'</td>';
			$div .= '<td>';
			$div .= '<a href="#" onclick="eliminar('.$filas['usuario_id'].')"><div class="delete"></div></a></td>';
            $div .= '</tr>';
            $i++;
            $html = $html.$div;
        }
        $this->obj_consulta->free_rst($result);
        $retorno = array('html'=>$html);
        return json_encode($retorno);
    }//Fin Seleccionar.
	
    function ingresaUsuario_Grupo($parametros){
        $usuario_grupo_id = '';
        $str_d = json_decode(stripcslashes($parametros),true);
        $result = $this->consultaUsuarioGrupo($str_d,'valida_ingresar');//se verifica si el registro esta duplicado.
        if(!$this->obj_consulta->rstNroFilas($result)){
            $sql_query = sprintf("INSERT INTO seguridad.usuario_grupo (usuario_id, grupo_id, usuario_idreg, usuario_grupo_fechareg)
                    VALUES(%s, %s, %s, '%s')",
                    $str_d['usuario_id'],
                    $str_d['grupo_id'],
                    $_SESSION['id_user'],
                    $str_d['usuario_grupo_fechareg']);
            $usuario_grupo_id = $this->obj_consulta->ejecutar($sql_query,'ingresaUsuario_Grupo','insert');
            $mensaje = $this->obj_general->msj_insert($usuario_grupo_id);//se busca el mensaje de acuerdo al resultado de la operación
        }else{
            $mensaje = "ERROR: Disculpe, Ya existe el Usuario para este Grupo.";
            $this->obj_consulta->free_rst($result);
        }
	$retorno = array('mensaje'=>$mensaje,'usuario_grupo_id'=>$usuario_grupo_id);
        return json_encode($retorno);/**/
    }//Fin ingresaUsuario_Grupo.

    function eliminarUsuario_Grupo($grupo_id){
        $reg_afectado='';
        $str_d = json_decode(stripcslashes($parametros),true);
        $result = $this->consultaUsuarioGrupo($str_d,'valida_eliminar');//se verifica si el registro esta relacionado con una persona.
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
    }//Fin eliminarArtista.

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>