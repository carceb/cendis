<?php session_start();
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
        //Description   :Definici��n de consulta para la carga de combos.
        //=========================================================================================================================
        $tabla = $str_d['tabla'];
		$schema = $str_d['schema'];
        $dependencia = $str_d['dependencia'];
        $dependencia_id = $str_d['dependencia_id'];
                $dependencia2 = $str_d['dependencia2'];
        $dependencia_id2 = $str_d['dependencia_id2'];
        $dependencia3 = $str_d['dependencia3'];
        $sql_criterio = "";
        $criterio = false;
        if ($dependencia){
            $sql_criterio .= ($criterio)? " AND ": " WHERE ";
            $sql_criterio .= $dependencia."_id = ".$dependencia_id;
            $criterio = true;
        }
                
        if ($dependencia2){
            $sql_criterio .= ($criterio)? " AND ": " WHERE ";
            $sql_criterio .= $dependencia2."_id >= ".$dependencia_id2;
        }  
        $sql_criterio .= " ORDER BY nombre_".$tabla;
        $sql_query = "SELECT ".$tabla."_id AS id, nombre_".$tabla." AS nombre FROM ".$schema.".".$tabla.$sql_criterio;
		if ($dependencia3)
            $sql_query = $dependencia3;//echo $sql_query;
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
