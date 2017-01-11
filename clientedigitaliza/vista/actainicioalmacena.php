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
require_once '../../clientedigitaliza/controlador/controlActaInicio.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php require_once '../../plantilla/vista/encabezado.php'; ?>
        <link rel="stylesheet" href="../../plantilla/vista/estiloplantilla.css" type="text/css">
        <script src="../../libreria/general/vista/DataTables/media/js/jquery.dataTables.js"></script>
        <link rel="stylesheet" href="../../libreria/general/vista/DataTables/media/css/jquery.dataTables.css" type="text/css">
        <script src="../../administracion/vista/js/tablaGestionConfiguracion.js"></script>
    </head>
    <body>
        <div class="container">
           <!-- <h2>Acta de inicio de almacenamiento de imagenes</h2>-->
           
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#formulario">Diligenciar Formulario</a></li>

            </ul>
            <div class="tab-content">
                <div id="formulario" class="tab-pane fade in active">

                    <?php if ($error) { ?>
                        <div class="alert alert-danger">
                            <strong>!</strong> <?= $mensajerror ?>
                        </div>
                    <?php } ?>
                    <?php if ($exitoso) { ?>
                        <div class="alert alert-success">
                            <strong>!</strong> <?= $mensajerror ?>
                        </div>
                    <?php } ?>

                    <form class="form-horizontal" method="post"  enctype="multipart/form-data" >
                        <div class="panel panel-primary">
                          <!--  <div class="panel-heading">Datos Generales</div>-->
                            <div class="panel-body">

                                <div class="form-group <?= $panelGeneral["errorEntidadHtml"] ?>">
                                    <?= $panelGeneral["nombreEntidadHtml"] ?>
                                </div>
                                <div class="form-group <?= $panelGeneral["errorLoteHtml"] ?>">
                                    <?= $panelGeneral["nombreLoteHtml"] ?>
                                </div>
                                <div class="form-group <?= $panelGeneral["errorDocumentoHtml"] ?>">        
                                    <?= $panelGeneral["nombreDocumentoHtml"] ?>
                                </div> 
                                <div class="form-group <?= $panelGeneral["errorCertificadoHtml"] ?>">        
                                    <?= $panelGeneral["nombreCertificadoHtml"] ?>
                                </div>                                 
                                <div class="form-group <?= $panelGeneral["errorConfiguracionHtml"] ?>">        
                                    <?= $panelGeneral["nombreConfiguracionHtml"] ?>
                                </div> 
                                <div class="form-group <?= $panelGeneral["errorFechaHtml"] ?>">        
                                    <?= $panelGeneral["nombreFechaHtml"] ?>
                                </div> 
                              
                            </div>
                        </div>

                        <div class="form-group">        
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" name="Enviar" id="Enviar" class="btn btn-default" value="1">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
           
            


        </div>
    </body>
</html>
