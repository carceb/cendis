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
echo $obj_proyecto->$_POST['metodo']($_POST['parametros']); //se ejecuta el m��todo
class clsproyecto {
//=========================================================================================================================
//Nombre             : Clase cls_diseno
//Elaborado por  : Carlos Ceballos
//Fecha                  : 22/11/2011
//Description    : Registrar estatus en las fases del proceso de dise��o.
//Modificaci��n   :
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
    function consultaDiseno($str_d='', $case=''){
        $tabla='public.diseno';
        $campos = "*";
        $Union = '';
        switch($case){
            case "por_listado":
                $sql_criterio = " WHERE (diseno.proyecto_id = $str_d) ORDER BY diseno_id";
                break;
            case "por_listar":
                $tabla='public.proyecto';
                $campos = "proyecto.*,artista.nombre_artista,tipo_artista.nombre_tipo_artista,genero_musical.nombre_genero_musical";
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id ';
                $Union .= 'INNER JOIN public.genero_musical ON proyecto.genero_musical_id = genero_musical.genero_musical_id ';
                $sql_criterio = " WHERE (proyecto.estatus_proyecto_id = 4)";
                break;
            case "por_cambio":
                $campos = "*";
                $sql_criterio = " WHERE (proyecto_id = ".$str_d['proyecto_id'].")";
                $sql_criterio .= " AND (estatus_diseno_id = ".$str_d['estatus_diseno_id'].")";
                $sql_criterio .= " AND (estatus_diseno_check = '".$str_d['estatus_diseno_check']."')";
                break;
            case "por_audio":
                $tabla='public.audio';
                $campos = "*";
                $sql_criterio = " WHERE (proyecto_id = ".$str_d['proyecto_id'].")";
                if ($str_d['tipo_proyecto_id'] == '1')
                    $sql_criterio .= " AND (estatus_audio_id = 3)";
                else
                    $sql_criterio .= " AND (estatus_audio_id = 7)";
                $sql_criterio .= " AND (estatus_audio_check = 't')";
                break;
            case "por_tipo_proyecto":
                $tabla='public.proyecto';
                $campos = "*";
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id ';
                $sql_criterio = " WHERE (proyecto.proyecto_id = $str_d)";
                break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";//echo $sql_query;
        return $this->obj_consulta->ejecutar($sql_query,'consultaDiseno','select');
    }//Fin consultaDiseno
    
   
    function SeleccionarProyecto($proyecto_id){
        $result = $this->consultaDiseno($proyecto_id,'por_listado','');
        if ($this->obj_consulta->rstNroFilas($result)) {
            $A = 0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                if ($data[$A]['estatus_diseno_id'] == 1){
                    $registro['recibido'] = $data[$A]['estatus_diseno_check'];
                    $registro['recibido_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_diseno']);
                }
                if ($data[$A]['estatus_diseno_id'] == 2){
                    $registro['en_proceso'] = $data[$A]['estatus_diseno_check'];
                    $registro['en_proceso_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_diseno']);
                }
                if ($data[$A]['estatus_diseno_id'] == 3){
                    $registro['diseno_aprobado'] = $data[$A]['estatus_diseno_check'];
                    $registro['diseno_aprobado_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_diseno']);
                }
                if ($data[$A]['estatus_diseno_id'] == 4){
                    $registro['en_fotolito'] = $data[$A]['estatus_diseno_check'];
                    $registro['en_fotolito_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_diseno']);
                } 
                if ($data[$A]['estatus_diseno_id'] == 5){
                    $registro['enviado_imprenta'] = $data[$A]['estatus_diseno_check'];
                    $registro['enviado_imprenta_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_estatus_diseno']);
                } 
                $A++;
            }
            $retorno = $registro;
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = false;
        }
        return json_encode($retorno);
    }//Fin SeleccionarProyecto.
    
    function listarGrilla($proyecto_id){
        $result = $this->consultaDiseno('','por_listar','');
        if ($this->obj_consulta->rstNroFilas($result)){
            $i = 1;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
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
    
    function ingresaDiseno($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("INSERT INTO public.diseno (proyecto_id, estatus_diseno_id, 
            estatus_diseno_check)
            VALUES(%s, %s, '%s')",
            $str_d['proyecto_id'],
            1,
            $str_d['recibido']);
        $this->obj_consulta->ejecutar($sql_query,'ingresaDiseno','insert');                    

        $sql_query = sprintf("INSERT INTO public.diseno (proyecto_id, estatus_diseno_id, 
            estatus_diseno_check)
            VALUES(%s, %s, '%s')",
            $str_d['proyecto_id'],
            2, 
            $str_d['en_proceso']);        
        $this->obj_consulta->ejecutar($sql_query,'ingresaDiseno','insert');

        $sql_query = sprintf("INSERT INTO public.diseno (proyecto_id, estatus_diseno_id, 
            estatus_diseno_check)
            VALUES(%s, %s, '%s')",
            $str_d['proyecto_id'],
            3, 
            $str_d['diseno_aprobado']);        
        $this->obj_consulta->ejecutar($sql_query,'ingresaDiseno','insert');

        $sql_query = sprintf("INSERT INTO public.diseno (proyecto_id, estatus_diseno_id, 
            estatus_diseno_check)
            VALUES(%s, %s, '%s')",
            $str_d['proyecto_id'],
            4, 
            $str_d['en_fotolito']);        
        $this->obj_consulta->ejecutar($sql_query,'ingresaDiseno','insert');        
        
        $sql_query = sprintf("INSERT INTO public.diseno (proyecto_id, estatus_diseno_id, 
            estatus_diseno_check)
            VALUES(%s, %s, '%s')",
            $str_d['proyecto_id'],
            5, 
            $str_d['enviado_imprenta']);        
        $this->obj_consulta->ejecutar($sql_query,'ingresaDiseno','insert');                 
        
        if ($str_d['enviado_imprenta'] == 't'){
            $result = $this->consultaDiseno($str_d,'por_audio','');
            if ($this->obj_consulta->rstNroFilas($result)) {
                $sql_query = sprintf("UPDATE public.proyecto SET estatus_proyecto_id = %s
                        WHERE proyecto_id = %s",
                        5, 
                        $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'actualizaEstatusProyecto','update');
            }
            $this->obj_consulta->free_rst($result);
        }
        $retorno = array('mensaje'=>'La operación se efectuó exitosamente');
        return json_encode($retorno);
    }//Fin ingresaDiseno
        
    function actualizaDiseno($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        if ($this->cambioActualiza($str_d['proyecto_id'],1,$str_d['recibido'])){
            $sql_query = sprintf("UPDATE public.diseno SET estatus_diseno_check = '%s', fecha_sistema_estatus_diseno = '%s'
                WHERE proyecto_id = %s AND estatus_diseno_id = 1",
                $str_d['recibido'],
                $str_d['fecha_sistema_estatus_diseno'],
                $str_d['proyecto_id']);
            $this->obj_consulta->ejecutar($sql_query,'actualizaDiseno','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],2,$str_d['en_proceso'])){
            $sql_query = sprintf("UPDATE public.diseno SET estatus_diseno_check = '%s', fecha_sistema_estatus_diseno = '%s'
                WHERE proyecto_id = %s AND estatus_diseno_id = 2",
                $str_d['en_proceso'],
                $str_d['fecha_sistema_estatus_diseno'],
                $str_d['proyecto_id']);
            $this->obj_consulta->ejecutar($sql_query,'actualizaDiseno','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],3,$str_d['diseno_aprobado'])){
            $sql_query = sprintf("UPDATE public.diseno SET estatus_diseno_check = '%s', fecha_sistema_estatus_diseno = '%s'
                WHERE proyecto_id = %s AND estatus_diseno_id = 3",
                $str_d['diseno_aprobado'],
                $str_d['fecha_sistema_estatus_diseno'],
                $str_d['proyecto_id']); 
            $this->obj_consulta->ejecutar($sql_query,'actualizaDiseno','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],4,$str_d['en_fotolito'])){
            $sql_query = sprintf("UPDATE public.diseno SET estatus_diseno_check = '%s', fecha_sistema_estatus_diseno = '%s'
                WHERE proyecto_id = %s AND estatus_diseno_id = 4",
                $str_d['en_fotolito'],
                $str_d['fecha_sistema_estatus_diseno'],
                $str_d['proyecto_id']); 
            $this->obj_consulta->ejecutar($sql_query,'actualizaDiseno','update');        
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],5,$str_d['enviado_imprenta'])){
            $sql_query = sprintf("UPDATE public.diseno SET estatus_diseno_check = '%s', fecha_sistema_estatus_diseno = '%s'
                WHERE proyecto_id = %s AND estatus_diseno_id = 5",
                $str_d['enviado_imprenta'],
                $str_d['fecha_sistema_estatus_diseno'],
                $str_d['proyecto_id']);
            $this->obj_consulta->ejecutar($sql_query,'actualizaDiseno','update');

            if ($str_d['enviado_imprenta'] == 't'){
                $result = $this->consultaDiseno($str_d,'por_audio','');
                if ($this->obj_consulta->rstNroFilas($result)) {
                    $sql_query = sprintf("UPDATE public.proyecto SET estatus_proyecto_id = %s
                        WHERE proyecto_id = %s",
                        5, 
                        $str_d['proyecto_id']);
                    $this->obj_consulta->ejecutar($sql_query,'actualizaEstatusProyecto','update');
                    $this->obj_consulta->free_rst($result);
                }
            }else{
                $result = $this->consultaDiseno($str_d['proyecto_id'],'por_tipo_proyecto','');
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
        }
        $retorno = array('mensaje'=>'La operación se efectuó exitosamente');
        return json_encode($retorno);
    }//Fin actualizaDiseno   
        
    function cambioActualiza($proyecto_id,$estatus_diseno_id,$estatus_diseno_check){
        $str_d['proyecto_id'] = $proyecto_id;
        $str_d['estatus_diseno_id'] = $estatus_diseno_id;
        $str_d['estatus_diseno_check'] = $estatus_diseno_check;
        $result = $this->consultaDiseno($str_d,'por_cambio','');
        if ($this->obj_consulta->rstNroFilas($result))
            return false;
        else
            return true;
    }

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>