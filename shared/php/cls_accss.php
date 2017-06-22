<?php session_start();
$obj_ac = new acceso; //Se instancia la clase
echo $obj_ac->$_POST['metodo']($_POST['parametros']); //se ejecuta el método
class acceso{
//=========================================================================================================================
//Function:      acceso 
//Elaborado por: Juan C. Díaz.
//Description:   Verifica si un persona está registrada como usuario del sistema y valida el acceso a ventanas y procesos(ingresar, modificar etc).
//Nota: Tiene dos métodos de para extraer la permisología: valida_acceso(retorna un array con los valores de acceso) y valida_proceso(retorna solo un valor de acceso especifico)
//========================================================================================================================		
    private $obj_consulta;
    //private $ruta;
    function __construct(){
       require_once('../cnx/Db_class.php');
       $this->obj_consulta = new DB(); $this->I='I';
    }

    function nombre_ventana()
    {
    //=========================================================================================================================
    //	Function:       nombre_ventana
    //  Elaborado por:  Juan C Díaz.
    //	Returns:	El nombre del archivo que contiene el formulario.
    //	Description:    Captura el nombre de la página ejecutada.
    //========================================================================================================================
        $archivo = split('/',$_SERVER['PHP_SELF']);
        $cantidad = count($archivo);
        $archivo = $archivo[$cantidad - 1];
        return $archivo;
    }
    function login($parametros)
    {
    //=========================================================================================================================
    //        Function:      login
    //  Elaborado por:  Juan C Díaz.
    //        Returns:       Los datos del usuario en variables de sessión.
    //        Description:   Verifica si una persona está registrado como usuario del sistema .
    //========================================================================================================================
        $str_d = json_decode(stripcslashes($parametros));
        $sql_query = "SELECT * FROM seguridad.usuario
                      WHERE usuario_user='".$str_d->user_x."' AND usuario_pws='".md5($str_d->pw_x)."' ";
        $result = $this->obj_consulta->ejecutar($sql_query, 'login', 'select');

        if($this->obj_consulta->rstNroFilas($result)){
                extract($this->obj_consulta->rstRegistros($result));
				//VERIFICAMOS QUE EL USUARIO ESTE ACTIVO
				if ($usuario_estatus_id == 1){
                	//datos del usuario que hace login.
					$_SESSION['id_user']=$usuario_id;//Id del usuario
					$_SESSION['usuario_nombre']=$usuario_nombre.' '.$usuario_apellido;//Nombre completo del usuario
					$_SESSION['usuario_sistema']=$usuario_user;//nombre de usuario de sistema(estandar nombrado)
					//$_SESSION['nivel_grupo']=$grupo_nivel;
					$data = array('login'=>true);
				}else{
					$mensaje='Disculpe, su usuario se encuentra Inactivo, comuniquese con el Administrador del Sistema';
            		$data = array('login'=>$mensaje);
				}
                $this->obj_consulta->free_rst($result);
        }else{
            $mensaje='Disculpe, no estás registrado como usuario de este sistema';
            $data = array('login'=>$mensaje);
        }
        echo json_encode($data);
    }


