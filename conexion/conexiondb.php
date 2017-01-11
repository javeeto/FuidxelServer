<?php

date_default_timezone_set('America/Bogota');
//putenv("LD_LIBRARY_PATH=$INFORMIXDIR/lib/esql");
session_start();
if (!isset($_SESSION["s_nombreusuario"])||
        trim($_SESSION["s_nombreusuario"]=='')) {
     echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=../../entrada/vista/cerrar.php'/>";
     exit();
}
function connectionMysqlPDO($destino = "") {
    session_cache_limiter('private');

    try {
        $dsn = "mysql:host=localhost; port=3306;" . "dbname=fuidxeldb;";
        $dbh = new PDO($dsn, "root", "admin");
        return $dbh;
    } catch (PDOException $e) {
        print "Conexion incorrecta MYSQL !: " . $e->getMessage() . "<br/>";
        die();
    }


}


?>