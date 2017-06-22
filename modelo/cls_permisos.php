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
$obj_Permisos = new clsPermisos; //Se instancia la clase
echo $obj_Permisos->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clsPermisos {
//=========================================================================================================================
//Nombre	     : Clase clsPermisos
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
    function consultaPermisos($str_d='', $case='')    {
    	$tabla='seguridad.permisos';
		$campos = "*";
        $Union = '';
        switch($case){
            case "por_listado":
                $tabla='seguridad.grupo';
                if ($str_d['nombre_grupoVM'] != ''){
                    $sql_criterio = " WHERE nombre_grupo ".$this->I."LIKE('%".$str_d['nombre_grupoVM']."%')";
                }
                $sql_criterio .= " ORDER BY grupo_id";
                break;
            case "por_permisos":
                $Union = 'INNER JOIN seguridad.ventana ON permisos.ventana_id = ventana.ventana_id';
                $sql_criterio = " WHERE grupo_id = ".$str_d;	
                $sql_criterio .= " ORDER BY ventana.ventana_id";
                break;
            case "por_listado_nombre":
                $campos = "nombre_Permisos";
                break;
            case "valida_eliminar":
		$Union = ' INNER JOIN seguridad.usuario_grupo ON grupo.grupo_id = usuario_grupo.grupo_id';
                $sql_criterio = " WHERE grupo.grupo_id = ".$str_d;
            break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
        return $this->obj_consulta->ejecutar($sql_query,'consultaFinalidad','select');
    }//Fin consultaArtista.

    function cargaGrilla($parametros){
       $str_d = json_decode(stripcslashes($parametros),true);
       $result = $this->consultaPermisos($str_d,'por_listado','');
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
	
	function cargaPermisos($parametros){
            $str_d = json_decode(stripcslashes($parametros),true);
            $result = $this->consultaPermisos($str_d,'por_permisos','');
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
	
    function actualizaPermisos($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $this->actualizarP($str_d['permisos_ventana'],'permisos_ventana',$str_d['permisos_ventana']);
        $this->actualizarP($str_d['permisos_ingresar'],'permisos_ingresar',$str_d['permisos_ingresar']);
        $this->actualizarP($str_d['permisos_buscar'],'permisos_buscar',$str_d['permisos_buscar']);
        $this->actualizarP($str_d['permisos_modificar'],'permisos_modificar',$str_d['permisos_modificar']);
        $this->actualizarP($str_d['permisos_eliminar'],'permisos_eliminar',$str_d['permisos_eliminar']);
        $this->actualizarP($str_d['permisos_imprimir'],'permisos_imprimir',$str_d['permisos_imprimir']);
        $this->actualizarP($str_d['permisos_listar'],'permisos_listar',$str_d['permisos_listar']);
        $mensaje = 'La operación se ejecutó exitosamente';
        return $mensaje;
    }//Fin actualizaPermisos.

    function actualizarP($array_idsp, $nombre_campo, $nombre_usuario){
        //=========================================================================================================================
        //Function      :actualizarP.
        //Elaborado por :Juan C. Díaz.
        //Returns       :True o false.
        //Description   :Actualiza el registro de permisos de ecuerdo a los valores pasado mediante el $array_idsp(id persoso y
        //               permiso otorgado).
        //=========================================================================================================================
        foreach($array_idsp as $clave => $valor) {//se recorre el array.
            $valores = split(':',$valor); $id_permiso=$valores[0]; $permiso=$valores[1]; //se setea las variables con su correspondiente valor.
            $sql_query = sprintf("UPDATE seguridad.permisos SET $nombre_campo='%s' WHERE permisos_id='%s'",
                                    $permiso,
                                    $id_permiso);
            $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizarP','update');
        }
    }

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>