    function valida_acceso($nombre_ventana)
    {
    //=========================================================================================================================
    //	Function:       valida_acceso
    //  Elaborado por:  Juan C Díaz.
    //	Retorna:        Un array con los valores a hacer evaluados para el acceso y procesos.
    //	Description:    Busca los valores correspondiente al acceso y proceso al ejecutar ventana(vista).
    //	Parámetros:     Valores
    //			- $_SESSION['id_user']: valor de id del usuario.
    //			- $nombre_ventana: nombre del archivo(ventana o vista).
    //========================================================================================================================
        if (isset($_SESSION['id_user'])){
            $sql_criterio = " WHERE usuario_grupo.usuario_id = ".$_SESSION['id_user'];
			$sql_criterio .= "  AND ventana.ventana_archivo = '".$nombre_ventana."' ";
            $Union = "INNER JOIN seguridad.grupo ON usuario_grupo.grupo_id = grupo.grupo_id
                      INNER JOIN seguridad.permisos ON permisos.grupo_id = grupo.grupo_id
                      INNER JOIN seguridad.ventana ON ventana.ventana_id = permisos.ventana_id";
            $sql_query = "SELECT * FROM seguridad.usuario_grupo $Union $sql_criterio";//echo $sql_query;
            $result = $this->obj_consulta->ejecutar($sql_query, 'valida_acceso', 'select');
            if($this->obj_consulta->rstNroFilas($result)){
                extract($this->obj_consulta->rstRegistros($result));
				if ($permisos_ventana != 'f'){
					$data = array('pms_ingresar'=>$permisos_ingresar,
						'pms_buscar'=>$permisos_buscar,
						'pms_modificar'=>$permisos_modificar,
						'pms_eliminar'=>$permisos_eliminar,
						'pms_imprimir'=>$permisos_imprimir,
						'pms_listar'=>$permisos_listar,
						'pms_acceso'=>$permisos_ventana,
						'id_ventana'=>$ventana_id);

				}else{
					$data = array('pms_acceso'=>'f','mensaje'=>'Disculpe, No tienes acceso a esa ventana');
				}
                $this->obj_consulta->free_rst($result);
            }else{
				$data = array('pms_acceso'=>'f','mensaje'=>'Disculpe, No tienes acceso a esa ventana');
			}
        }else{
            $data = array('pms_acceso'=>'f','mensaje'=>'Disculpe, Debe ingresar su usuario y clave');
        }
        echo json_encode($data);
    }
/*
    function valida_proceso($tipo_proceso,$ventana)
    {
    //=========================================================================================================================
    //	Function	: valida_proceso
    //  Elaborado por:  Juan C Díaz.
    //	Returns		: True ó false, el id de la ventana y el mensaje correspondiente.
    //	Description	: Valida si el usuario tiene permiso para entrar a una ventana ó ha sus correspondientes procesos.
    //	Parámetros	: Valores
    //			  - $tipo_proceso: tipo de proceso.
    //			  - $ventana: nombre de la ventana.
    //========================================================================================================================
        $nom_ventana = $this->nombre_ventana();//Se captura el nombre del archivo(ventana o vista) que el usuario ejecuta.
        switch($tipo_proceso){
            case "ingresar":
                    $campo = ' && permisos_ingresar="1" ';
                    $msj='Disculpe, no tiene permiso para ingresar datos';
            break;
            case "buscar":
                    $campo = ' && permisos_buscar="1" ';
                    $msj='Disculpe, no tiene permiso para buscar datos';
            break;
            case "modificar":
                    $campo = ' && permisos_modificar="1" ';
                    $msj='Disculpe, no tiene permiso para modificar datos';
            break;
            case "eliminar":
                    $campo = ' && permisos_eliminar="1" ';
                    $msj='Disculpe, no tiene permiso para eliminar datos';
            break;
            case "imprimir":
                    $campo = ' && permisos_imprimir="1" ';
                    $msj='Disculpe, no tiene permiso para imprimir datos';
            break;
            case "procesar":
                    $campo = ' && permisos_procesar="1" ';
                    $msj='Disculpe, no tiene permiso para procesar datos';
            break;
            case "anular":
                    $campo = ' && permisos_anular="1" ';
                    $msj='Disculpe, no tiene permiso para anualar datos';
            break;
            case "acceso":
                    $msj='Disculpe, no tienes acceso a esa ventana';
        }

        $sql_criterio = " WHERE seguridad.usuario_grupo.usuario_id = '".$_SESSION['id_user']."' ".$campo." && adm_ventana.ventana_archivo = '".$nom_ventana."' && adm_permisos.permisos_ventana='1' ";
        $Union = "INNER JOIN adm_permisos ON adm_permisos.grupo_id = seguridad.usuario_grupo.grupo_id
                          INNER JOIN adm_ventana ON adm_ventana.ventana_id = adm_permisos.ventana_id
                         ";
        $sql_query = "SELECT * FROM seguridad.usuario_grupo $Union".$sql_criterio." LIMIT 1";
        //echo $sql_query.'<br>';
        $result = $this->obj_consulta->ejecutar($sql_query,'central_bd','valida_proceso','select','');

        if($result['total_filas']){
                return array('valido'=>true,'id_ventana'=>$result['fila']['ventana_id']);
        }else{
                return array('valido'=>false,'msj'=>$msj);
        }
    }
 */
}//Fin clase general.
?>