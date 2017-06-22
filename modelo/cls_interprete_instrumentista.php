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
    function consultaInterpretesInstrumentista($str_d='', $case=''){
        $tabla='public.interprete_instrumentista';
	$campos = "proyecto.*";
        $Union = '';
        switch($case){
            case "por_seleccion":
                $tabla='public.proyecto';
                $campos = "proyecto.*,tema.*";
                $Union = 'INNER JOIN public.tema ON proyecto.proyecto_id = tema.proyecto_id ';
                $sql_criterio = " WHERE (tema.tema_id = $str_d)";
                break;
            case "por_tema":
                $campos = "interprete_instrumentista.*,proyecto.proyecto_id,tema.nombre_tema,proyecto.*,instrumento.nombre_instrumento,artista.tipo_artista_id";
                $Union = 'INNER JOIN public.tema ON interprete_instrumentista.tema_id = tema.tema_id ';
                $Union .= 'INNER JOIN public.proyecto ON tema.proyecto_id = proyecto.proyecto_id ';
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.instrumento ON interprete_instrumentista.instrumento_id = instrumento.instrumento_id ';
                $sql_criterio = " WHERE (interprete_instrumentista.tema_id = $str_d)";
                break;
            case "por_interprete_instrumentista":
                $campos = "interprete_instrumentista.*,tema.nombre_tema,proyecto.nombre_proyecto,instrumento.nombre_instrumento";
                $Union = 'INNER JOIN public.tema ON interprete_instrumentista.tema_id = tema.tema_id ';
                $Union .= 'INNER JOIN public.proyecto ON tema.proyecto_id = proyecto.proyecto_id ';
                $Union .= 'INNER JOIN public.instrumento ON interprete_instrumentista.instrumento_id = instrumento.instrumento_id ';
                $sql_criterio = " WHERE (interprete_instrumentista.interprete_instrumentista_id = $str_d)";
                break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";//echo $sql_query;
        return $this->obj_consulta->ejecutar($sql_query,'consultaCatalogo','select');
    }//Fin consultaCatalogo.
    
    function SeleccionarTema($tema_id){
        $result = $this->consultaInterpretesInstrumentista($tema_id,'por_seleccion','');
        if ($this->obj_consulta->rstNroFilas($result)) {
            extract($this->obj_consulta->rstRegistros($result));
            $retorno = array('tema_id'=>$tema_id,'nombre_tema'=>$nombre_tema,'nombre_proyecto'=>$nombre_proyecto);
        }
        $this->obj_consulta->free_rst($result);
        return json_encode($retorno);
    }//Fin Seleccionar.
    
    function SeleccionarInterpreteInstrumentista($interprete_instrumentista_id){
        $result = $this->consultaInterpretesInstrumentista($interprete_instrumentista_id,'por_interprete_instrumentista','');
        if ($this->obj_consulta->rstNroFilas($result)) {
            extract($this->obj_consulta->rstRegistros($result));
            $retorno = array(
                'tema_id'=>$tema_id,
                'interprete_instrumentista_id'=>$interprete_instrumentista_id,
                'nombre_interprete_instrumentista'=>$nombre_interprete_instrumentista,
                'instrumento_id'=>$instrumento_id);
        }
        $this->obj_consulta->free_rst($result);
        return json_encode($retorno);
    }//Fin Seleccionar.

    function cargaGrilla($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $result = $this->consultaInterpretesInstrumentista($str_d['sel_temaVM'],'por_tema','');
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
    
    function LlenarInterprete($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $result = $this->consultaInterpretesInstrumentista($str_d['tema_id'],$str_d['caso'],'');
        while ($filas = $this->obj_consulta->rstRegistros($result)) {
            if ($i%2==0){
                $background = '';
            }else{
                $background = 'background-color:#CCCCCC';
            }            
            $div = '<tr id="'.$filas['interprete_instrumentista_id'].'" class="fila_interprete_instrumentista" style="'.$background.'">';
            	$div .= '<td id="nombre_proyecto_'.$filas['interprete_instrumentista_id'].'">&nbsp;'.$filas['nombre_proyecto'].' </td>';
                $div .= '<td id="nombre_tema_'.$filas['interprete_instrumentista_id'].'">&nbsp;'.$filas['nombre_tema'].'</td>';
                $div .= '<td id="nombre_interprete_instrumentista_'.$filas['interprete_instrumentista_id'].'">&nbsp;'.$filas['nombre_interprete_instrumentista'].'</td>';
                $div .= '<td id="nombre_instrumento_'.$filas['interprete_instrumentista_id'].'">&nbsp;'.$filas['nombre_instrumento'].'</td>';
                $div .= '<td id="decision">';
                $div .= '<a href="#" onclick="modificar('.$filas['interprete_instrumentista_id'].')"><div class="like"></div></a>';
                $div .= '<a href="#" onclick="eliminar('.$filas['interprete_instrumentista_id'].')"><div class="liked"></div></a></td>';
            $div .= '</tr>';
            $i++;
            $html = $html.$div;
        }
        $this->obj_consulta->free_rst($result);
        $retorno = array('html'=>$html);
        return json_encode($retorno);
    }//Fin Seleccionar.
    
    function ingresaInterprete($parametros){
        $id_x = '';
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("INSERT INTO public.interprete_instrumentista (tema_id, nombre_interprete_instrumentista, instrumento_id)
            VALUES(%s, '%s', %s)",
            $str_d['tema_id'], 
            htmlspecialchars($str_d['nombre_interprete_instrumentista'],3),  
            $str_d['instrumento_id']);
        $interprete_instrumentista_id = $this->obj_consulta->ejecutar($sql_query,'ingresaInterprete_Instrumentista','insert');
        $mensaje = $this->obj_general->msj_insert($interprete_instrumentista_id);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje,'interprete_instrumentista_id'=>$interprete_instrumentista_id);
        return json_encode($retorno);
    }//Fin ingresaInterprete_Instrumentista.
	
    function actualizaInterprete($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("UPDATE public.interprete_instrumentista SET 
            nombre_interprete_instrumentista = '%s', instrumento_id = %s
            WHERE interprete_instrumentista_id = %s",
            htmlspecialchars($str_d['nombre_interprete_instrumentista'],3), 
            $str_d['instrumento_id'],
            $str_d['interprete_instrumentista_id']);
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaInterprete','update');
        $mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        return json_encode($retorno);
    }//Fin actualizaInterprete.
    
    function eliminarInterprete_Instrumentista($interprete_instrumentista_id){
        $reg_afectado='';
        if(!$this->obj_consulta->rstNroFilas($result)){
            $sql_query = sprintf("DELETE FROM interprete_instrumentista WHERE interprete_instrumentista_id = %s", $interprete_instrumentista_id);
            $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'eliminarInterprete_Instrumentista','delete');
            $mensaje = $this->obj_general->msj_delete($reg_afectado);
        }
        $retorno = array('mensaje'=>$mensaje,'reg_afectado'=>$reg_afectado);
        return json_encode($retorno);
    }//Fin eliminarArtista.

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>