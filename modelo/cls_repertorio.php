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
    function consultaTema($str_d='', $case=''){
        $tabla='public.proyecto';
		$campos = "proyecto.*";
        $Union = '';
        switch($case){
            case "por_seleccion":
                $sql_criterio = " WHERE (proyecto.proyecto_id = $str_d)";
                break;
            case "por_tema":
                $tabla='public.tema';
                $campos = "tema.*,proyecto.*,genero_musical.genero_musical_id as codigo_genero_musical, genero_musical.nombre_genero_musical,artista.*";
                $Union = 'INNER JOIN public.proyecto ON tema.proyecto_id = proyecto.proyecto_id ';
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.genero_musical ON tema.genero_musical_id = genero_musical.genero_musical_id ';
                $sql_criterio = " WHERE (tema.tema_id = $str_d)";               
                break;
            case "por_temas":
                $tabla='public.tema';
                $campos = "tema.*,proyecto.*,genero_musical.nombre_genero_musical";
                $Union = 'INNER JOIN public.proyecto ON tema.proyecto_id = proyecto.proyecto_id ';
                $Union .= 'INNER JOIN public.genero_musical ON tema.genero_musical_id = genero_musical.genero_musical_id ';
                $sql_criterio = " WHERE (tema.proyecto_id = $str_d)";
                $sql_criterio .= " ORDER BY track";
                break;
            case "por_track":
                $tabla='public.tema';
                $campos = "tema.*";
                $sql_criterio = " WHERE (tema.proyecto_id = $str_d)";
                $sql_criterio .= " ORDER BY track DESC LIMIT 1";
                break;
            case "por_listado":
                $tabla='public.tema';
                $campos = "tema.*,proyecto.*,genero_musical.nombre_genero_musical,artista.*";
                $Union = 'INNER JOIN public.proyecto ON tema.proyecto_id = proyecto.proyecto_id ';
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.genero_musical ON tema.genero_musical_id = genero_musical.genero_musical_id ';
                $sql_criterio = " WHERE (tema.proyecto_id = $str_d)";
                break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";//echo  $sql_query;
        return $this->obj_consulta->ejecutar($sql_query,'consultaCatalogo','select');
    }//Fin consultaCatalogo.
    
    function SeleccionarProyecto($proyecto_id){
        $result = $this->consultaTema($proyecto_id,'por_seleccion','');
        if ($this->obj_consulta->rstNroFilas($result)) {
            extract($this->obj_consulta->rstRegistros($result));
            $retorno = array('proyecto_id'=>$proyecto_id,'nombre_proyecto'=>htmlspecialchars_decode($nombre_proyecto,3));
        }else{
            $retorno = false;
        }
        $this->obj_consulta->free_rst($result);
        return json_encode($retorno);
    }//Fin Seleccionar.
    
    function SeleccionarTema($tema_id){
        $result = $this->consultaTema($tema_id,'por_tema','');
        if ($this->obj_consulta->rstNroFilas($result)) {
            extract($this->obj_consulta->rstRegistros($result));
            $retorno = array('proyecto_id'=>$proyecto_id,
                'tipo_artista_id'=>$tipo_artista_id,
                'artista_id'=>$artista_id,
                'tema_id'=>$tema_id,
                'nombre_proyecto'=>htmlspecialchars_decode($nombre_proyecto,3),
                'nombre_tema'=>htmlspecialchars_decode($nombre_tema,3),
                'autor_letra'=>htmlspecialchars_decode($autor_letra,3),
                'autor_musica'=>htmlspecialchars_decode($autor_musica,3),
                'arreglo'=>htmlspecialchars_decode($arreglo,3),
                'duracion'=>$duracion,
                'genero_musical_id'=>$codigo_genero_musical,
                'track'=>$track);
        }
        $this->obj_consulta->free_rst($result);
        return json_encode($retorno);
    }//Fin Seleccionar.

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
    
    function LlenarTemas($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $result = $this->consultaTema($str_d['proyecto_id'],'por_temas','');
        while ($filas = $this->obj_consulta->rstRegistros($result)) {
            if ($i%2==0){
                $background = '';
            }else{
                $background = 'background-color:#CCCCCC';
            }
            $div = '<tr style="'.$background.'" class="fila_temas">';
            $div .= '<td>&nbsp;'.$filas['track'].'</td>';
            $div .= '<td>&nbsp;'.$filas['nombre_tema'].'</td>';
            $div .= '<td>&nbsp;'.$filas['autor_letra'].'</td>';
            $div .= '<td>&nbsp;'.$filas['autor_musica'].'</td>';
            $div .= '<td>&nbsp;'.$filas['arreglo'].'</td>';
            $div .= '<td>&nbsp;'.$filas['duracion'].'</td>';
            $div .= '<td>&nbsp;'.$filas['nombre_genero_musical'].'</td>';
            $div .= '<td>';
            $div .= '<a href="#" onclick="modificar('.$filas['tema_id'].')"><div class="edit"></div></a>';
            $div .= '<a href="#" onclick="eliminar('.$filas['tema_id'].')"><div class="delete"></div></a></td>';
            $div .= '</tr>';
            $i++;
            $html = $html.$div;
        }
        $this->obj_consulta->free_rst($result);
        $retorno = array('html'=>$html);
        return json_encode($retorno);
    }//Fin Seleccionar.
    
    function ingresaTema($parametros){
        $id_x = '';
        $str_d = json_decode($parametros,true);
        $sql_query = sprintf("INSERT INTO public.tema (proyecto_id, genero_musical_id, nombre_tema, autor_letra, autor_musica, arreglo, duracion,track)
            VALUES(%s, %s, '%s', '%s', '%s', '%s', '%s',%s)",
            $str_d['proyecto_id'], 
            $str_d['genero_musical_id'], 
            htmlspecialchars($str_d['nombre_tema'],3), 
            htmlspecialchars($str_d['autor_letra'],3), 
            htmlspecialchars($str_d['autor_musica'],3), 
            htmlspecialchars($str_d['arreglo'],3), 
            $str_d['duracion'],
            $str_d['track']);
        $tema_id = $this->obj_consulta->ejecutar($sql_query,'ingresaTema','insert');
        $mensaje = $this->obj_general->msj_insert($tema_id);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje,'tema_id'=>$tema_id);
        //actualiza el estatus proyecto
        $result = $this->consultaTema($tema_id,'por_tema','');
        extract($this->obj_consulta->rstRegistros($result));
        $sql_query = sprintf("UPDATE public.proyecto SET estatus_proyecto_id = %s
            WHERE proyecto_id = %s",
            4, 
            $proyecto_id);
        $this->obj_consulta->ejecutar($sql_query,'actualizaEstatusProyecto','update');
        $this->obj_consulta->free_rst($result);
        return json_encode($retorno);
    }//Fin ingresaTema.
	
    function actualizaTema($parametros){
        $str_d = json_decode(stripcslashes($parametros),true);
        $sql_query = sprintf("UPDATE public.tema SET genero_musical_id = %s, nombre_tema = '%s', 
            autor_letra = '%s', autor_musica = '%s', arreglo = '%s', duracion = '%s', track = %s
            WHERE tema_id = %s",
            $str_d['genero_musical_id'], 
            htmlspecialchars($str_d['nombre_tema'],3), 
            htmlspecialchars($str_d['autor_letra'],3), 
            htmlspecialchars($str_d['autor_musica'],3), 
            htmlspecialchars($str_d['arreglo'],3), 
            $str_d['duracion'],
            $str_d['track'],
            $str_d['tema_id']);
        $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'actualizaTema','update');
        $mensaje = $this->obj_general->msj_update($reg_afectado);//se busca el mensaje de acuerdo al resultado de la operación
        $retorno = array('mensaje'=>$mensaje);
        return json_encode($retorno);
    }//Fin actualizaTema. 
    
    function eliminarTema($tema_id){
        $reg_afectado='';
        if(!$this->obj_consulta->rstNroFilas($result)){
            $sql_query = sprintf("DELETE FROM tema WHERE tema_id = %s", $tema_id);
            $reg_afectado = $this->obj_consulta->ejecutar($sql_query,'eliminarTema','delete');
            $mensaje = $this->obj_general->msj_delete($reg_afectado);
        }
        $retorno = array('mensaje'=>$mensaje,'reg_afectado'=>$reg_afectado);
        return json_encode($retorno);
    }//Fin eliminarArtista.
	
	function NextTrack($proyecto_id){
		$next_track = 1;
        $result = $this->consultaTema($proyecto_id,'por_track','');
        if($this->obj_consulta->rstNroFilas($result)){
            extract($this->obj_consulta->rstRegistros($result));
			$next_track = $next_track + $track;
        }
        $retorno = array('next_track'=>$next_track);
        return json_encode($retorno);
    }//Fin eliminarArtista.

}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>