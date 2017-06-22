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
//Nombre	     : Clase cls_distribucion
//Elaborado por  : Carlos Ceballos
//Fecha			 : 29/11/2011
//Description	 : Registrar estatus en las fases del proceso de distribucion industrial.
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
    function consultaDistribucion($str_d='', $case=''){
        $tabla='public.distribucion';
	$campos = "*";
        $Union = '';
        switch($case){
            case "por_listado":
                $sql_criterio = " WHERE (distribucion.proyecto_id = $str_d) ORDER BY distribucion_id";
                break;
            case "por_listar":
                $tabla='public.proyecto';
                $campos = "proyecto.*,artista.nombre_artista,tipo_artista.nombre_tipo_artista,genero_musical.nombre_genero_musical";
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id ';
                $Union .= 'INNER JOIN public.genero_musical ON proyecto.genero_musical_id = genero_musical.genero_musical_id ';
                $sql_criterio = " WHERE (proyecto.estatus_proyecto_id = 6)";
                break;
            case "por_cambio":
                $campos = "*";
                $sql_criterio = " WHERE (proyecto_id = ".$str_d['proyecto_id'].")";
                $sql_criterio .= " AND (estatus_distribucion_id = ".$str_d['estatus_distribucion_id'].")";
                $sql_criterio .= " AND (estatus_distribucion_check = '".$str_d['estatus_distribucion_check']."')";
                break;
            case "por_tipo_proyecto":
                $tabla='public.proyecto';
                $campos = "*";
                $sql_criterio = " WHERE (proyecto.proyecto_id = $str_d)";
                break; 
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
        return $this->obj_consulta->ejecutar($sql_query,'consultaDistribucion','select');
    }//Fin consultaProduccionIndustrial
    
   
    function SeleccionarProyecto($proyecto_id){
        $result = $this->consultaDistribucion($proyecto_id,'por_listado','');
        if ($this->obj_consulta->rstNroFilas($result)) {
            $A = 0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                if ($data[$A]['estatus_distribucion_id'] == 1){
                    $registro['recibido'] = $data[$A]['estatus_distribucion_check'];
                    $registro['recibido_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_distribucion']);
                }
                if ($data[$A]['estatus_distribucion_id'] == 2){
                    $registro['estuchado'] = $data[$A]['estatus_distribucion_check'];
                    $registro['estuchado_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_distribucion']);
                } 
                if ($data[$A]['estatus_distribucion_id'] == 3){
                    $registro['distribuido'] = $data[$A]['estatus_distribucion_check'];
                    $registro['distribuido_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_distribucion']);
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
    
    function ingresaDistribucion($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("INSERT INTO public.distribucion (proyecto_id, estatus_distribucion_id, 
            estatus_distribucion_check)
            VALUES(%s, %s, '%s')",
            $str_d['proyecto_id'],
            1,
            $str_d['recibido']);
        $this->obj_consulta->ejecutar($sql_query,'ingresaDistribucion','insert');                    

        $sql_query = sprintf("INSERT INTO public.distribucion (proyecto_id, estatus_distribucion_id, 
            estatus_distribucion_check)
            VALUES(%s, %s, '%s')",
            $str_d['proyecto_id'],
            2,
            $str_d['estuchado']);
        $this->obj_consulta->ejecutar($sql_query,'ingresaDistribucion','insert');                    

        $sql_query = sprintf("INSERT INTO public.distribucion (proyecto_id, estatus_distribucion_id, 
            estatus_distribucion_check)
            VALUES(%s, %s, '%s')",
            $str_d['proyecto_id'],
            3,
            $str_d['distribuido']);
        $this->obj_consulta->ejecutar($sql_query,'ingresaDistribucion','insert');                    
            
        //actualiza el estatus proyecto
        if ($str_d['distribuido'] == 't'){
            $sql_query = sprintf("UPDATE public.proyecto SET estatus_proyecto_id = %s
                WHERE proyecto_id = %s",
                7, 
                $str_d['proyecto_id']);
            $this->obj_consulta->ejecutar($sql_query,'actualizaEstatusProyecto','update');
        }
        $retorno = array('mensaje'=>'La operación se efectuó exitosamente');
        return json_encode($retorno);
    }//Fin produccion_industrial
	
    function actualizaDistribucion($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        if ($this->cambioActualiza($str_d['proyecto_id'],1,$str_d['recibido'])){
            $sql_query = sprintf("UPDATE public.distribucion SET estatus_distribucion_check = '%s'
                WHERE proyecto_id = %s AND estatus_distribucion_id = 1",
                $str_d['recibido'],
                $str_d['proyecto_id']);
            $this->obj_consulta->ejecutar($sql_query,'actualizaDistribucion','insert');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],2,$str_d['estuchado'])){
            $sql_query = sprintf("UPDATE public.distribucion SET estatus_distribucion_check = '%s'
                WHERE proyecto_id = %s AND estatus_distribucion_id = 2",
                $str_d['estuchado'],
                $str_d['proyecto_id']);
            $this->obj_consulta->ejecutar($sql_query,'actualizaDistribucion','insert');        
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],3,$str_d['distribuido'])){
            $sql_query = sprintf("UPDATE public.distribucion SET estatus_distribucion_check = '%s'
                WHERE proyecto_id = %s AND estatus_distribucion_id = 3",
                $str_d['distribuido'],
                $str_d['proyecto_id']);
            $this->obj_consulta->ejecutar($sql_query,'actualizaDistribucion','insert');
            
            if ($str_d['distribuido'] == 't')
                $estatus_proyecto_id = 7;
            else
                $estatus_proyecto_id = 6;
            $sql_query = sprintf("UPDATE public.proyecto SET estatus_proyecto_id = %s
                WHERE proyecto_id = %s",
                $estatus_proyecto_id, 
                $str_d['proyecto_id']);
            $this->obj_consulta->ejecutar($sql_query,'actualizaEstatusProyecto','update');
        }
        $retorno = array('mensaje'=>'La operación se efectuó exitosamente');
        return json_encode($retorno);
       
    }//Fin actualizaDistribucion
    
    function cambioActualiza($proyecto_id,$estatus_distribucion_id,$estatus_distribucion_check){
        $str_d['proyecto_id'] = $proyecto_id;
        $str_d['estatus_distribucion_id'] = $estatus_distribucion_id;
        $str_d['estatus_distribucion_check'] = $estatus_distribucion_check;
        $result = $this->consultaDistribucion($str_d,'por_cambio','');
        if ($this->obj_consulta->rstNroFilas($result))
            return false;
        else
            return true;
    }
    
    function listarGrilla($proyecto_id){
        $result = $this->consultaDistribucion('','por_listar','');
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