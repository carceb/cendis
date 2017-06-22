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
//Nombre	     : Clase cls_produccion_industrial
//Elaborado por  : Carlos Ceballos
//Fecha			 : 29/11/2011
//Description	 : Registrar estatus en las fases del proceso de produccion industrial.
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
    function consultaProduccionIndustrial($str_d='', $case=''){
        $tabla='public.produccion_industrial';
	$campos = "produccion_industrial.*,proyecto.artista_id,proyecto.nombre_proyecto,artista.tipo_artista_id";
        $Union = '';
        switch($case){
            case "por_listado":
                $Union = 'INNER JOIN public.proyecto ON produccion_industrial.proyecto_id = proyecto.proyecto_id ';
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $sql_criterio = " WHERE (produccion_industrial.proyecto_id = $str_d) ORDER BY produccion_industrial_id";
                break;
            case "por_listar":
                $tabla='public.proyecto';
                $campos = "proyecto.*,artista.nombre_artista,tipo_artista.nombre_tipo_artista,genero_musical.nombre_genero_musical";
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id ';
                $Union .= 'INNER JOIN public.genero_musical ON proyecto.genero_musical_id = genero_musical.genero_musical_id ';
                $sql_criterio = " WHERE (proyecto.estatus_proyecto_id = 5)";
                break;
            case "por_cambio":
                $campos = "*";
                $sql_criterio = " WHERE (proyecto_id = ".$str_d['proyecto_id'].")";
                $sql_criterio .= " AND (estatus_produccion_industrial_id = ".$str_d['estatus_produccion_industrial_id'].")";
                $sql_criterio .= " AND (estatus_produccion_industrial_check = '".$str_d['estatus_produccion_industrial_check']."')";
                break;
            case "por_tipo_proyecto":
                $tabla='public.proyecto';
                $campos = "*";
                $sql_criterio = " WHERE (proyecto.proyecto_id = $str_d)";
                break;        
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
        return $this->obj_consulta->ejecutar($sql_query,'consultaProduccionIndustrial','select');
    }//Fin consultaProduccionIndustrial
    
   
    function SeleccionarProyecto($proyecto_id){
        $result = $this->consultaProduccionIndustrial($proyecto_id,'por_listado','');
        if ($this->obj_consulta->rstNroFilas($result)) {
            $A = 0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                if ($A == 0){
                    $registro['proyecto_id'] = $proyecto_id;
                    $registro['produccion_industrial_id'] = $data[$A]['produccion_industrial_id'];
                    $registro['artista_id'] = $data[$A]['artista_id'];
                    $registro['tipo_artista_id'] = $data[$A]['tipo_artista_id'];
                    $registro['nombre_proyecto'] = $data[$A]['nombre_proyecto'];
                }
                if ($data[$A]['estatus_produccion_industrial_id'] == 1){
                    $registro['masterizacion'] = $data[$A]['estatus_produccion_industrial_check'];
                    $registro['masterizacion_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_produccion_industrial']);
                }
                if ($data[$A]['estatus_produccion_industrial_id'] == 2){
                    $registro['replicacion'] = $data[$A]['estatus_produccion_industrial_check'];
                    $registro['replicacion_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_produccion_industrial']);
                }
                if ($data[$A]['estatus_produccion_industrial_id'] == 3){
                    $registro['pintado'] = $data[$A]['estatus_produccion_industrial_check'];
                    $registro['pintado_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_produccion_industrial']);
                }
                $A++;//número de array siguiente.
            }
            $retorno = $registro;
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = false;
        }
        return json_encode($retorno);
    }//Fin cargaGrilla.
    
    function ingresaProduccionIndustrial($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("INSERT INTO public.produccion_industrial (proyecto_id, estatus_produccion_industrial_id, 
            estatus_produccion_industrial_check)
            VALUES(%s, %s, '%s')",
            $str_d['proyecto_id'],
            1,
            $str_d['masterizacion']);
        $this->obj_consulta->ejecutar($sql_query,'ingresaProduccionIndustrial','insert');                    

        $sql_query = sprintf("INSERT INTO public.produccion_industrial (proyecto_id, estatus_produccion_industrial_id, 
            estatus_produccion_industrial_check)
            VALUES(%s, %s, '%s')",
            $str_d['proyecto_id'],
            2,
            $str_d['replicacion']);     
        $this->obj_consulta->ejecutar($sql_query,'ingresaProduccionIndustrial','insert');


        $sql_query = sprintf("INSERT INTO public.produccion_industrial (proyecto_id, estatus_produccion_industrial_id, 
            estatus_produccion_industrial_check)
            VALUES(%s, %s, '%s')",
            $str_d['proyecto_id'],
            3,
            $str_d['pintado']);     
        $this->obj_consulta->ejecutar($sql_query,'ingresaProduccionIndustrial','insert'); 
        
        //actualiza el estatus proyecto
        if ($str_d['pintado'] == 't'){
            $sql_query = sprintf("UPDATE public.proyecto SET estatus_proyecto_id = %s
                WHERE proyecto_id = %s",
                6, 
                $str_d['proyecto_id']);
            $this->obj_consulta->ejecutar($sql_query,'actualizaEstatusProyecto','update');
        }
        $retorno = array('mensaje'=>'La operación se efectuó exitosamente');
        return json_encode($retorno);
    }//Fin produccion_industrial
	
    function actualizaProduccionIndustrial($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        if ($this->cambioActualiza($str_d['proyecto_id'],1,$str_d['masterizacion'])){
            $sql_query = sprintf("UPDATE public.produccion_industrial SET estatus_produccion_industrial_check = '%s'
                WHERE proyecto_id = %s AND estatus_produccion_industrial_id = 1",
                $str_d['masterizacion'],
                $str_d['proyecto_id']);
            $this->obj_consulta->ejecutar($sql_query,'actualizaProduccionIndustrial','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],2,$str_d['replicacion'])){
            $sql_query = sprintf("UPDATE public.produccion_industrial SET estatus_produccion_industrial_check = '%s'
                WHERE proyecto_id = %s AND estatus_produccion_industrial_id = 2",
                $str_d['replicacion'],
                $str_d['proyecto_id']);
            $this->obj_consulta->ejecutar($sql_query,'actualizaProduccionIndustrial','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],3,$str_d['pintado'])){
            $sql_query = sprintf("UPDATE public.produccion_industrial SET estatus_produccion_industrial_check = '%s'
            WHERE proyecto_id = %s AND estatus_produccion_industrial_id = 3",
            $str_d['pintado'],
            $str_d['proyecto_id']);
            $this->obj_consulta->ejecutar($sql_query,'actualizaProduccionIndustrial','update');

            if ($str_d['pintado'] == 't'){
                $sql_query = sprintf("UPDATE public.proyecto SET estatus_proyecto_id = %s
                    WHERE proyecto_id = %s",
                    6, 
                    $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'actualizaEstatusProyecto','update');
            }else{
                $result = $this->consultaProduccionIndustrial($str_d['proyecto_id'],'por_tipo_proyecto','');
                extract($this->obj_consulta->rstRegistros($result));
                if ($estatus_proyecto_id == 6){
                    $sql_query = sprintf("UPDATE public.proyecto SET estatus_proyecto_id = %s
                        WHERE proyecto_id = %s",
                        5, 
                        $str_d['proyecto_id']);
                    $this->obj_consulta->ejecutar($sql_query,'actualizaEstatusProyecto','update');
                }
                $this->obj_consulta->free_rst($result);
            }
         }
        $retorno = array('mensaje'=>'La operación se efectuó exitosamente');
        return json_encode($retorno);
       
    }//Fin actualizaDiseno
        
    function cambioActualiza($proyecto_id,$estatus_produccion_industrial_id,$estatus_produccion_industrial_check){
        $str_d['proyecto_id'] = $proyecto_id;
        $str_d['estatus_produccion_industrial_id'] = $estatus_produccion_industrial_id;
        $str_d['estatus_produccion_industrial_check'] = $estatus_produccion_industrial_check;
        $result = $this->consultaProduccionIndustrial($str_d,'por_cambio','');
        if ($this->obj_consulta->rstNroFilas($result))
            return false;
        else
            return true;
    }
    
    function listarGrilla($proyecto_id){
        $result = $this->consultaProduccionIndustrial('','por_listar','');
        if ($this->obj_consulta->rstNroFilas($result)){
            $i = 1;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                //echo var_dump($filas);
                if ($i%2==0){
                    $background = '';
                }else{
                    $background = 'background-color:#CCCCCC';
                }
                $div = '<tr style="'.$background.'" class="fila_catalogo">';
				$div .= '<td>&nbsp;'.$filas['nombre_tipo_artista'].'</td>';
				$div .= '<td>&nbsp;'.$filas['nombre_artista'].'</td>';
				$div .= '<td>&nbsp;<a href="#" onclick="SeleccionarProyectoListar('.$filas['proyecto_id'].')">'.$filas['nombre_proyecto'].'</a></td>';
				$div .= '<td>&nbsp;'.$filas['nombre_genero_musical'].'</td>';
				$div .= '</tr>';
                $i++;
                $html = $html.$div;
            }
            $retorno = array('mensaje'=>$mensaje,'html'=>$html);
            return json_encode($retorno);
        } else {
            $retorno = false;
        }
        return json_encode($retorno);
    }//Fin listarGrilla.

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>