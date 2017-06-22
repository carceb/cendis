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
    function consultaPintado($str_d='', $case=''){
        $tabla='public.pintado';
        $campos = "*";
        $Union = '';
        switch($case){
            case "por_listado":
                $sql_criterio = " WHERE (pintado.proyecto_id = $str_d) ORDER BY pintado_id";
                break;
            case "por_listar":
                $tabla='public.proyecto';
                $campos = "proyecto.*,artista.nombre_artista,tipo_artista.nombre_tipo_artista,genero_musical.nombre_genero_musical";
                $Union .= 'INNER JOIN public.artista ON proyecto.artista_id = artista.artista_id ';
                $Union .= 'INNER JOIN public.tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id ';
                $Union .= 'INNER JOIN public.genero_musical ON proyecto.genero_musical_id = genero_musical.genero_musical_id ';
                $sql_criterio = " WHERE (proyecto.estatus_proyecto_id = 8)";
                break;
        }
        $sql_query = "SELECT $campos FROM $tabla $Union $sql_criterio";//echo $sql_query;
        return $this->obj_consulta->ejecutar($sql_query,'consultaPintado','select');
    }//Fin consultaDiseno
    

    
    function listarGrilla($proyecto_id){
        $result = $this->consultaPintado('','por_listar','');
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