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
$obj_catalogo = new clscatalogo; //Se instancia la clase
echo $obj_catalogo->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clscatalogo {
//=========================================================================================================================
//Nombre	     : Clase clscatalogo
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
    function consultaCatalogo($str_d='', $case=''){
        $tabla='public.proyecto_requisito';
		$campos = "proyecto_requisito.*,proyecto.artista_id,proyecto.nombre_proyecto,proyecto.numero_deposito_legal,proyecto.numero_produccion,proyecto.tipo_estuche_id, artista.*";
        $Union = '';
        switch($case){
            case "por_listado":
                $Union = 'INNER JOIN public.proyecto ON proyecto_requisito.proyecto_id = proyecto.proyecto_id ';
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $sql_criterio = " WHERE (proyecto_requisito.proyecto_id = $str_d)";
                break;
            case "por_listar":
                $tabla='public.proyecto';
                $campos = "proyecto.*,artista.nombre_artista,tipo_artista.nombre_tipo_artista,genero_musical.nombre_genero_musical";
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id ';
                $Union .= 'INNER JOIN public.genero_musical ON proyecto.genero_musical_id = genero_musical.genero_musical_id ';
                $sql_criterio = " WHERE (proyecto.estatus_proyecto_id = 3)";
                break;
            case "por_cambio":
                $campos = "*";
                $sql_criterio = " WHERE (proyecto_id = ".$str_d['proyecto_id'].")";
                $sql_criterio .= " AND (requisito_id = ".$str_d['requisito_id'].")";
                $sql_criterio .= " AND (proyecto_requisito_check = '".$str_d['proyecto_requisito_check']."')";
                break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
        return $this->obj_consulta->ejecutar($sql_query,'consultaCatalogo','select');
    }//Fin consultaCatalogo.
    
    function cargaGrilla($proyecto_id){
        $result = $this->consultaCatalogo($proyecto_id,'por_listado','');
        if ($this->obj_consulta->rstNroFilas($result)){
            $A = 0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                if ($A == 0){
                    $registro['proyecto_id'] = $proyecto_id;
                    $registro['artista_id'] = $data[$A]['artista_id'];
                    $registro['tipo_artista_id'] = $data[$A]['tipo_artista_id'];
                    $registro['nombre_artista'] = $data[$A]['nombre_artista'];
                    $registro['nombre_proyecto'] = htmlspecialchars_decode($data[$A]['nombre_proyecto'],3);
		    $registro['numero_deposito_legal'] = htmlspecialchars_decode($data[$A]['numero_deposito_legal'],3);
                    $registro['numero_produccion'] = htmlspecialchars_decode($data[$A]['numero_produccion'],3);
                    $registro['tipo_estuche_id'] = $data[$A]['tipo_estuche_id'];
                }
                if ($data[$A]['requisito_id'] == 2){
                    $registro['direccion'] = $data[$A]['proyecto_requisito_check'];
                    $registro['direccion_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                }
                if ($data[$A]['requisito_id'] == 3){
                    $registro['carta_compromiso_autoria'] = $data[$A]['proyecto_requisito_check'];
                    $registro['carta_compromiso_autoria_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                }
                if ($data[$A]['requisito_id'] == 4){
                    $registro['carta_buena_fe'] = $data[$A]['proyecto_requisito_check'];
                    $registro['carta_buena_fe_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                }
                if ($data[$A]['requisito_id'] == 5){
                    $registro['deposito_legal'] = $data[$A]['proyecto_requisito_check'];
                    $registro['deposito_legal_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                }
                if ($data[$A]['requisito_id'] == 6){
                    $registro['representante_legal'] = $data[$A]['proyecto_requisito_check'];
                    $registro['representante_legal_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                }
                if ($data[$A]['requisito_id'] == 7){
                    $registro['acta_constitutiva'] = $data[$A]['proyecto_requisito_check'];
                    $registro['acta_constitutiva_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                }
                if ($data[$A]['requisito_id'] == 8){
                    $registro['copia_rif'] = $data[$A]['proyecto_requisito_check'];
                    $registro['copia_rif_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                }
                if ($data[$A]['requisito_id'] == 9){
                    $registro['copia_cedula'] = $data[$A]['proyecto_requisito_check'];
                    $registro['copia_cedula_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                }
                if ($data[$A]['requisito_id'] == 10){
                    $registro['letras'] = $data[$A]['proyecto_requisito_check'];
                    $registro['letras_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                }
                if ($data[$A]['requisito_id'] == 12){
                    $registro['listado_interprete'] = $data[$A]['proyecto_requisito_check'];
                    $registro['listado_interprete_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                }
                if ($data[$A]['requisito_id'] == 13){
                    $registro['autorizacion_replica'] = $data[$A]['proyecto_requisito_check'];
                    $registro['autorizacion_replica_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                } 
                if ($data[$A]['requisito_id'] == 14){
                    $registro['exoneracion_derecho'] = $data[$A]['proyecto_requisito_check'];
                    $registro['exoneracion_derecho_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                }
                if ($data[$A]['requisito_id'] == 15){
                    $registro['nombre_definitivo'] = $data[$A]['proyecto_requisito_check'];
                    $registro['nombre_definitivo_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                }
                if ($data[$A]['requisito_id'] == 16){
                    $registro['master_produccion'] = $data[$A]['proyecto_requisito_check'];
                    $registro['master_produccion_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
                }
                if ($data[$A]['requisito_id'] == 17){
                    $registro['fotografias'] = $data[$A]['proyecto_requisito_check'];
                    $registro['fotografias_fecha'] = $this->obj_general->formatea_fecha_normal($data[$A]['fecha_sistema_requisito_proyecto']);
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
    
    function listarGrilla($proyecto_id){
        $result = $this->consultaCatalogo('','por_listar','');
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
	
    function actualizaCatalogo($parametros){
        $str_d = json_decode($parametros,true);
        $sql_query = sprintf("UPDATE public.proyecto SET numero_deposito_legal = '%s'
                        WHERE proyecto_id = %s",
                        htmlspecialchars($str_d['numero_deposito_legal'],3),
                        $str_d['proyecto_id']);
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaCatalogo','update');
        
        $sql_query = sprintf("UPDATE public.proyecto SET numero_produccion = '%s'
                        WHERE proyecto_id = %s",
                        htmlspecialchars($str_d['numero_produccion'],3),
                        $str_d['proyecto_id']);
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaCatalogo','update');
        
        $sql_query = sprintf("UPDATE public.proyecto SET tipo_estuche_id = %s
                        WHERE proyecto_id = %s",
                        $str_d['tipo_estuche_id'],
                        $str_d['proyecto_id']);
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaCatalogo','update');       
        
        //ACTUALIZAR LA TABLA DE REQUISITOS
        if ($this->cambioActualiza($str_d['proyecto_id'],2,$str_d['direccion'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 2",
                                $str_d['direccion'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],3,$str_d['carta_compromiso_autoria'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 3",
                                $str_d['carta_compromiso_autoria'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
        $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],4,$str_d['carta_buena_fe'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 4",
                                $str_d['carta_buena_fe'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }        
        if ($this->cambioActualiza($str_d['proyecto_id'],5,$str_d['deposito_legal'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 5",
                                $str_d['deposito_legal'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],6,$str_d['representante_legal'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 6",
                                $str_d['representante_legal'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],7,$str_d['acta_constitutiva'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 7",
                                $str_d['acta_constitutiva'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],8,$str_d['copia_rif'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 8",
                                $str_d['copia_rif'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],9,$str_d['copia_cedula'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 9",
                                $str_d['copia_cedula'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],10,$str_d['letras'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 10",
                                $str_d['letras'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],12,$str_d['listado_interprete'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 12",
                                $str_d['listado_interprete'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],13,$str_d['autorizacion_replica'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 13",
                                $str_d['autorizacion_replica'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],14,$str_d['exoneracion_derecho'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 14",
                                $str_d['exoneracion_derecho'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }		
        if ($this->cambioActualiza($str_d['proyecto_id'],15,$str_d['nombre_definitivo'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 15",
                                $str_d['nombre_definitivo'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],16,$str_d['master_produccion'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 16",
                                $str_d['master_produccion'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }
        if ($this->cambioActualiza($str_d['proyecto_id'],17,$str_d['fotografias'])){
                $sql_query = sprintf("UPDATE public.proyecto_requisito SET proyecto_requisito_check = '%s', fecha_sistema_requisito_proyecto = '%s'
                                WHERE proyecto_id = %s AND requisito_id = 17",
                                $str_d['fotografias'],
                                $str_d['fecha_sistema_requisito_proyecto'],
                                $str_d['proyecto_id']);
                $this->obj_consulta->ejecutar($sql_query,'ingresaProyectoRequisito','update');
        }
        $mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        return json_encode($retorno);
    }//Fin actualizaCatalogo.   
	
	function cambioActualiza($proyecto_id,$requisito_id,$proyecto_requisito_check){
            $str_d['proyecto_id'] = $proyecto_id;
            $str_d['requisito_id'] = $requisito_id;
            $str_d['proyecto_requisito_check'] = $proyecto_requisito_check;
            $result = $this->consultaCatalogo($str_d,'por_cambio','');
            if ($this->obj_consulta->rstNroFilas($result)){
                return false;
            }else{
                return true;
            }
	}
        
       function depositoLegalValido($parametros){
            $retorno = true;
            $str_d = json_decode($parametros,true);
            $sql_query = sprintf("SELECT proyecto_id , nombre_proyecto, numero_deposito_legal FROM public.proyecto WHERE numero_deposito_legal = '%s'",
                         htmlspecialchars($str_d['numero_deposito_legal'],3));
            $result = $this->obj_consulta->ejecutar($sql_query,'depositoLegalValido','select');
            
            if ($this->obj_consulta->rstNroFilas($result)){
                $A = 0;
                while ($filas = $this->obj_consulta->rstRegistros($result)) {
                    $data[] = $filas;
                    if ($data[$A]['proyecto_id'] != $str_d['proyecto_id']){
                        $retorno = array('resultado'=>false,'proyecto'=>$data[$A]['nombre_proyecto']);
                    }
                    $A++;
                }
                $this->obj_consulta->free_rst($result);
            }
            return json_encode($retorno);
       } 
}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>