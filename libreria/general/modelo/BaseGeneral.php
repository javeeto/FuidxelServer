<?php

class Operacion {

    private $operando;

    function __construct($operando) {
        $this->operando = $operando;
    }

    function fetchRow() {
        return $this->operando->fetch(PDO::FETCH_ASSOC);
    }

}

class BaseResult {

    private $operacion;
    private $debug;

    function __construct() {
        $this->debug = 0;
    }

    function debug() {
        $this->debug = 1;
    }

    function setOperacion($operacion) {
        $operacion->execute();
        $this->operacion = $operacion;
    }

    function setConexion($conexion) {
        $this->conex = $conexion;
    }

    function fetchRow() {
        return $this->operacion->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
    }

    function fetchNum() {
        return $this->operacion->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
    }

    function query($query) {

        if ($this->debug) {
            echo "\n<br>" . $query . "<br>\n";
        }

        $this->operacion = $this->conex->prepare($query);

        $this->operacion->execute();
        $objoperando = new Operacion($this->operacion);
        //$this->baseresult->setOperacion($operacion);
        //$row_operacion =  $this->operacion->fetch(PDO::FETCH_ASSOC);
        return $objoperando;
    }

}

class BaseGeneral {

    private $conex;
    private $conexion;
    private $filasxpagina;
    private $numeropagina;
    private $baseresult;
    private $contadorquery;
    private $debug;

    //
    //
    function __construct($conex) {
        $this->conex = $conex;
        $this->conex->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->numeropagina = 1;
        $this->baseresult = new BaseResult();
        $this->conexion = new BaseResult();
        $this->conexion->setConexion($this->conex);
        $this->contadorquery = 0;
        $this->debug = 0;
    }

    //Debug de sql
    function debug() {
        $this->baseresult->debug();
        $this->baseresult->debug();
        $this->debug = 1;
        //$this->conex->debugDumpParams();
    }

    function query($query) {
        $operacion = $this->conex->prepare($query);
        $this->baseresult->setOperacion($operacion);
        return $this->baseresult;
    }

    //Setea numero de registros por pagina
    function setFilasxPagina($filasxpagina) {
        $this->filasxpagina = $filasxpagina;
    }

    //Setea numero de registros por pagina
    function setNumeroPagina($numeropagina) {
        $this->numeropagina = $numeropagina;
    }

    //Hace una consulta de una sola tabla $tabla dependiendo del id de la tabla $nombreidtabla
    //donde se puede añadir una condicion $condicion y una operacion (max(),min(),sum()...) basica  
    function recuperar_datos_tabla($tabla, $nombreidtabla, $idtabla, $condicion = "", $operacion = "", $imprimir = 0, $sinasterisco = 0) {
        //$query = "select * $operacion from $tabla where $nombreidtabla= '$idtabla' $condicion";

        if (!$sinasterisco) {
            $query = "select * $operacion from $tabla where $nombreidtabla= '$idtabla' $condicion";
        } else {
            $query = "select $operacion from $tabla where $nombreidtabla= '$idtabla' $condicion";
        }

        if ($imprimir)
            echo "<br>\n" . $query . "<br>\n";
        /* if (isset($this->filasxpagina) &&
          $this->filasxpagina != '') {
          $operacion = $this->conex->PageExecute($query, $this->filasxpagina, $this->numeropagina);
          } else { */
        $result = $this->conex->prepare($query);


        //try {
        $result->execute();
        /* } catch (Exception $e) {
          print "Error!: " . $e->getMessage() . "<br/>";
          die();
          } */
        //  $result->execute();
        // $operacion = $this->conex->PageExecute($query, 1, 1);
        //}
        $row_operacion = $result->fetch(PDO::FETCH_ASSOC);
        /* echo "row_operacion<pre>";
          print_r($row_operacion);
          echo "</pre>"; */
        return $row_operacion;
    }

