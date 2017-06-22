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

$obj_artista = new clsartista; //Se instancia la clase
echo $obj_artista->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clsartista {
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
    function consultaArtista($str_d='', $case='')    {
        $tabla='artista';
	$campos = "*";
        $Union = '';
        switch($case){
            case "por_listado":
                
                $sql_criterio = " WHERE nombre_artista ".$this->I."LIKE('%".htmlspecialchars($str_d['nombre_artistaVM'],3)."%')";
				$sql_criterio .= " ORDER BY nombre_artista";
                break;
            case "por_listado_nombre":
                $campos = "nombre_artista";
                break;
            case "valida_eliminar":
		$Union = ' INNER JOIN proyecto ON artista.artista_id = proyecto.artista_id';
                $sql_criterio = " WHERE artista.artista_id = ".$str_d;
            break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
        return $this->obj_consulta->ejecutar($sql_query,'consultaFinalidad','select');
    }//Fin consultaArtista.

    function cargaGrilla($parametros){
		$str_d = json_decode(stripcslashes($parametros),true);
		$result = $this->consultaArtista($str_d,'por_listado','');
		if ($this->obj_consulta->rstNroFilas($result)) {
			$A=0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                $data[$A]['nombre_artista']=$data[$A]['nombre_artista'];
                $data[$A]['fecha_ingreso_artista']=$this->obj_general->formatea_fecha_normal($data[$A]['fecha_ingreso_artista']);
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
       	$result = $this->consultaArtista('','por_listado_nombre','');
        if ($this->obj_consulta->rstNroFilas($result)) {
            //echo ('rrr');
	    	$A=0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                $data[$A]['nombre_artista']=html_entity_decode($data[$A]['nombre_artista'], ENT_QUOTES);
                $A++;
            }
            $retorno = array('filas' => $data);
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = array('filas' => false);
        }
        return json_encode($retorno);
    }//Fin availableTags.
	
    function ingresaArtista($parametros){
       	$str_d = json_decode($parametros,true);
        $sql_query = sprintf("INSERT INTO public.artista (tipo_artista_id, nombre_artista, sexo_id, 
            fecha_ingreso_artista, nacionalidad_id, pais_id, cedula_artista, cedula_representante_artistico, 
            nombre_representante_artistico, telefono_habitacion, telefono_celular, telefono_otro, email_artista, 
            direccion_artista, estado_id, municipio_id)
            VALUES(%s, '%s', %s, '%s', %s, %s, %s, %s, '%s', '%s', '%s', '%s', '%s', '%s', %s, %s)",
            $str_d['tipo_artista_id'],
            htmlspecialchars($str_d['nombre_artista'],3),
            $str_d['sexo_id']?$str_d['sexo_id']:1,
            $str_d['fecha_ingreso_artista'],
            $str_d['nacionalidad_id']?$str_d['nacionalidad_id']:1,
            $str_d['pais_id']?$str_d['pais_id']:1,
            $str_d['cedula_artista'],
            $str_d['cedula_representante_artistico'],
            htmlspecialchars($str_d['nombre_representante_artistico'],3), 
            $str_d['telefono_habitacion'],
            $str_d['telefono_celular'],
            $str_d['telefono_otro'],
            $str_d['email_artista'],
            htmlspecialchars($str_d['direccion_artista'],3),
            $str_d['estado_id']?$str_d['estado_id']:1,
            $str_d['municipio_id']?$str_d['municipio_id']:1);
        $id_artista = $this->obj_consulta->ejecutar($sql_query,'ingresaArtista','insert');
        $mensaje = $this->obj_general->msj_insert($id_artista);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje,'id_artista'=>$id_artista);
        return json_encode($retorno);
    }//Fin ingresaArtista.
	
    function actualizaArtista($parametros){
       	$str_d = json_decode($parametros,true);
        $sql_query = sprintf("UPDATE artista SET tipo_artista_id = %s, nombre_artista = '%s', sexo_id = %s, 
            fecha_ingreso_artista = '%s', nacionalidad_id = %s, pais_id = %s, cedula_artista = %s, cedula_representante_artistico = %s, 
            nombre_representante_artistico = '%s', telefono_habitacion = '%s', telefono_celular = '%s', telefono_otro = '%s', 
            email_artista = '%s', direccion_artista = '%s', estado_id = %s, municipio_id  = %s
            WHERE artista_id = %s",
            $str_d['tipo_artista_id'], 
            htmlspecialchars($str_d['nombre_artista'],3), 
            $str_d['sexo_id']?$str_d['sexo_id']:1,
            $str_d['fecha_ingreso_artista'],
            $str_d['nacionalidad_id']?$str_d['nacionalidad_id']:1,
            $str_d['pais_id']?$str_d['pais_id']:1,
            $str_d['cedula_artista'],
            $str_d['cedula_representante_artistico'],
            htmlspecialchars($str_d['nombre_representante_artistico'],3), 
            $str_d['telefono_habitacion'],
            $str_d['telefono_celular'],
            $str_d['telefono_otro'],
            $str_d['email_artista'],
            htmlspecialchars($str_d['direccion_artista'],3),
            $str_d['estado_id']?$str_d['estado_id']:1,
            $str_d['municipio_id']?$str_d['municipio_id']:1,
            $str_d['artista_id']);
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaArtista','update');
        $mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        return json_encode($retorno);
    }//Fin actualizaArtista.

    function eliminarArtista($artista_id){
        $reg_afectado='';
        $result = $this->consultaArtista($artista_id,'valida_eliminar');//se verifica si el registro esta relacionado con una persona.
        if(!$this->obj_consulta->rstNroFilas($result)){
            $sql_query = sprintf("DELETE FROM artista WHERE artista_id = %s", $artista_id);
            $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'eliminarArtista','delete');
            $mensaje = $this->obj_general->msj_delete($reg_afectado);
        }else{
            $mensaje = "ERROR: Disculpe, El Artista o Grupo, esta asociado a un Proyecto Musical. No se puede eliminar";
            $this->obj_consulta->free_rst($result);
        }
        $retorno = array('mensaje'=>$mensaje,'reg_afectado'=>$reg_afectado);
        return json_encode($retorno);
    }//Fin eliminarArtista.

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>