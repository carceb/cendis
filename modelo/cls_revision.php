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
$obj_revision = new clsrevision; //Se instancia la clase
echo $obj_revision->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class clsrevision {
//=========================================================================================================================
//Nombre	 : Clase clsrevision
//Elaborado por  : Juan Carlos Díaz
//Fecha          : 22/10/2011
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
    function consultaComision($str_d='', $case='')    {
        $tabla='public.proyecto';
	$campos = "*";
        $Union = '';
        switch($case){
            case "listar_proyectos":
                $Union = 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id ';
                $Union .= 'INNER JOIN public.genero_musical ON proyecto.genero_musical_id = genero_musical.genero_musical_id ';
                $sql_criterio = " WHERE (estatus_proyecto_id = 1) ORDER BY fecha_proyecto ASC, nombre_proyecto";
                break;
            case "listar_proyectos_fecha":
                $Union = 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id ';
                $Union .= 'INNER JOIN public.genero_musical ON proyecto.genero_musical_id = genero_musical.genero_musical_id ';
                $sql_criterio = " WHERE (estatus_proyecto_id = 1)";
                $sql_criterio .= " AND proyecto.fecha_proyecto BETWEEN '".$str_d['txt_fecha_desdeVM'];
                $sql_criterio .= "' AND '".$str_d['txt_fecha_hastaVM']."'";
                echo $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
                break;
            case "por_listado":
                $Union = 'INNER JOIN public.comision_artistica ON proyecto.comision_artistica_id = comision_artistica.comision_artistica_id ';
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id ';
                $Union .= 'INNER JOIN public.genero_musical ON proyecto.genero_musical_id = genero_musical.genero_musical_id ';
                $sql_criterio = "WHERE proyecto.comision_artistica_id != 0";
                if ($str_d['txt_fecha_desdeVM'] != '' AND $str_d['txt_fecha_hastaVM'] != ''){
                     $sql_criterio .= " AND comision_artistica.fecha_comision_artistica BETWEEN '".$str_d['txt_fecha_desdeVM'];
                     $sql_criterio .= "' AND '".$str_d['txt_fecha_hastaVM']."'";
                }
                break;
            case "por_listado_old":
                $Union = 'INNER JOIN public.comision_artistica ON proyecto.comision_artistica_id = comision_artistica.comision_artistica_id ';
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id ';
                $Union .= 'INNER JOIN public.genero_musical ON proyecto.genero_musical_id = genero_musical.genero_musical_id ';
                $sql_criterio = "WHERE proyecto.comision_artistica_id != 0";
                if ($str_d['chk_por_fechaVM'] == 't'){
                    if ($str_d['txt_fecha_desdeVM'] != '' AND $str_d['txt_fecha_hastaVM'] != ''){
                         $sql_criterio .= " AND comision_artistica.fecha_comision_artistica BETWEEN '".$str_d['txt_fecha_desdeVM'];
                         $sql_criterio .= "' AND '".$str_d['txt_fecha_hastaVM']."'";
                    }
                }
                if ($str_d['chk_por_decisionVM'] == 't'){
                    if ($str_d['sel_decisionVM'] == 0){
                         $sql_criterio .= " AND  proyecto.estatus_proyecto_id = 0";
                    }else if($str_d['sel_decisionVM'] == 2){
                         $sql_criterio .= " AND  proyecto.estatus_proyecto_id >= 2";
                    }
                }
                break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";
        return $this->obj_consulta->ejecutar($sql_query,'consultaFinalidad','select');
    }//Fin consultaArtista.

    function cargaGrilla($parametros){
       $str_d = json_decode(stripcslashes($parametros),true);
       $result = $this->consultaComision($str_d,'por_listado');
        if ($this->obj_consulta->rstNroFilas($result)) {
	    $A=0;
            while ($filas = $this->obj_consulta->rstRegistros($result)) {
                $data[] = $filas; //se va llenando la matriz.
                $data[$A]['fecha_comision_artistica']=$this->obj_general->formatea_fecha_normal($data[$A]['fecha_comision_artistica']);
                if ($data[$A]['estatus_proyecto_id'] == 0)
                    $decision = 'RECHAZADO';
                else
                    $decision = 'APROBADO';
                $data[$A]['decision'] = $decision;
                $A++;
            }
            $retorno = array('filas' => $data);
            $this->obj_consulta->free_rst($result);
        } else {
            $retorno = array('filas' => false);
        }
        return json_encode($retorno);
    }//Fin cargaGrilla.
	
    function ingresaComision(){
        $sql_query = "INSERT INTO public.comision_artistica (fecha_comision_artistica) VALUES ('".  date("d/m/Y")."')";
        $comision_artistica_id = $this->obj_consulta->ejecutar($sql_query,'ingresaComision','insert');
        $mensaje = $this->obj_general->msj_insert($comision_artistica_id);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje,'comision_artistica_id'=>$comision_artistica_id);
        return json_encode($retorno);
    }//Fin ingresaArtista.
	
    function actualizaComision($parametros)    {
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("UPDATE public.comision_artistica SET tipo_artista_id = %s, nombre_artista = '%s', sexo_id = %s, 
                WHERE artista_id = %s",
                $str_d['tipo_artista_id']);
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaArtista','update');
        $mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        return json_encode($retorno);
    }//Fin actualizaArtista.
    
    function ActualizarEstatusProyecto($parametros)    {
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("UPDATE public.proyecto SET estatus_proyecto_id = %s, comision_artistica_id = %s, motivo_rechazo_id = %s
                WHERE proyecto_id = %s",
                $str_d['estatus_proyecto_id'],
                $str_d['comision_artistica_id'],
                $str_d['motivo_rechazo_id'],
                $str_d['proyecto_id']);
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'ActualizarEstatusProyecto','update');
        $mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        return json_encode($retorno);
    }//Fin ActualizarEstatusProyecto.
    
    function LlenarSolicitudes($parametros)    {
        $html = '';
        $str_d = json_decode(stripcslashes($parametros),true);
        $result = $this->consultaComision($str_d,$str_d['caso'],'');//echo var_dump($result);
        $i = 1;
        while ($filas = $this->obj_consulta->rstRegistros($result)) {
            if ($i%2==0){
                $background = '';
            }else{
                $background = 'background-color:#CCCCCC';
            }
            $div = '<tr id="'.$filas['proyecto_id'].'" class="fila_seleccionables"  style="'.$background.'">';
                $div .= '<td id="fecha_'.$filas['proyecto_id'].'">'.$filas['fecha_proyecto'].'</td>';
                $div .= '<td id="tipo_artista_'.$filas['proyecto_id'].'">'.$filas['nombre_tipo_artista'].'</td>';
                $div .= '<td id="artista_'.$filas['proyecto_id'].'">'.$filas['nombre_artista'].'</td>';
                $div .= '<td id="proyecto_'.$filas['proyecto_id'].'">'.$filas['nombre_proyecto'].'</td>';
                $div .= '<td id="genero_'.$filas['proyecto_id'].'">'.$filas['nombre_genero_musical'].'</td>';
                $div .= '<td id="decision">';
                $div .= '<a href="#" onclick="agregar_aprobado(\''.$filas['proyecto_id'].'\')"><div class="like"></div></a>';
                $div .= '<a href="#" onclick="agregar_rechazado(\''.$filas['proyecto_id'].'\')"><div class="liked"></div></a>';
                $div .= '</td>';
            $div .= '</tr>';
            $i++;
            $html = $html.$div;
        }
        $retorno = array('mensaje'=>$mensaje,'html'=>$html);
        return json_encode($retorno);
    }//Fin ActualizarEstatusProyecto.
    function listarGrilla($proyecto_id){
    $result = $this->consultaComision('','listar_proyectos','');
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
                $div .= '<td>&nbsp;'.$filas['nombre_proyecto'].'</td>';
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