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
 * Descripcion del codigo de gestionconfiguracion
 * 
 * @file gestionconfiguracion.php
 * @author Javier Lopez Martinez
 * @date 25/10/2016
 * @brief Contiene ...
 */
require_once '../../administracion/controlador/controlGestionConfiguracion.php';
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
        <?php require_once '../../plantilla/vista/menu.php'; ?>
        <div class="container">
            <h2>Gestion Configuraci&oacute;n</h2>
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#formulario">Formulario</a></li>
                <li><a data-toggle="pill" href="#listado">Listado</a></li>

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

                    <form class="form-horizontal" method="post">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Datos Generales</div>
                            <div class="panel-body">

                                <div class="form-group <?= $panelGeneral["errorConfiguracionHtml"] ?>">
                                    <?= $panelGeneral["nombreConfiguracionHtml"] ?>
                                </div>
                                <div class="form-group <?= $panelGeneral["errorCortoConfiguracionHtml"] ?>">
                                    <?= $panelGeneral["nombreCortoConfiguracionHtml"] ?>
                                </div>
                                <div class="form-group <?= $panelGeneral["errorestadoHtml"] ?>">        
                                    <?= $panelGeneral["nombreestadoHtml"] ?>
                                </div> 

                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">Opciones de Ejecucion</div>
                            <div class="panel-body">

                                <?php for ($i = 0; $i < count($panelOpcion["erroropcion"]); $i++) { ?>

                                    <div class="form-group <?= $panelOpcion["erroropcion"][$i] ?>">
                                        <?= $panelOpcion["opcionEscanerHtml"][$i] ?>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>
                        <div class="form-group">        
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" name="Enviar" id="Enviar" class="btn btn-default" value="1">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
           
            
                <div id="listado" class="tab-pane fade ">
                    <table id="tablaConfiguracion" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Nombre Corto</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>NombreCorto</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
        <?php require_once '../../plantilla/vista/piepagina.php'; ?>
    </body>
</html>