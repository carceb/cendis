<?php
class DB
{
    # ATRIBUTOS
    private $testeando = true;
    private $email_admin;
    private $conexion;
    private $selec_bbdd;
    private $string_sucio;
    private $string_limpio;
    private $rstPostgre;
    private $rstMySql;
    private $typedb;
    
    function __construct(){
        $nroarg = func_num_args();
        if($nroarg==0){
            $this->typedb = 1;
        }
        if($nroarg==1){
            $this->typedb = func_get_arg(0);
        }
        if($nroarg<=1){
            require("config.php");
            $servidor = $conf_db[$this->typedb]["servidor"];
            $usuario = $conf_db[$this->typedb]["usuario"];
            $password = $conf_db[$this->typedb]["password"];
            $bbdd = $conf_db[$this->typedb]["bbdd"];
            $port = $conf_db[$this->typedb]["port"];
            $typedb = $conf_db[$this->typedb]["typedb"];
        }else{
            $servidor = func_get_arg(0);
            $usuario = func_get_arg(1);
            $password = func_get_arg(2);
            $bbdd = func_get_arg(3);
            $port = func_get_arg(4);
            $typedb = func_get_arg(5);
            $this->typedb = func_get_arg(5);
        }  
        switch($this->typedb){
            case  1:
                $this->conexion = @pg_connect("host=".$servidor." port=".$port." dbname=".$bbdd." user=".$usuario." password=".$password."") or die($this->err());
            break;
            case  2:
                $this->conexion = @mysql_connect($servidor.":".$port, $usuario, $password) or die($this->err());
                $this->selec_bbdd = @mysql_select_db($bbdd, $this->conexion) or die($this->err());
            break;
        }

    }
    private function err(){
        if($this->testeando){
            if(func_num_args()==0){
                $tipo_error = 1;
            }else{
                $tipo_error = 2;
                $consulta = func_get_arg(0);
            }
            switch($this->typedb){
                case  1:
                    if($tipo_error==1){
                        $error = "Conexion a base de datos postgres fallida";
                        echo "<p><b><font color='red'>ERROR:</b> --> </b> $error</font></p>";
                    }elseif($tipo_error==2){
                        echo"<p><i>Error En Consulta SQL:</i><br><span style='color:#FF0000; font-weight:bold;'>$consulta<br>".pg_ErrorMessage($this->conexion)."</span></p>";
                    }
                break;
                case  2:
                    if($tipo_error==1){
                        $error = mysql_errno()." - ".mysql_error();
                        echo "<p><b><font color='red'>ERROR:</b> --> </b> $error</font></p>";
                    }elseif($tipo_error==2){
                        $error = mysql_errno()." - ".mysql_error();
                        echo"<p><i>Error En Consulta SQL:</i><br><span style='color:#FF0000; font-weight:bold;'>$consulta<br>".$error."</span></p>";
                    }
                break;
            }
            exit();
        }
        else{
            echo "<b><font color='red'>Ha Ocurrido un error</font></b>";
            if($this->email_admin){
                echo ", Favor contacte a su adminstrador de sistemas";
            }
            exit();
        }
    }

