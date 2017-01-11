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
 * Descripcion del codigo de digitalizacion
 * 
 * @file digitalizacion.php
 * @author Javier Lopez Martinez
 * @date 27/09/2016
 * @brief Contiene ...
 */
require_once '../../satelite/controlador/controlDigitalizacion.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php require_once '../../plantilla/vista/encabezado.php'; ?>
        <link rel="stylesheet" href="../../plantilla/vista/css/estiloplantilla.css" type="text/css">
        <script src="js/herramientasDigitaliza.js"></script>
        <script src="js/edicionImagen.js"></script>


    </head>
    <body>
        <?php if ($error) { ?>
            <div class="alert alert-danger">
                <strong>!</strong> <?= $mensajerror ?>
            </div>
        <?php } else { ?>
            <div class="container-fluid text-center">    
                <div class="row content">
                    <div class="col-sm-2 sidenav">
                        <div class="well">

                            <input type='hidden' id="lote" name="lote" value="<?= $idlotesesion ?>">
                            

                            <pre><h4><div class="label label-default" id="nolote">Lote #<?= $idlotesesion != 0 ? $idlotesesion : ""; ?></span></h4></pre>
                            <pre><?= $htmConfiguracion ?></pre>
                            <p>
                                <a href="#ejecutaEscaneo" id="ejecutaEscaneo" data-toggle="tooltip" data-placement="top" title="Iniciar escaneo"> 
                                    <img src="imagenes/button-play.png" class="img-thumbnail" alt="" width="50" height="60"/>
                                </a>
                                <a href="#" data-toggle="tooltip" data-placement="right" title="Eliminar imagenes seleccionadas">
                                    <img src="imagenes/bin.png" class="img-thumbnail"  alt="" width="50" height="60"/><!---->
                                </a>
                                <a href="javascript:;" id="separaImagen" data-toggle="tooltip" data-placement="bottom" title="Dividir documentos despues de imagenes seleccionadas">
                                    <img src="imagenes/documents.png" class="img-thumbnail" alt=""  width="50" height="60"/><!---->
                                </a>
                                <a href="#transferir" id="transferir" data-toggle="tooltip" data-placement="right" title="Guardar imagenes digitalizadas">
                                    <img src="imagenes/hard-drive-download.png" alt="" class="img-thumbnail" width="50" height="60"/><!---->
                                </a>
                            </p>
                        </div>
                        <div id="divinfo" class="well">
                            <p>INFO</p>
                        </div>
                    </div>
                    <div class="col-sm-10 text-left"> 
                        <div id="formaimagenes"  class="row">


                        </div>
                    </div>

                </div>
            </div>

            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Modal Header</h4>
                        </div>
                        <div class="modal-body">

                            <img src="" id="imagenModal" alt="" class="img-thumbnail" style="zoom:0.60" width="99.6%" height="250" frameborder="0"/>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal fade" id="modalFrame" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" onclick="continuaEscaneo();" >&times;</button>
                            <h4 class="modal-title">Acta de inicio de almacenamiento de imagenes</h4>
                        </div>
                        <div class="modal-body">

                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe id="frameacta" class="embed-responsive-item" src="" allowfullscreen=""></iframe>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"  onclick="continuaEscaneo();" >Close</button>
                        </div>
                    </div>

                </div>
            </div>        

        <?php } ?>
    </body>
</html>