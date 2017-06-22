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
$obj_proyecto = new clsproyecto; //Se instancia la clase
echo $obj_proyecto->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clsproyecto {
//=========================================================================================================================
//Nombre	     : Clase clsproyecto
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
    function consultaProyecto($str_d='', $case='')    {
        $tabla='proyecto';
		$campos = '*';
        $Union = '';
        $sql_criterio = '';
        switch($case){
            case "por_listado":
                $Union = ' INNER JOIN artista ON proyecto.artista_id = artista.artista_id';
                $Union .= ' INNER JOIN estatus_proyecto ON proyecto.estatus_proyecto_id = estatus_proyecto.estatus_proyecto_id';
                if ($str_d['sel_artistaVM'] != ''){
                    $sql_criterio .= " WHERE proyecto.artista_id = ".$str_d['sel_artistaVM'];
                }
		$sql_criterio .= " ORDER BY nombre_proyecto";
                break;
            case "por_listado old":
                $criterio = false;
		$Union = ' INNER JOIN artista ON proyecto.artista_id = artista.artista_id';
                if ($str_d['sel_artistaVM'] != ''){
                    $sql_criterio .= ($criterio)? " AND": " WHERE";
                    $sql_criterio .= " proyecto.artista_id = ".$str_d['sel_artistaVM'];
                    $criterio = true;
                }else{
                    if ($str_d['sel_tipo_artistaVM'] != ''){
                        $sql_criterio .= ($criterio)? " AND": " WHERE";
                        $sql_criterio = " tipo_artista_id = ".$str_d['sel_tipo_artistaVM'];
                        $criterio = true;
                    }
                    if ($str_d['nombre_artistaVM'] != ''){
                        $sql_criterio .= ($criterio)? " AND": " WHERE";
                        $sql_criterio = " nombre_artista ".$this->I."LIKE('%".$str_d['nombre_artistaVM']."%')";
                        $criterio = true;
                    }
                    if ($str_d['cedula_artistaVM'] != ''){
                        $sql_criterio .= ($criterio)? " AND": " WHERE";
                        $sql_criterio .= " cedula_artista = ".$str_d['cedula_artistaVM'];
                        $criterio = true;
                    }
                    if ($str_d['sel_tipo_proyectoVM'] == '2'){
                        $sql_criterio .= ($criterio)? " AND": " WHERE";
                        $sql_criterio .= " tipo_proyecto_id = ".$str_d['sel_tipo_proyectoVM'];
                        $criterio = true;
                    }
                } 
                break;
            case "valida_eliminar":
                $sql_criterio = " WHERE proyecto_id = ".$str_d." AND estatus_proyecto_id != 1";
                break;
            case "valida_ingresa":
                $sql_criterio = " WHERE nombre_proyecto = '".htmlspecialchars($str_d['nombre_proyecto'],3)."'";
				$sql_criterio .= " AND artista_id = ".$str_d['artista_id'];
				$sql_criterio .= " AND tipo_proyecto_id= ".$str_d['tipo_proyecto_id'];
                break;
            case "por_requisito":
                $tabla='requisito';
                break;
            case "por_proyecto":
                $tabla='public.proyecto';
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id ';
                $sql_criterio = " WHERE (proyecto.proyecto_id = $str_d)";
                break;
        }
        
        $sql_query = "SELECT $campos FROM $tabla $Union ".$sql_criterio;
        return $this->obj_consulta->ejecutar($sql_query,'consultaProyecto','select');
    }//Fin consultaArtista.

    function cargaGrilla($parametros){
        $str_d = json_decode($parametros,true);
        $result = $this->consultaProyecto($str_d,'por_listado','');
        if ($this->obj_consulta->rstNroFilas($result)) {
            $A=0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $B=0;
                extract($filas);
                //consultar los requisitos
                $sql_query = "SELECT * FROM proyecto_requisito WHERE proyecto_id = $proyecto_id ORDER BY proyecto_requisito_id";//echo $sql_query;
                $result_requisito = $this->obj_consulta->ejecutar($sql_query,'cargaGrilla','select');
                while ($filas_requisito = $this->obj_consulta->rstRegistros($result_requisito)) {
                    $data_requisito[] = $filas_requisito; //se va llenando la matriz.
                    if ($data_requisito[$B]['requisito_id'] == 1)
                        $carta_solicitud = $data_requisito[$B]['proyecto_requisito_check'];
                    if ($data_requisito[$B]['requisito_id'] == 11)
                        $canciones_proyecto = $data_requisito[$B]['proyecto_requisito_check'];
                    if ($data_requisito[$B]['requisito_id'] == 18)
                        $dossier = $data_requisito[$B]['proyecto_requisito_check'];
                    $B++;//número de array siguiente.
                }
                $this->obj_consulta->free_rst($result_requisito);
				$data_requisito = "";
                //se va llenando la matriz.
                $data[] = $filas; 
                $data[$A]['fecha_proyecto']=$this->obj_general->formatea_fecha_normal($data[$A]['fecha_proyecto']);
                $data[$A]['nombre_proyecto']=$data[$A]['nombre_proyecto'];
                $data[$A]['carta_solicitud']=$carta_solicitud;
                $data[$A]['canciones_proyecto']=$canciones_proyecto;
                $data[$A]['dossier']=$dossier;
                $data[$A]['tipo_formato_id']=$tipo_formato_id;
                $data[$A]['nombre_estatus_proyecto']=htmlspecialchars($data[$A]['nombre_estatus_proyecto']);
                $data[$A]['nombre_siguiente_estatus_proyecto']=htmlspecialchars($data[$A]['nombre_siguiente_estatus_proyecto']);
                $A++;//número de array siguiente.
            }
            $retorno = array('filas' => $data);
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = array('filas' => false);
        }
        return json_encode($retorno);
    }//Fin cargaGrilla.
    
    function DatosProyecto($proyecto_id){
        $result = $this->consultaProyecto($proyecto_id,'por_proyecto','');
        extract($this->obj_consulta->rstRegistros($result));
        $registro['proyecto_id'] = $proyecto_id;
        $registro['artista_id'] = $artista_id;
        $registro['tipo_artista_id'] = $tipo_artista_id;
        $registro['tipo_proyecto_id'] = $tipo_proyecto_id;
        $registro['nombre_proyecto'] = $nombre_proyecto;
        $registro['numero_deposito_legal'] = $numero_deposito_legal;
        $registro['cantidad_copias'] = $cantidad_copias;
        $registro['numero_produccion'] = $numero_produccion;
        $retorno = $registro;
        $this->obj_consulta->free_rst($result);
        return json_encode($retorno);
    }//Fin listarGrilla.
	
    function ingresaProyecto($parametros){
                $str_d = json_decode($parametros,true);
		$proyecto_id = '';
		//$nombre_proyecto = htmlspecialchars($str_d['nombre_proyecto']);
		//$str_d['nombre_proyecto'] = $nombre_proyecto;
        $result = $this->consultaProyecto($str_d,'valida_ingresa');
        if(!$this->obj_consulta->rstNroFilas($result)){
			$sql_query = sprintf("INSERT INTO public.proyecto (artista_id, tipo_proyecto_id, genero_musical_id, nombre_proyecto, estatus_proyecto_id, fecha_proyecto, tipo_formato_id)
					VALUES(%s, %s, %s, '%s', %s, '%s', %s)",
					$str_d['artista_id'], 
					$str_d['tipo_proyecto_id'], 
					$str_d['genero_musical_id'], 
                                        htmlspecialchars($str_d['nombre_proyecto'],3),
					1, 
					$str_d['fecha_proyecto'],
					$str_d['tipo_formato_id']);
			$proyecto_id = $this->obj_consulta->ejecutar($sql_query,'ingresaProyecto','insert');
			$mensaje = $this->obj_general->msj_insert($proyecto_id);
			$str_d['proyecto_id'] = $proyecto_id;
			$this->ingresaProyectoRequisito($str_d);
		}else{
            $mensaje = "ERROR: Disculpe, El nombre Proyecto ya Existe. No se puede guardar";
        }
	$this->obj_consulta->free_rst($result);
        $retorno = array('mensaje'=>$mensaje,'proyecto_id'=>$proyecto_id);
        return json_encode($retorno);
    }//Fin ingresaProyecto.
	
    function actualizaProyecto($parametros){
        $str_d = json_decode($parametros,true);
        $sql_query = sprintf("UPDATE public.proyecto SET artista_id = %s, tipo_proyecto_id = %s, 
            genero_musical_id = %s, nombre_proyecto = '%s', fecha_proyecto = '%s',tipo_formato_id = %s
                WHERE proyecto_id = %s",
                $str_d['artista_id'], 
                $str_d['tipo_proyecto_id'], 
                $str_d['genero_musical_id'], 
                htmlspecialchars($str_d['nombre_proyecto'],3),
                $str_d['fecha_proyecto'],
                $str_d['tipo_formato_id'],
                $str_d['proyecto_id']);
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaProyecto','update');
        $mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        $this->actualizaProyectoRequisito($str_d);
        return json_encode($retorno);
    }//Fin actualizaArtista.

    function eliminarProyecto($proyecto_id){
        $reg_afectado='';
        /*$result = $this->consultaProyecto($proyecto_id,'valida_eliminar');//se verifica si el registro esta relacionado con una persona.
        if(!$this->obj_consulta->rstNroFilas($result)){
			$sql_query = sprintf("DELETE FROM proyecto_requisito WHERE proyecto_id = %s", $proyecto_id);
            $this->obj_consulta->ejecutar($sql_query,'eliminarProyecto','delete');
            $sql_query = sprintf("DELETE FROM proyecto WHERE proyecto_id = %s", $proyecto_id);
            $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'eliminarProyecto','delete');
            $mensaje = $this->obj_general->msj_delete($reg_afectado);
        }else{
            $mensaje = "ERROR: Disculpe, El Proyecto ya fue revisado por Comisi&oacute;n Art&iacute;stica. No se puede eliminar";
            $this->obj_consulta->free_rst($result);
        }*/
		
		//proyecto_requisito
		$sql_query = sprintf("DELETE FROM proyecto_requisito WHERE proyecto_id = %s", $proyecto_id);
		$this->obj_consulta->ejecutar($sql_query,'eliminarProyecto','delete');
		//proyecto_historico
		$sql_query = sprintf("DELETE FROM proyecto_historico WHERE proyecto_id = %s", $proyecto_id);
		$this->obj_consulta->ejecutar($sql_query,'eliminarProyecto','delete');
		//proyecto_historico
		$sql_query = sprintf("DELETE FROM tema WHERE proyecto_id = %s", $proyecto_id);
		$this->obj_consulta->ejecutar($sql_query,'eliminarProyecto','delete');
		//proyecto_historico
		$sql_query = sprintf("DELETE FROM diseno WHERE proyecto_id = %s", $proyecto_id);
		$this->obj_consulta->ejecutar($sql_query,'eliminarProyecto','delete');
		//proyecto_historico
		$sql_query = sprintf("DELETE FROM audio WHERE proyecto_id = %s", $proyecto_id);
		$this->obj_consulta->ejecutar($sql_query,'eliminarProyecto','delete');
		//proyecto_historico
		$sql_query = sprintf("DELETE FROM credito WHERE proyecto_id = %s", $proyecto_id);
		$this->obj_consulta->ejecutar($sql_query,'eliminarProyecto','delete');
		//proyecto_historico
		$sql_query = sprintf("DELETE FROM produccion_industrial WHERE proyecto_id = %s", $proyecto_id);
		$this->obj_consulta->ejecutar($sql_query,'eliminarProyecto','delete');
		//proyecto_historico
		$sql_query = sprintf("DELETE FROM distribucion WHERE proyecto_id = %s", $proyecto_id);
		$this->obj_consulta->ejecutar($sql_query,'eliminarProyecto','delete');
		//proyecto
		$sql_query = sprintf("DELETE FROM proyecto WHERE proyecto_id = %s", $proyecto_id);
		$reg_afectado = $this->obj_consulta->ejecutar($sql_query,'eliminarProyecto','delete');
		$mensaje = $this->obj_general->msj_delete($reg_afectado);
        $retorno = array('mensaje'=>$mensaje,'reg_afectado'=>$reg_afectado);
        return json_encode($retorno);
    }//Fin eliminarProyecto.
    
    function ingresaProyectoRequisito($str_d){
        $result = $this->consultaProyecto('','por_requisito','');
        if ($this->obj_consulta->rstNroFilas($result)) {
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                if ($str_d['carta_solicitud'] == 't' && $filas['requisito_id'] == 1){
                    $sql_query = sprintf("INSERT INTO public.proyecto_requisito (proyecto_id, requisito_id, proyecto_requisito_check)
                            VALUES(%s, %s, '%s')",
                            $str_d['proyecto_id'], 
                            $filas['requisito_id'],
                            $str_d['carta_solicitud']);
                    $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','insert');
                }else if($str_d['canciones_proyecto'] == 't' && $filas['requisito_id'] == 11){
                    $sql_query = sprintf("INSERT INTO public.proyecto_requisito (proyecto_id, requisito_id, proyecto_requisito_check)
                            VALUES(%s, %s, '%s')",
                            $str_d['proyecto_id'], 
                            $filas['requisito_id'],
                            $str_d['canciones_proyecto']);
                    $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','insert');
                }else if($str_d['dossier'] == 't' && $filas['requisito_id'] == 18){
                    $sql_query = sprintf("INSERT INTO public.proyecto_requisito (proyecto_id, requisito_id, proyecto_requisito_check)
                            VALUES(%s, %s, '%s')",
                            $str_d['proyecto_id'], 
                            $filas['requisito_id'],
                            $str_d['dossier']);
                    $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','insert');
                }else{
                    $sql_query = sprintf("INSERT INTO public.proyecto_requisito (proyecto_id, requisito_id)
                            VALUES(%s, %s)",
                            $str_d['proyecto_id'], 
                            $filas['requisito_id']);
                    $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','insert');
                } 
            }
            $retorno = array('filas' => $data);
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = array('filas' => false);
        }
    }
    
    function actualizaProyectoRequisito($str_d){
        $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s'
                WHERE proyecto_id = %s AND requisito_id = 1",
                $str_d['carta_solicitud'],
                $str_d['proyecto_id']);
        $this->obj_consulta->ejecutar($sql_query,'actualizaProyectoRequisito','update');
        $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s'
                WHERE proyecto_id = %s AND requisito_id = 11",
                $str_d['canciones_proyecto'],
                $str_d['proyecto_id']);
        $this->obj_consulta->ejecutar($sql_query,'actualizaProyectoRequisito','update');
        $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s'
                WHERE proyecto_id = %s AND requisito_id = 18",
                $str_d['dossier'],
                $str_d['proyecto_id']);
        $this->obj_consulta->ejecutar($sql_query,'actualizaProyectoRequisito','update');
        
    }
	
    function cantidadEntregadaEnDistribucionFinalizada($proyecto_id){
        
        $sql_query = sprintf("SELECT distribucion.proyecto_id, fecha_fin_distribucion, estatus_distribucion_id, distribucion_detalle.cantidad_distribucion_detalle AS total_distribuido
        FROM distribucion_detalle INNER JOIN distribucion ON distribucion_detalle.distribucion_id = distribucion.distribucion_id
        GROUP BY distribucion.proyecto_id, fecha_fin_distribucion, distribucion_detalle.estatus_distribucion_id, distribucion_detalle.cantidad_distribucion_detalle
        HAVING estatus_distribucion_id = 1 AND distribucion.proyecto_id=%s" , $proyecto_id);
        
        /*$sql_query =sprintf("SELECT distribucion.proyecto_id, fecha_fin_distribucion, Sum(distribucion_detalle.cantidad_distribucion_detalle) AS total_distribuido
        FROM distribucion_detalle INNER JOIN distribucion ON distribucion_detalle.distribucion_id = distribucion.distribucion_id
        GROUP BY distribucion.proyecto_id, fecha_fin_distribucion
        HAVING distribucion.proyecto_id=%s", $proyecto_id);
*/
        $result = $this->obj_consulta->ejecutar($sql_query,'cantidadEntregadaEnDistribucionFinalizada','select');
        if ($this->obj_consulta->rstNroFilas($result)){
            extract($this->obj_consulta->rstRegistros($result));
            if($fecha_fin_distribucion != ''){
                $retorno = array('total_distribuido'=>$total_distribuido);
            }
            else
            {
                $retorno = array('total_distribuido'=>'');
            }
            return json_encode($retorno);
        }
        else
        {
            $retorno = array('total_distribuido'=>'');
            return json_encode($retorno);
        }   
    }    
    
}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>