    //Hace una consulta de una sola tabla $tabla dependiendo del id de la tabla $nombreidtabla
    //donde se puede añadir una condicion $condicion y una operacion (max(),min(),sum()...) basica  
    function recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion = "", $operacion = "", $imprimir = 0, $sinasterisco = 0) {

        $baseresult = new BaseResult();

        if (!$sinasterisco) {
            $query = "select * $operacion from $tabla where $nombreidtabla= '$idtabla' $condicion";
        } else {
            $query = "select $operacion from $tabla where $nombreidtabla= '$idtabla' $condicion";
        }
        if ($imprimir)
            echo $query;

//exit();
        if (isset($this->filasxpagina) &&
                $this->filasxpagina != '') {

            //echo "<h1>Entra en 1</h1>";
            //$operacion = $this->conex->PageExecute($query, $this->filasxpagina, $this->numeropagina);
            $operacion = $this->conex->prepare($query);
            $baseresult->setOperacion($operacion);
        } else {
            //echo "<h1>Entra en 2</h1>";
            try {
                $operacion = $this->conex->prepare($query);
                /*
                  $operacion->execute();
                  $row_operacion = $operacion->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);

                  echo "row_operacion<pre>";
                  print_r($row_operacion);
                  echo "<pre>"; */



                //$operacion->debugDumpParams();
                //$operacion->execute();
            } catch (Exception $e) {
                echo "<b>Problema con base de datos: " . $e->getMessage() . "</b>";
            }
            $baseresult->setOperacion($operacion);
        }



        return $baseresult;
    }

    //Hace una consulta de una sola tabla $tabla dependiendo del id de la tabla $nombreidtabla
    //donde se puede añadir una condicion $condicion y una operacion (max(),min(),sum()...) basica  
    function recuperar_datos_tabla_fila($tabla, $clave, $valor, $condicion = "", $operacion = "", $imprimir = 0, $tipo = 1) {
        $condicion == "" ? $where = "" : $where = "where";
        $query = "select $clave, $valor $operacion from $tabla $where  $condicion";

        if ($imprimir)
            echo $query;
//        $Mode = $this->conex->fetchMode;
        /* if (!$tipo)
          $this->conex->SetFetchMode(ADODB_FETCH_NUM); */

        $result = $this->conex->prepare($query);

        $this->baseresult->setOperacion($result);
        $operacion = $this->baseresult;

        $explodeclave = explode(".", $clave);
        $explodevalor = explode(".", $valor);
        $i = 0;
        if ($explodeclave[1] != "")
            $clave = $explodeclave[1];
        if ($explodevalor[1] != "")
            $valor = $explodevalor[1];
        if ($tipo) {
            while ($row_operacion = $operacion->fetchRow()) {
                $fila[trim($row_operacion[$clave])] = trim($row_operacion[$valor]);
                $i++;
                if ($i > 1000) {
                    break;
                }
            }
        } else {


            while ($row_operacion = $operacion->fetchNum()) {

                $fila[trim($row_operacion[0])] = trim($row_operacion[1]);
                $i++;
                if ($i > 1000) {
                    break;
                }
            }
        }
        //$this->conex->SetFetchMode($Mode);



        if ($imprimir)
            echo $query;

        return $fila;
    }

    //Inserta una fila de datos del tipo $fila['clave']=valor en la tabla $tabla donde 
    //las claves son los nombres de los campos y los valores son los valores de campo a insertar
    function insertar_fila_bd($tabla, $fila, $imprimir = 0, $load = "", $refeconsulta = 0) {
        //$this->conex->SetFetchMode(ADODB_FETCH_NUM);
        //ADOdb_Active_Record::SetDatabaseAdapter($this->conex);
        //  $obj = new ADODB_Active_Record($tabla);
        //$obj = new ADOdb_Active_Record($tabla);                
        $claves3 = "";
        $valores3 = "";
        $i = 0;
        //while (list ($clave, $val) = each($fila)) {
        $filatmp = $fila;

        foreach ($filatmp as $clave3 => $val3) {
            if ($i > 0) {
                $claves3 .= "," . $clave3 . "";
                $valores3 .= ",'" . $val3 . "'";
                // $arrayvalores[$clave]=$val;
            } else {
                $claves3 .= "" . $clave3 . "";
                $valores3 .= "'" . $val3 . "'";
            }
            $i++;
        }
        $claves2 = $claves3;
        $claves3 = "(" . $claves3 . ")";
        $valores3 = "(" . $valores3 . ")";


        if ($load <> "") {
            //   if ($refeconsulta) {
            $datosconsulta = $this->recuperar_datos_tabla($tabla, 1, 1, " and " . $load, " 1 datoclave, " . $claves2 . "", $imprimir, 1);
            if ($imprimir) {
                echo "<br>datosconsulta<pre>";
                print_r($datosconsulta);
                var_dump($datosconsulta);
                echo "</pre>";
                echo "\n<br>if (" . count($datosconsulta) . " > 0) {isset=" . isset($datosconsulta) . "\n";
            }
            unset($claves2);
            if (isset($datosconsulta) &&
                    trim($datosconsulta["datoclave"]) != '') {
                if ($imprimir) {
                    echo "<br>fila actualiza<pre>";
                    print_r($fila);
                    echo "</pre>";
                }

                $this->actualizar_fila_bd($tabla, $fila, '1', '1', "and " . $load, $imprimir);

                //  exit();
            } else {
                $sql = "insert into $tabla $claves3 values $valores3";
                if ($imprimir)
                    echo $sql;

                $operacion = $this->conex->prepare($sql);
                $operacion->execute();
            }
            //  $resconsultarefe->closeCursor();
            /* } else {
              /*   $obj->load($load);
              while (list ($clave, $val) = each($fila)) {
              $obj->$clave = $val;
              }
              if ($imprimir)
              print_r($obj);
              $obj->save();
              } */
        } else {
            $sql = "insert into $tabla $claves3 values $valores3";
            if ($imprimir)
                echo $sql;
            $operacion = $this->conex->prepare($sql);
            $operacion->execute();
        }
    }

    //Actualiza de una fila de datos del tipo $fila['clave']=valor en la tabla $tabla donde 
    //las claves son los nombres de los campos y los valores son los valores de campo a actualizar
    //dependiendo del id de la tabla ingresado $idtabla
    function actualizar_fila_bd($tabla, $fila, $nombreidtabla, $idtabla, $condicion = "", $imprimir = 0) {
        $i = 0;
        while (list ($clave, $val) = each($fila)) {

            if ($i > 0) {
                $claves .= "," . $clave . "";
                $valores .= ",'" . $val . "'";
                $condiciones .= "," . $clave . "='" . $val . "'";
            } else {
                $claves .= "" . $clave . "";
                $valores .= "'" . $val . "'";
                $condiciones .= $clave . "='" . $val . "'";
            }
            $i++;
        }
        $sql = "update $tabla set $condiciones where $nombreidtabla=$idtabla $condicion";

        if ($imprimir)
            echo $sql;

        $operacion = $this->conex->prepare($sql);
        $operacion->execute();
    }

    //Ingresa o actualiza un registro dependiendo de si se encuentran registros con el mismo id
    //o la misma condicion. 
    function ingresar_actualizar_fila_bd($tabla, $fila, $nombreidtabla, $idtabla, $condicion = "") {
        $sql = "select * from $tabla where $nombreidtabla=$idtabla $condicion";
        $operacion = $this->conex->query($sql);
        $numrows = $operacion->fetchColumn();
        if ($numrows > 0)
            $this->actualizar_fila_bd($tabla, $fila, $nombreidtabla, $idtabla, $condicion);
        else
            $this->insertar_fila_bd($tabla, $fila);
    }

    //Ingresa o anula un registro dependiendo de si se encuentran registros con el mismo id
    //o la misma condicion. 
    function ingresar_vencer_fila_bd($tabla, $fila, $nombreidtabla, $idtabla, $condicion = "") {
        $sql = "select * from $tabla where $nombreidtabla=$idtabla $condicion";
        $operacion = $this->conex->query($sql);
        $numrows = $operacion->fetchColumn();
        if ($numrows > 0)
            insertar_fila_bd($tabla, $fila);
        else
            actualizar_fila_bd($tabla, $fila, $nombreidtabla, $idtabla, $condicion);
    }

    //
    function close() {
        $this->conex->close();
        //$this->conex->closeCursor();
    }

}

?>