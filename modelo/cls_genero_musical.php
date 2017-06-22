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
$obj_genero_musical = new clsgeneromusical; //Se instancia la clase
echo $obj_genero_musical->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clsgeneromusical {
//=========================================================================================================================
//Nombre	     : Clase cls_genero_musical
//Elaborado por  : Carlos Ceballos
//Fecha			 : 05/01/2012
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
    function consultaGeneroMusical($str_d='', $case='')    {
        $tabla='genero_musical';
	$campos = "*";
        $Union = '';
        switch($case){
            case "por_listado":
                $sql_criterio = " WHERE nombre_genero_musical ".$this->I."LIKE('%".$str_d['nombre_genero_musicalVM']."%')";
                break;
            case "por_listado_nombre":
                $campos = "nombre_genero_musical";
                break;
            case "valida_eliminar":
		$Union = ' INNER JOIN tema ON genero_musical.genero_musical_id = tema.genero_musical_id';
                $sql_criterio = " WHERE genero_musical.genero_musical_id = ".$str_d;
            break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
        return $this->obj_consulta->ejecutar($sql_query,'consultaArtista','select');
    }//Fin consultaArtista.

    function cargaGrilla($parametros){
       $str_d = json_decode(stripcslashes($parametros),true);
       $result = $this->consultaGeneroMusical($str_d,'por_listado','');
        if ($this->obj_consulta->rstNroFilas($result)) {
	    $A=0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                $data[$A]['nombre_genero_musical']=$data[$A]['nombre_genero_musical'];//$this->obj_general->htmlkarakter()
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
       $result = $this->consultaGeneroMusical('','por_listado_nombre','');
        if ($this->obj_consulta->rstNroFilas($result)) {
	    $A=0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                $data[$A]['nombre_genero_musical']=html_entity_decode($data[$A]['nombre_genero_musical'], ENT_QUOTES);
                $A++;
            }
            $retorno = array('filas' => $data);
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = array('filas' => false);
        }
        return json_encode($retorno);
    }//Fin availableTags.
	
    function ingresaGeneroMusical($parametros){
        $id_x = '';
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("INSERT INTO public.genero_musical (nombre_genero_musical)
            VALUES('%s')",
            htmlspecialchars($str_d['nombre_genero_musical'],3));
        $id_genero_musical = $this->obj_consulta->ejecutar($sql_query,'ingresaGeneroMusical','insert');
        $mensaje = $this->obj_general->msj_insert($id_genero_musical);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje,'id_genero_musical'=>$id_genero_musical);
        return json_encode($retorno);
    }//Fin ingresaArtista
    
    
    function actualizaGeneroMusical($parametros)    {
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("UPDATE genero_musical SET nombre_genero_musical = '%s' WHERE genero_musical_id = %s",
                htmlspecialchars($str_d['nombre_genero_musical'],3),
                $str_d['genero_musical_id']);
 
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaGeneroMusical','update');
        $mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        return json_encode($retorno);
    }//Fin actualizaGeneroMusical.  

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