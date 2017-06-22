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
$obj_audio = new clsaudio; //Se instancia la clase
echo $obj_audio->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clsaudio {
//=========================================================================================================================
//Nombre	     : Clase cls_diseno
//Elaborado por  : Carlos Ceballos
//Fecha			 : 22/11/2011
//Description	 : Registrar estatus en las fases del proceso de diseño.
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
    function consultaAudio($str_d='', $case=''){
        $tabla='public.audio';
	$campos = "*";
        $Union = '';
        switch($case){
            case "por_listado":
                $sql_criterio = " WHERE (audio.proyecto_id = $str_d) ORDER BY audio_id";
                break;
            case "por_listar":
                $tabla='public.proyecto';
                $campos = "proyecto.*,artista.nombre_artista,tipo_artista.nombre_tipo_artista,genero_musical.nombre_genero_musical";
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id ';
                $Union .= 'INNER JOIN public.genero_musical ON proyecto.genero_musical_id = genero_musical.genero_musical_id ';
                $sql_criterio = " WHERE (proyecto.estatus_proyecto_id = 4)";
                break;
            case "por_tipo_proyecto":
                $tabla='public.proyecto';
                $campos = "*";
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id ';
                $sql_criterio = " WHERE (proyecto.proyecto_id = $str_d)";
                break;
	    case "por_cambio":
                $tabla='public.audio';
                $campos = "*";
                $sql_criterio = " WHERE (proyecto_id = ".$str_d['proyecto_id'].")";
                $sql_criterio .= " AND (estatus_audio_id = ".$str_d['estatus_audio_id'].")";
                $sql_criterio .= " AND (estatus_audio_check = '".$str_d['estatus_audio_check']."')";
                break;
            case "por_diseno":
                $tabla='public.diseno';
                $campos = "*";
                $sql_criterio = " WHERE (proyecto_id = $str_d)";
                $sql_criterio .= " AND (estatus_diseno_id = 5)";
                $sql_criterio .= " AND (estatus_diseno_check = 't')";
                //$sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
                break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";//echo $sql_query;
        return $this->obj_consulta->ejecutar($sql_query,'consultaDiseno','select');
    }//Fin consultaDiseno
    
    function SeleccionarProyecto($proyecto_id){
        $result = $this->consultaAudio($proyecto_id,'por_listado','');
        if ($this->obj_consulta->rstNroFilas($result)) {
            $A = 0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                if ($data[$A]['estatus_audio_id'] == 1){
                    $registro['revision_tecnica_replicacion'] = $data[$A]['estatus_audio_check'];
                    $registro['revision_tecnica_replicacion_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_audio']);
                }
                    
                if ($data[$A]['estatus_audio_id'] == 2){
                    $registro['ddp_replicacion'] = $data[$A]['estatus_audio_check'];
                    $registro['ddp_replicacion_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_audio']);
                }
                    
                if ($data[$A]['estatus_audio_id'] == 3){
                    $registro['envio_fabrica_replicacion'] = $data[$A]['estatus_audio_check'];
                    $registro['envio_fabrica_replicacion_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_audio']);
                }
                    
                if ($data[$A]['estatus_audio_id'] == 4){
                    $registro['reunion_produccion_grabacion'] = $data[$A]['estatus_audio_check'];
                    $registro['reunion_produccion_grabacion_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_audio']);
                }
                    
                if ($data[$A]['estatus_audio_id'] == 5){
                    $registro['grabacion_grabacion'] = $data[$A]['estatus_audio_check'];
                    $registro['grabacion_grabacion_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_audio']);
                }
                    
                if ($data[$A]['estatus_audio_id'] == 6){
                    $registro['post_produccion_grabacion'] = $data[$A]['estatus_audio_check'];
                    $registro['post_produccion_grabacion_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_audio']);
                }
                    
                if ($data[$A]['estatus_audio_id'] == 7){
                    $registro['envio_fabrica_grabacion'] = $data[$A]['estatus_audio_check'];
                    $registro['envio_fabrica_grabacion_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_audio']);
                }
                    
                $A++;//número de array siguiente.
            }
            $retorno = $registro;
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = false;
        }
        return json_encode($retorno);
    }//Fin SeleccionarProyecto.
    
    function listarGrilla($proyecto_id){
        $result = $this->consultaAudio('','por_listar','');
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
    
    function TipoProyecto($proyecto_id){
        $result = $this->consultaAudio($proyecto_id,'por_tipo_proyecto','');
        if ($this->obj_consulta->rstNroFilas($result)) {
            extract($this->obj_consulta->rstRegistros($result));
            $retorno = $tipo_proyecto_id;
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = false;
        }
        return json_encode($retorno);
    }//Fin cargaGrilla.
    
    function ingresaAudio($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        //echo var_dump($str_d);
        if ($str_d['tipo_proyecto_id'] == 1){
            $sql_query = sprintf("INSERT INTO public.audio (proyecto_id, estatus_audio_id, 
                estatus_audio_check)
                VALUES(%s, %s, '%s')",
                $str_d['proyecto_id'],
                1, 
                $str_d['revision_tecnica_replicacion']);
            $this->obj_consulta->ejecutar($sql_query,'ingresaAudio','insert');   
			$sql_query = sprintf("INSERT INTO public.audio (proyecto_id, estatus_audio_id, 
                estatus_audio_check)
                VALUES(%s, %s, '%s')",
                $str_d['proyecto_id'],
                2, 
                $str_d['ddp_replicacion']);        
            $this->obj_consulta->ejecutar($sql_query,'ingresaAudio','insert');   
			$sql_query = sprintf("INSERT INTO public.audio (proyecto_id, estatus_audio_id, 
                estatus_audio_check)
                VALUES(%s, %s, '%s')",
                $str_d['proyecto_id'],
                3, 
                $str_d['envio_fabrica_replicacion']);        
            $this->obj_consulta->ejecutar($sql_query,'ingresaAudio','insert');   //actualiza el estatus proyecto
            if ($str_d['envio_fabrica_replicacion'] == 't'){
                $result = $this->consultaAudio($str_d['proyecto_id'],'por_diseno','');
                if ($this->obj_consulta->rstNroFilas($result)) {
                    $sql_query = sprintf("UPDATE public.proyecto SET estatus_proyecto_id = %s
                            WHERE proyecto_id = %s",
                            5, 
                            $str_d['proyecto_id']);
                    $this->obj_consulta->ejecutar($sql_query,'actualizaEstatusProyecto','update');
                    $this->obj_consulta->free_rst($result);
                }	
            }				
        }else{
            $sql_query = sprintf("INSERT INTO public.audio (proyecto_id, estatus_audio_id, 
                estatus_audio_check)
                VALUES(%s, %s, '%s')",
                $str_d['proyecto_id'],
                4, 
                $str_d['reunion_produccion_grabacion']);        
            $this->obj_consulta->ejecutar($sql_query,'ingresaAudio','insert');   
			$sql_query = sprintf("INSERT INTO public.audio (proyecto_id, estatus_audio_id, 
                estatus_audio_check)
                VALUES(%s, %s, '%s')",
                $str_d['proyecto_id'],
                5, 
                $str_d['grabacion_grabacion']);        
            $this->obj_consulta->ejecutar($sql_query,'ingresaAudio','insert');   
			$sql_query = sprintf("INSERT INTO public.audio (proyecto_id, estatus_audio_id, 
                estatus_audio_check)
                VALUES(%s, %s, '%s')",
                $str_d['proyecto_id'],
                6, 
                $str_d['post_produccion_grabacion']);        
            $this->obj_consulta->ejecutar($sql_query,'ingresaAudio','insert');   
			$sql_query = sprintf("INSERT INTO public.audio (proyecto_id, estatus_audio_id, 
                estatus_audio_check)
                VALUES(%s, %s, '%s')",
                $str_d['proyecto_id'],
                7, 
                $str_d['envio_fabrica_grabacion']);        
            $this->obj_consulta->ejecutar($sql_query,'ingresaAudio','insert');   //actualiza el estatus proyecto
            if ($str_d['envio_fabrica_grabacion'] == 't'){
                $result = $this->consultaAudio($str_d['proyecto_id'],'por_diseno','');
                if ($this->obj_consulta->rstNroFilas($result)) {
                    $sql_query = sprintf("UPDATE public.proyecto SET estatus_proyecto_id = %s
                            WHERE proyecto_id = %s",
                            5, 
                            $str_d['proyecto_id']);
                    $this->obj_consulta->ejecutar($sql_query,'actualizaEstatusProyecto','update');
                    $this->obj_consulta->free_rst($result);
                }
            }			
        }
        $retorno = array('mensaje'=>'La operación se efectuó exitosamente');
        return json_encode($retorno);
    }//Fin ingresaDiseno
	
    function actualizaAudio($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        if ($str_d['tipo_proyecto_id'] == 1){
            if ($this->cambioActualiza($str_d['proyecto_id'],1,$str_d['revision_tecnica_replicacion'])){
                $sql_query = sprintf("UPDATE public.audio SET estatus_audio_check = '%s',fecha_sistema_estatus_audio = '%s'
                        WHERE proyecto_id = %s AND estatus_audio_id = 1",
                        $str_d['revision_tecnica_replicacion'],
                        $str_d['fecha_sistema_estatus_audio'],
                        $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'actualizaAudio','update');  }

            if ($this->cambioActualiza($str_d['proyecto_id'],2,$str_d['ddp_replicacion'])){
                $sql_query = sprintf("UPDATE public.audio SET estatus_audio_check = '%s',fecha_sistema_estatus_audio = '%s'
                        WHERE proyecto_id = %s AND estatus_audio_id = 2",
                        $str_d['ddp_replicacion'],
                        $str_d['fecha_sistema_estatus_audio'],
                        $str_d['proyecto_id']);      
                $this->obj_consulta->ejecutar($sql_query,'actualizaAudio','update');  }

            if ($this->cambioActualiza($str_d['proyecto_id'],3,$str_d['envio_fabrica_replicacion'])){
                $sql_query = sprintf("UPDATE public.audio SET estatus_audio_check = '%s',fecha_sistema_estatus_audio = '%s'
                        WHERE proyecto_id = %s AND estatus_audio_id = 3",
                        $str_d['envio_fabrica_replicacion'],
                        $str_d['fecha_sistema_estatus_audio'],
                        $str_d['proyecto_id']);      
                $this->obj_consulta->ejecutar($sql_query,'actualizaAudio','update');
            }
        }else{
            if ($this->cambioActualiza($str_d['proyecto_id'],4,$str_d['reunion_produccion_grabacion'])){
                $sql_query = sprintf("UPDATE public.audio SET estatus_audio_check = '%s',fecha_sistema_estatus_audio = '%s'
                        WHERE proyecto_id = %s AND estatus_audio_id = 4",
                        $str_d['reunion_produccion_grabacion'],
                        $str_d['fecha_sistema_estatus_audio'],
                        $str_d['proyecto_id']);       
                $this->obj_consulta->ejecutar($sql_query,'actualizaAudio','update');  }

            if ($this->cambioActualiza($str_d['proyecto_id'],5,$str_d['grabacion_grabacion'])){
                $sql_query = sprintf("UPDATE public.audio SET estatus_audio_check = '%s',fecha_sistema_estatus_audio = '%s'
                        WHERE proyecto_id = %s AND estatus_audio_id = 5",
                        $str_d['grabacion_grabacion'],
                        $str_d['fecha_sistema_estatus_audio'],
                        $str_d['proyecto_id']);      
                $this->obj_consulta->ejecutar($sql_query,'actualizaAudio','update');  }

            if ($this->cambioActualiza($str_d['proyecto_id'],6,$str_d['post_produccion_grabacion'])){
                $sql_query = sprintf("UPDATE public.audio SET estatus_audio_check = '%s',fecha_sistema_estatus_audio = '%s'
                        WHERE proyecto_id = %s AND estatus_audio_id = 6",
                        $str_d['post_produccion_grabacion'],
                        $str_d['fecha_sistema_estatus_audio'],
                        $str_d['proyecto_id']);      
                $this->obj_consulta->ejecutar($sql_query,'actualizaAudio','update');  }

            if ($this->cambioActualiza($str_d['proyecto_id'],7,$str_d['envio_fabrica_grabacion'])){
                $sql_query = sprintf("UPDATE public.audio SET estatus_audio_check = '%s',fecha_sistema_estatus_audio = '%s'
                        WHERE proyecto_id = %s AND estatus_audio_id = 7",
                        $str_d['envio_fabrica_grabacion'],
                        $str_d['fecha_sistema_estatus_audio'],
                        $str_d['proyecto_id']);     
                $this->obj_consulta->ejecutar($sql_query,'actualizaAudio','update');  }
        }
        if ($str_d['envio_fabrica_replicacion'] == 't' || $str_d['envio_fabrica_grabacion'] == 't'){
            $result = $this->consultaAudio($str_d['proyecto_id'],'por_diseno','');
            if ($this->obj_consulta->rstNroFilas($result)) {
                $sql_query = sprintf("UPDATE public.proyecto SET estatus_proyecto_id = %s
                    WHERE proyecto_id = %s",
                    5, 
                    $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'actualizaEstatusProyecto','update');
            }
            $this->obj_consulta->free_rst($result);
        }else{
            $result = $this->consultaAudio($str_d['proyecto_id'],'por_tipo_proyecto','');
            extract($this->obj_consulta->rstRegistros($result));
            if ($estatus_proyecto_id == 5){
                $sql_query = sprintf("UPDATE public.proyecto SET estatus_proyecto_id = %s
                    WHERE proyecto_id = %s",
                    4, 
                    $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'actualizaEstatusProyecto','update');
            }
            $this->obj_consulta->free_rst($result);
        }
        $retorno = array('mensaje'=>'La operación se efectuó exitosamente');
        return json_encode($retorno);
       
    }//Fin actualizaDiseno
	
    function cambioActualiza($proyecto_id,$estatus_audio_id,$estatus_audio_check){
        $str_d['proyecto_id'] = $proyecto_id;
        $str_d['estatus_audio_id'] = $estatus_audio_id;
        $str_d['estatus_audio_check'] = $estatus_audio_check;
        $result = $this->consultaAudio($str_d,'por_cambio','');
        if ($this->obj_consulta->rstNroFilas($result)){
            return false;
        }else{
            return true;
        }
    }

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>