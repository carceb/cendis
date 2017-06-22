<?php 
class general{
    function msj_insert($id){
        if($id > 0){
            $mensaje = 'La operación se efectuó exitosamente';
        }else{
            $mensaje = 'Disculpe, la operación no se efectuó. Intente de nuevo por favor o contacte al administrador de sistemas';
        }
        return $mensaje;
    }
    function msj_update($x){
        if($x > 0){
            $mensaje = 'La operación se efectuó exitosamente';
        }else{
            $mensaje = 'Disculpe, la operación no se efectuó. Puede ser que no realizó cambios o falló la operación. Intente de nuevo por favor ó contacte al administrador de sistemas';
        }
        return $mensaje;
    }
    function msj_delete($x){

        if($x > 0){
            $mensaje = 'La operación se efectuó exitosamente';
        }else{
            $mensaje = 'Disculpe, el registro no se eliminó. Intente de nuevo por favor o contacte al administrador de sistemas';
        }
        return $mensaje;
    }
    function formatea_fecha_bd($var_fecha){// CONVIERTE LA FECHA A MYSQL o POSTGRES
                    //para los días que trae un solo dígito se le agrega cero a la izquierda e igual para el mes.
                    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $var_fecha, $lugarx);
                    $dia = strlen($lugarx[1]); if($dia==1){$dia_x.="0".$lugarx[1];}else{$dia_x=$lugarx[1];}
                    $mes = strlen($lugarx[2]); if($mes==1){$mes_x.="0".$lugarx[2];}else{$mes_x=$lugarx[2];}
                    $year_x = $lugarx[3];
                    $fechaMySql=$year_x."-".$mes_x."-".$dia_x;
                    if(!$fechaMySql){$fechaMySql="0000/00/00";}
                    return $fechaMySql;
            }

    function formatea_fecha_normal($fechax){// CONVIERTE LA FECHA A MYSQL A NORMAL.
        ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fechax, $lugarx);
        $dia = strlen($lugarx[3]); if($dia==1){$dia_x.="0".$lugarx[3];}else{$dia_x=$lugarx[3];}
        $mes = strlen($lugarx[2]); if($mes==1){$mes_x.="0".$lugarx[2];}else{$mes_x=$lugarx[2];}
        $year_x = $lugarx[1];
        $fec_normal=$dia_x."/".$mes_x."/".$year_x;
        if(!$fechax){$fec_normal='00-00-0000';}
        return $fec_normal;
    }
    
    function escape_comillas($cadena)
    {
            //Retorna una cadena con las comillas dobles o simples escapadas. Aunque el objetivo principal es escapar las comillas dobles para no reventar
            //la función java que recoje los valores entre comillas cencillas.
            return htmlspecialchars($cadena,ENT_QUOTES);
    }
    
    function htmlkarakter($string){
        $string = str_replace(array("&lt;", "&gt;", '&amp;', '&#039;', '&quot;','&lt;', '&gt;'), array("<", ">",'&','\'','"','<','>'), htmlspecialchars_decode($string, ENT_NOQUOTES));
        $string = str_replace(array("'", '"'), array("\'", "\'"), $string);
        return $string;
    }

    function replaceComiSenc($cadena){
        return ereg_replace("'", "\"", $cadena);
    }

    function replaceEnter($cadena){
        return ereg_replace("U000A", "/n", $cadena);
    }
    
    function PadreAbsoluto($entes_id){
        $this->obj_consulta = new DB();
        $padre = false;
        while(!$padre) {
            $sql_query = "SELECT * FROM public.grl_entes WHERE entes_id = $entes_id";
            $result = $this->obj_consulta->ejecutar($sql_query,'PadreAbsoluto','select');
            extract($this->obj_consulta->rstRegistros($result));
            if ($entes_idpadre == 0)
                $padre = true;
            else{
                $padre = false;
                $entes_id = $entes_idpadre;
            }
            $this->obj_consulta->free_rst($result);
        }
        return $entes_id;
    }

	function Mayusculas($valor){
		return strtoupper($valor);
	}	
}

?>