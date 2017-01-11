<?php

/*
 *  FuidXel is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *  
 *  FuidXel is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  
 *  You should have received a copy of the GNU General Public License
 *  along with FuidXel.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Descripcion del codigo de controlGestionMetadato
 * 
 * @file controlGestionMetadato.php
 * @author Javier Lopez Martinez
 * @date 14/11/2016
 * @brief Contiene ...
 */


require_once '../../conexion/idioma/entrada.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/constanteerror.php';
require_once '../../conexion/conexiondb.php';
require_once '../../libreria/general/controlador/FuncionesCadena.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
require_once '../../libreria/general/vista/FormularioBase.php';
require_once '../../libreria/general/modelo/FuncionesSeguridad.php';
require_once '../../libreria/general/controlador/FuncionesFecha.php';
require_once '../../libreria/general/modelo/GestionMetadato.php';
require_once '../../libreria/general/controlador/FormaMetadato.php';
require_once '../../administracion/modelo/GestionUsuario.php';
$error = false;



if (isset($_SESSION["s_nombreusuario"])) {
    $conexionmysql = connectionMysqlPDO();
    $objbase = new BaseGeneral($conexionmysql);
    $objformulario = new FormularioBase();
    $objmetadato = new GestionMetadato($objbase);
    $objformulario->setRequestenviar("enviar_f" . $s_idformulario);
    $objforma = new FormaMetadato($objbase, $objformulario);
    $objgestionusuario = new GestionUsuario($_SESSION["s_nombreusuario"], $objbase);
    $datosusuario = $objgestionusuario->consultaDatosUsuario();


    $idformulario = limpiaCadena($s_idformulario);
    $iddetalledocumento = limpiaCadena($s_iddetalledocumento);


    $objmetadato->setIdFormulario($idformulario);
    //$objmetadato->debug();
    
    $objmetadato->consultaMetadatoFormulario();
    $objmetadato->consultaCampoMetadato();
    $objmetadato->setIdDetalleDocumento($iddetalledocumento);
    $datosregistros = $objmetadato->consultaRegistroDocumento();
    /* echo "datosregistros<pre>";
      print_r($datosregistros);
      echo "</pre>"; */
    $datosmetadato = $objmetadato->getDatosMetadato();
    $datosgrupometadato = $objmetadato->getDatosGrupoMetadato();
    $datoscampo = $objmetadato->getDatosCampo();

    /* echo "datosmetadato<pre>";
      print_r($datosmetadato);
      echo "</pre>"; */
    $objforma->setDatosMetadato($datosmetadato);
    $objforma->setObjMetadato($objmetadato);
    /* echo "datosgrupometadato<pre>";
      print_r($datosgrupometadato);
      echo "</pre>"; */
    $objforma->setDatosGrupoMetadato($datosgrupometadato);
    /* echo "datoscampo<pre>";
      print_r($datoscampo);
      echo "</pre>"; */
    $objforma->setDatosCampo($datoscampo);
    if (isset($datosregistros)) {
        $objforma->registrosValores($datosregistros);
    }

    //$objforma->debug();
/*echo "datosgrupometadato<pre>";
          print_r($datosgrupometadato);
          echo "</pre>";*/
    for ($i = 0; $i < count($datosgrupometadato); $i++) {
        $arrPanel[$i] = $objforma->panelNuevo($datosgrupometadato[$i]["idgrupometadato"]);
    }

   /* echo "<h1>Paneles=".count($arrPanel)."</h1>";
echo "datosgrupometadato<pre>";
          print_r($arrPanel[1]["errormetadato"]);
          echo "</pre>";*/
$s_salidaformulario[$s_idformulario]=0;
    if ($objforma->getError() ||
            $s_error2) {
        $error = 1;
        $mensajerror = ERR0003 ."/".$objforma->getObjformulario()->getErrorValida(). "/" . $s_mensajerror2;
    } else {
        /* echo "_POST<pre>";
          print_r($_POST);
          echo "</pre>"; */




        if (isset($_POST["enviar_f" . $s_idformulario])) {
            // $objmetadato->debug();
            if ($s_validaunicidad) {
              //  $objmetadato->debug();
                if (!$objmetadato->validaUnicidadRegistro($s_datoscampoVal)) {
                    $error = 1;
                    $mensajerror = ERR0109 . "/" . $mensajerror;
                }
            }
            if (!$error) {
                 //$objforma->debug();
                $registros = $objforma->recuperaRegistroEnviado($iddetalledocumento);
               /* echo "registros<pre>";
                  print_r($registros);
                  echo "</pre>"; */
                foreach ($registros as $iregistro => $filaregistro) {
                    $objmetadato->setDatosRegistro($filaregistro);
                    $objmetadato->setIdusuario($datosusuario["idusuario"]);

                    //Si registro recuperado existe (modificacion) se define el registro
                    // a modificar
                    if (isset($datosregistros[$filaregistro["idcampometadato"]])) {
                        $idregistrometadato = $datosregistros[$filaregistro["idcampometadato"]]["idregistrometadato"];
                        if (isset($idregistrometadato) &&
                                trim($idregistrometadato) != '') {
                            $objmetadato->setIdRegistroMetadato($idregistrometadato);
                        }
                    }

                    $objmetadato->registroCampoMetadato();
                }
                $exitoso = 1;
                $mensajerror = ERR0201 . "/" . $s_mensajerror;
                $s_salidaformulario[$s_idformulario]=1;
            }
        }
    }
} else {

    echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=../../entrada/vista/cerrar.php'/>";
}
