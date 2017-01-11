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
 * Descripcion del codigo de formaindexaimagen
 * 
 * @file formaindexaimagen.php
 * @author Javier Lopez Martinez
 * @date 11/11/2016
 * @brief Contiene ...
 */
require_once '../../consolidacion/controlador/controlFormaIndexa.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1"> 
        <meta  charset="ISO-8859-1">
        <?php require_once '../../plantilla/vista/encabezado.php'; ?>
        <link rel="stylesheet" href="../../plantilla/vista/css/estiloplantilla.css" type="text/css">
        <script src="../../consolidacion/vista/js/herramientaVisor.js"></script>


    </head>
    <body>
        <?php require_once '../../plantilla/vista/menu.php'; ?>

        
            <?php if ($error) { ?>
                <div class="alert alert-danger">
                    <strong>!</strong> <?= $mensajerror ?>
                </div>
            <?php } else { ?>

                <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="pill" href="#formaimagen">Indexaci&oacute;n</a></li>
                    <li><a data-toggle="pill" href="#formaisad">Descripci&oacute;n</a></li>

                </ul>
                <div class="tab-content">
                    <div id="formaimagen" class="tab-pane fade in active">

                        <div class="container-fluid text-center">    
                            <div class="row content">
                                <div class="col-sm-3 sidenav">
                                    <div class="well">

                                        <input type='hidden' id="imagenactual" name="imagenactual" value="0">
                                        <input type='hidden' id="totalimagen" name="totalimagen" value="<?= $totalimagen ?>">
                                        <input type='hidden' id="idlote" name="idlote" value="<?= $idloteimagen ?>">
                                        <h4>Lote <?= $idloteimagen ?></h4>
                                        <ul class="pager">
                                            <li><div class='col-sm-3'>
                                                    <a href="javascript:;" id="anteriorDoc">

                                                        <img src="imagenes/navigation-left-button.png" class="img-thumbnail" alt="" width="50" height="60"/>

                                                    </a>
                                                </div>
                                            </li>
                                            <li><div class='col-sm-6'>
                                                    <?= $htmlDoc ?> 
                                                </div>
                                            </li>
                                            <li><div class='col-sm-3'>
                                                    <a href="javascript:;" id="siguienteDoc">

                                                        <img src="imagenes/navigation-right-button.png" class="img-thumbnail" alt="" width="50" height="60"/>
                                                    </a>
                                                </div></li>
                                        </ul>                                    



                                        <p>
                                            <?php include '../../libreria/general/vista/FormularioMetadato.php'; ?>
                                        </p>
                                    </div>
                                    <div id="divinfo" class="well">
                                        <p>INFO</p>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left"></div>
                                <div class="col-sm-6 text-left">


                                    <div class="col-sm-12 text-left"> 

                                        <ul class="pager">
                                            <li><div class='col-sm-4'>
                                                    <a href="javascript:;" id="anteriorImagen">
                                                        <img src="imagenes/navigation-left-button.png" class="img-thumbnail" alt="" width="50" height="60"/>
                                                        Anterior
                                                    </a>
                                                </div>
                                            </li>
                                            <li><div class='col-sm-4'>
                                                    <?= $htmlMenu ?> 
                                                </div>
                                            </li>
                                            <li><div class='col-sm-4'>
                                                    <a href="javascript:;" id="siguienteImagen">
                                                        Proximo
                                                        <img src="imagenes/navigation-right-button.png" class="img-thumbnail" alt="" width="50" height="60"/>
                                                    </a>
                                                </div></li>
                                        </ul>

                                        <img src="" id="imagenModal" alt="" class="img-thumbnail" style="zoom:0.60" width="99.6%" height="250" frameborder="0"/>


                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div id="formaisad" class="tab-pane fade ">
                        <div class="container">
                            <h2>Descripci&oacute;n Documental</h2>
                            <?php $s_idformulario = 2; ?>
                            <?php
                            if (isset($s_iddetalledocumento) &&
                                    trim($s_iddetalledocumento) != '') {
                                include '../../libreria/general/vista/FormularioMetadato.php';
                            }
                            ?>
                        </div>

                    </div>
                </div>
                <?php
                if ($s_salidaformulario[2]) {
                    //$objcargacmis->debug();

                    $objcargacmis->setEstadovalida(4);
                    $objcargacmis->CargaDocumento($s_iddetalledocumento);
                    $objcargacmis->registraControlMetadatos($s_iddetalledocumento);
                    //require_once '../../consolidacion/controlador/cargaXMLDocumento.php';
                }
                ?>
            <?php } ?>
 
        <?php require_once '../../plantilla/vista/piepagina.php'; ?>
    </body>
</html>