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
$obj_combo = new clscomboxGrillas;
echo $obj_combo->$_POST['metodo']($_POST['parametros']);
class clscomboxGrillas
{
//=========================================================================================================================
//Clase		: clscombox
//Elaborado por	: Juan Carlos Díaz.
//Description	: Clase para la carga de combox.
//=========================================================================================================================
    private $obj_consulta;
    //private $obj_general;
    private $I;
    function __construct(){
        //require_once('../../sharedvp/clases/cls_general.php');
        //$this->obj_general = new general;
        require_once('../cnx/Db_class.php');
        $this->obj_consulta = new DB(); $this->I='I';
    }
    function consultasCG($str_d)
    {
        //=========================================================================================================================
        //Function      :consultasCG
        //Elaborado por :Juan C. Díaz.
        //Retorna       :Array con los registros encontrados.
        //Description   :Definición de consulta para la carga de combos.
        //=========================================================================================================================
        $tabla = $str_d['tabla'];
        $dependencia = $str_d['dependencia'];
        $dependencia_id = $str_d['dependencia_id'];
		$dependencia2 = $str_d['dependencia2'];
        $dependencia_id2 = $str_d['dependencia_id2'];
        $sql_criterio = "";
		$criterio = false;
        if ($dependencia){
			$sql_criterio .= ($criterio)? " AND ": " WHERE ";
			$sql_criterio .= $dependencia."_id = ".$dependencia_id;
			$criterio = true;
		}
		
		if ($dependencia2){
			$sql_criterio .= ($criterio)? " AND ": " WHERE ";
			$sql_criterio .= $dependencia2."_id = ".$dependencia_id2;
			$criterio = true;
		}  
        $sql_criterio .= " ORDER BY ".$tabla."_id";
        $sql_query = "SELECT ".$tabla."_id AS id, nombre_".$tabla." AS nombre FROM ".$tabla.$sql_criterio;//echo $sql_query;
        return $this->obj_consulta->ejecutar($sql_query,'consultasCG - clase clscombox ','select');
    }//Fin consulta_asignacasos.

    function cargaCombo($parametros)
    {
        if(!is_array($parametros)){
            $str_d = json_decode(stripcslashes($parametros),true);
        }else{
            $str_d = $str_d;
        }
        $result = $this->consultasCG($str_d);
        if ($this->obj_consulta->rstNroFilas($result)) {
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
            }
            $retorno = array('filas'=>$data);
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = array('filas'=>false);
        }
        return json_encode($retorno);//se lanza el json.
    }
}
?>
