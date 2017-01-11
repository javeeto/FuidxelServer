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
session_start();

require_once '../../libreria/general/controlador/FuncionesCadena.php';

$_SESSION["s_nombreusuario"] = limpiaCadena($_GET["usuario"]);

require_once '../../conexion/constanteerror.php';
require_once '../../conexion/constantes.php';
require_once '../../conexion/conexiondb.php';
require_once '../../libreria/general/modelo/FuncionesSeguridad.php';
require_once '../../libreria/general/controlador/FuncionesFecha.php';
require_once '../../libreria/general/modelo/BaseGeneral.php';
require_once '../../administracion/modelo/GestionUsuario.php';
require_once '../../libreria/general/modelo/GestionMetadato.php';
require_once '../../consolidacion/controlador/ConformaDocumento.php';
require_once '../../consolidacion/modelo/GestionDocumento.php';
require_once '../../consolidacion/controlador/CargaXMLDocumento.php';
require_once '../../consolidacion/controlador/ConformaXmlCMIS.php';
require_once ('../../libreria/opencmis/controlador/cmis_service.php');
require_once ('../../libreria/opencmis/controlador/cmis-lib.php');
require_once ('../../libreria/opencmis/controlador/cmis_repository_wrapper.php');

if (isset($_SESSION["s_nombreusuario"])) {
    session_start();
   
        $iddetalledocumento=  limpiaCadena($_GET["iddetalledocumento"]);
        $objcargacmis = new CargaXMLDocumento();
       // $objcargacmis->debug();
        $datosMetaDoc=$objcargacmis->consultaRegistroMetadato($iddetalledocumento);
    
}

