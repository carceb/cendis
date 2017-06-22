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
    function consultaCredito($str_d='', $case=''){
        $tabla='public.credito';
	$campos = "credito.*,proyecto.artista_id,proyecto.nombre_proyecto,artista.tipo_artista_id";
        $Union = '';
        switch($case){
            case "por_seleccion":
                $Union = 'INNER JOIN public.proyecto ON credito.proyecto_id = proyecto.proyecto_id ';
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $sql_criterio = " WHERE (credito.proyecto_id = $str_d)";
                break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
        return $this->obj_consulta->ejecutar($sql_query,'consultaCredito','select');
    }//Fin consultaCredito.

    

    function SeleccionarProyecto($proyecto_id){
        $result = $this->consultaCredito($proyecto_id,'por_seleccion','');
        if ($this->obj_consulta->rstNroFilas($result)) {
            extract($this->obj_consulta->rstRegistros($result));
            $registro['proyecto_id'] = $proyecto_id;
            $registro['credito_id'] = $credito_id;
            $registro['productor_musical'] = htmlspecialchars_decode($credito_productor_musical,3);
            $registro['productor_ejecutivo'] = htmlspecialchars_decode($credito_productor_ejecutivo,3);
            $registro['nombre_proyecto'] = htmlspecialchars_decode($nombre_proyecto,3);
            $registro['credito_interpretes'] = htmlspecialchars_decode($credito_interpretes,3);
            $registro['arreglista'] = htmlspecialchars_decode($credito_arreglista,3);
            $registro['ing_grabacion'] = htmlspecialchars_decode($ing_grabacion,3);
            $registro['ing_mezcla'] = htmlspecialchars_decode($ing_mezcla,3);
            $registro['ing_masterizacion'] = htmlspecialchars_decode($ing_masterizacion,3);
            $registro['otros'] = htmlspecialchars_decode($credito_otros,3);
            $registro['credito_interpretes'] = htmlspecialchars_decode($credito_interpretes,3);
            $retorno = $registro;
        } else {
            $retorno = false;
        }
        $this->obj_consulta->free_rst($result);
        return json_encode($retorno);
    }//Fin    

    function cargaGrilla($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $result = $this->consultaTema($str_d['sel_proyectoVM'],'por_listado','');
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
    
 
    function ingresaCredito($parametros){
       $str_d = json_decode($parametros,true);
        $sql_query = sprintf("INSERT INTO public.credito (proyecto_id, credito_productor_musical, 
            credito_productor_ejecutivo, credito_arreglista, ing_grabacion, ing_mezcla, 
            ing_masterizacion, credito_otros, credito_interpretes)
            VALUES(%s, '%s', '%s', '%s', '%s', '%s', '%s', '%s','%s')",
                $str_d['proyecto_id'], 
                htmlspecialchars($str_d['productor_musical'],3),
                htmlspecialchars($str_d['productor_ejecutivo'],3), 
                htmlspecialchars($str_d['arreglista'],3), 
                htmlspecialchars($str_d['ing_grabacion'],3), 
                htmlspecialchars($str_d['ing_mezcla'],3), 
                htmlspecialchars($str_d['ing_masterizacion'],3), 
                htmlspecialchars($str_d['otros'],3),
                htmlspecialchars($str_d['credito_interpretes'],3));    
        $credito_id = $this->obj_consulta->ejecutar($sql_query,'ingresaCredito','insert');
        $mensaje = $this->obj_general->msj_insert($credito_id);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje,'credito_id'=>$credito_id);
        return json_encode($retorno);
    }//Fin ingresaCredito.    
    
	
    function actualizaCredito($parametros){
		$str_d = json_decode($parametros,true);
		$sql_query = sprintf("UPDATE public.credito SET credito_productor_musical = '%s', credito_productor_ejecutivo = '%s', 
			credito_arreglista = '%s', ing_grabacion = '%s', ing_mezcla = '%s', ing_masterizacion = '%s', credito_otros = '%s' ,
			credito_interpretes = '%s' WHERE credito_id = %s",
			htmlspecialchars($str_d['productor_musical'],3), 
			htmlspecialchars($str_d['productor_ejecutivo'],3), 
			htmlspecialchars($str_d['arreglista'],3), 
			htmlspecialchars($str_d['ing_grabacion'],3), 
			htmlspecialchars($str_d['ing_mezcla'],3), 
			htmlspecialchars($str_d['ing_masterizacion'],3),                 
			htmlspecialchars($str_d['otros'],3),  
			htmlspecialchars($str_d['credito_interpretes'],3), 
			$str_d['credito_id']);
		$reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaCredito','update');
		$mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        return json_encode($retorno);
    }//Fin actualizaCredito. 
    
    function eliminarCredito($credito_id){
        $reg_afectado='';
        if(!$this->obj_consulta->rstNroFilas($result)){
            $sql_query = sprintf("DELETE FROM credito WHERE credito_id = %s", $credito_id);
            $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'eliminarCredito','delete');
            $mensaje = $this->obj_general->msj_delete($reg_afectado);
        }
        $retorno = array('mensaje'=>$mensaje,'reg_afectado'=>$reg_afectado);
        return json_encode($retorno);
    }
    
}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>