    public function ejecutar($consulta,$metodo,$modo){
        switch($this->typedb){
            case 1://Conexión POSTGRES.
                if($modo=='select'){
                    $this->rstPostgre = pg_query($this->conexion, $consulta)or die($this->err($consulta.' En el Método :'.$metodo));
                    return $this->rstPostgre;
                }elseif($modo=='insert'){
                    //Se extrae el nombre de esquema y de la tabla.
                    $esqtab  = strtok($consulta,"(");
                    $esqtab = trim($esqtab);
                    $esqtab = explode(' ', $esqtab);
                    $esqtab = explode('.', $esqtab[2]);
                    $esquema = $esqtab[0];//Esquema
                    $tabla = $esqtab[1];//Tabla
                    //Buscar el nombre del indice(campo clave) de la tabla - $campo_clave
					$sql = "SELECT  pg_attribute.attname AS llave
						FROM pg_index, pg_class, pg_attribute 
						WHERE 
						pg_class.oid = '$esquema.$tabla'::regclass AND
						indrelid = pg_class.oid AND
						pg_attribute.attrelid = pg_class.oid AND 
						pg_attribute.attnum = any(pg_index.indkey)
						AND indisprimary ";
                    $res= pg_query($this->conexion,$sql) or die($this->err($consulta.' En el Método :'.$metodo));
                    $rst=pg_fetch_object($res);
                    $campo_clave = $rst->llave;//Se asigna el nombre del campo clave de la tabla.
                    pg_free_result($res);
                    if($campo_clave){//Ingresa los datos a tabla con campo clave y devuelve el nuevo id.
                        //se concatena a la sentencia, el returning del campo clave para poder retornar el id
                        $consulta = $consulta." returning ".$campo_clave;
                        $result = pg_query($this->conexion, $consulta) or die($this->err($consulta.' En el Método :'.$metodo));
                        $id=pg_fetch_array($result);
                        return $id[$campo_clave];//nuevo valor id
                    }else{//Ingresa datos a tabla sin campo clave, devuelve 1.
                        return pg_query($this->conexion, $consulta) or die($this->err($consulta.' En el Método :'.$metodo));
                    }
                }elseif($modo=='update' or $modo=='delete'){
                    $resul = pg_query($this->conexion, $consulta) or die($this->err($consulta.' En el Método :'.$metodo));
                    return pg_affected_rows($resul);
                }
                break;
            case 2://Conexión MySql.
                @mysql_query('set names utf8');
                $this->rstMySql = @mysql_query($consulta, $this->conexion) or die($this->err($consulta.' En el Método :'.$metodo));
                if($modo=='select'){//devuelve el recordset de registros.
                    return $this->rstMySql;
                }elseif($modo=='insert'){//devuelve el nuevo id del registro ingresado.
                    return mysql_insert_id();
                }elseif($modo=='update' or $modo=='delete'){//devuelve el nuemero de registros afectados.
                    return mysql_affected_rows();
                }
                break;
        }
        //return ($this->resultado);
    }

    function rstNroFilas($rst){
        // devuelve el numero total de filas(horizontal) de la consulta
        switch($this->typedb){
            case  1:
                $num_rows = pg_num_rows($rst);
                //$num_rows = pg_num_rows($this->rstPostgre);
            break;
            case  2:
                $num_rows = mysql_num_rows($rst);
            break;
        }
        return $num_rows;
    }
    function rstRegistros($rst){
        // regresará las filas en el resultado como un array
        switch($this->typedb){
            case 1:
                $fetch_array = pg_fetch_array($rst);
            break;
            case 2:
                $fetch_array = mysql_fetch_array($rst);
            break;
        }
        return $fetch_array;
    }
    function free_rst($rst){
        // Libera el recordset
        switch($this->typedb){
            case  1:
                pg_free_result($rst);
            break;
            case  2:
                mysql_free_result($rst);
            break;
        }
    }
    function num_columnas($rst){
        // devuelve el numero total de columnas(vertical) de la consulta
        switch($this->typedb){
            case  1:
                $num_fields = pg_num_fields($rst);
            break;
            case  2:
                $num_fields = mysql_num_fields($rst);
            break;
        }
        return $num_fields;
    }

    function lista_objeto($rst){
        // regresará las filas en el resultado como un objeto
        switch($this->typedb){
            case  1:
                $fetch_object = pg_fetch_object($rst);
            break;
            case  2:
                $fetch_object = mysql_fetch_object($rst);
            break;
        }
        return $fetch_object;
    }
    function lista_array_todas($rst){
        // regresará  TODAS las filas en el resultado como un array
        switch($this->typedb){
            case  1:
                $fetch_all = pg_fetch_all($rst);
            break;
            case  2:
                $fetch_all = mysql_fetch_assoc($rst);
            break;
        }
        return  $fetch_all;
    }
    function __destruct(){

    }
    function __toString(){
        switch($this->typedb){
            case  1:
                return "Conexion a postgres";
            break;
            case  2:
                return "Conexion a mysql";
            break;
        }
    }
} // fin de la clase


/*
$tabla = strtok($consulta, " ");
$tabla = strtok(" ");
$tabla = strtok(" ");
$tabla = strtok($tabla,"(");
$tablax = trim($tabla);
//Se determina el nombre del esquema y de la tabla.
$esquema_x = explode('.', $tablax);
$esquema = $esquema_x[0];
$tabla=$esquema_x[1];
 */