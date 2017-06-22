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
    function consultaSeguimiento($str_d='', $case='') {
        switch($case){
        case "listar_proyectos":
                $sql_query ="SELECT  estatus_proyecto.estatus_proyecto_id, COUNT(proyecto.nombre_proyecto) AS TotalProyectos, estatus_proyecto.nombre_estatus_proyecto
                FROM estatus_proyecto INNER JOIN  proyecto ON estatus_proyecto.estatus_proyecto_id = proyecto.estatus_proyecto_id
                WHERE extract(year from fecha_proyecto) = ".$str_d['ano_proyectos'].
                " GROUP BY estatus_proyecto.nombre_estatus_proyecto, estatus_proyecto.estatus_proyecto_id";
                break;
        case "listar_consulta":
                $sql_query="SELECT  estatus_proyecto.estatus_proyecto_id, artista.nombre_artista, proyecto.nombre_proyecto, tipo_artista.nombre_tipo_artista, extract(year from fecha_proyecto) as ano_proyecto, estatus_proyecto.nombre_estatus_proyecto
                FROM estatus_proyecto 
                INNER JOIN  proyecto ON estatus_proyecto.estatus_proyecto_id = proyecto.estatus_proyecto_id
                INNER JOIN  artista ON artista.artista_id = proyecto.artista_id
                INNER JOIN  tipo_artista ON artista.tipo_artista_id = tipo_artista.tipo_artista_id
                WHERE extract(year from fecha_proyecto) = ".$str_d['ano_proyectos']." AND estatus_proyecto.estatus_proyecto_id = ".$str_d['estatus_proyectos']."
                ORDER BY artista.nombre_artista, proyecto.nombre_proyecto";
                break;
        }
        return $this->obj_consulta->ejecutar($sql_query,'consultaSeguimiento','select');
    }
	
    function LlenarSolicitudes($parametros)    {
        $html = '';
        $str_d = json_decode(stripcslashes($parametros),true);//echo var_dump($str_d);
        $result = $this->consultaSeguimiento($str_d,$str_d['caso'],'');
        $i = 1;
        while ($filas = $this->obj_consulta->rstRegistros($result)) {
            if ($i%2==0){
                $background = '';
            }else{
                $background = 'background-color:#CCCCCC';
            }
            $div = '<tr id="'.$filas['estatus_proyecto_id'].'" class="fila_seguimiento"  style="'.$background.'">';
                $div .= '<td>&nbsp;<a href="#" onclick="mostrarListar(\''.$filas['estatus_proyecto_id'].'\')">'.$filas['nombre_estatus_proyecto'].'</a></td>';
                $div .= '<td id="cantidad_'.$filas['estatus_proyecto_id'].'">&nbsp;'.$filas['totalproyectos'].'</td>';
                $div .= '</td>';
            $div .= '</tr>';
            $i++;
            $html = $html.$div;
        }
        $retorno = array('mensaje'=>$mensaje,'html'=>$html);
        return json_encode($retorno);
    }//Fin LlenarSolicitudes.

    function LlenarProyectos($parametros)    {
        $html = '';
        $str_d = json_decode(stripcslashes($parametros),true);
        $result = $this->consultaSeguimiento($str_d,$str_d['caso'],'');
        $i = 1;
        while ($filas = $this->obj_consulta->rstRegistros($result)) {
            if ($i%2==0){
                $background = '';
            }else{
                $background = 'background-color:#CCCCCC';
            }
                $div = '<tr id="'.$filas['estatus_proyecto_id'].'" class="fila_seguimiento"  style="'.$background.'">';
                $div .= '<td>'.$filas['nombre_tipo_artista'].'</td>';
                $div .= '<td>&nbsp;'.$filas['nombre_artista'].'</td>';
                $div .= '<td>&nbsp;'.$filas['nombre_proyecto'].'</td>';
                $div .= '<td>&nbsp;'.$filas['ano_proyecto'].'</td>';
                $div .= '</td>';
                $div .= '</tr>';
                $i++;
                $html = $html.$div;            

        }
        $retorno = array('mensaje'=>$mensaje,'html'=>$html);
        return json_encode($retorno);
    }//Fin LlenarProyectos.    
}//FIN--------------------------------------------------------CLASE---------------------------------------------------------------

?>