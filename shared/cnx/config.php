<?php
    $conf_db[1]["servidor"] = "localhost";
    $conf_db[1]["usuario"]  = "postgres";
    $conf_db[1]["password"] = "123456";
    $conf_db[1]["bbdd"]     = "sis_cendis";
    $conf_db[1]["port"]     = "5432";
    $conf_db[1]["typedb"]   = "1";

    $conf_db[2]["servidor"] = "localhost";
    $conf_db[2]["usuario"]  = "root";
    $conf_db[2]["password"] = "123x2";
    $conf_db[2]["bbdd"]     = "central_bd";
    $conf_db[2]["port"]     = "3306";
    $conf_db[2]["typedb"]   = "2";

/*
    Type DB: Motor de base de datos
    1: Mysql
    2: PostgreSQL
*/
    // Conexion por defecto
    $nconex     = "1";
    $servidor   = $conf_db[$nconex]["servidor"];
    $usuario    = $conf_db[$nconex]["usuario"];
    $password   = $conf_db[$nconex]["password"];
    $bbdd       = $conf_db[$nconex]["bbdd"];
    $port       = $conf_db[$nconex]["port"];
    $typedb     = $conf_db[$nconex]["typedb"];
?> 
