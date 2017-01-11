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
 * Descripcion del codigo de documentogrupoindexa
 * 
 * @file documentogrupoindexa.php
 * @author Javier Lopez Martinez
 * @date 8/11/2016
 * @brief Contiene ...
 */
require_once '../../consolidacion/controlador/controlGrupoIndexa.php';
?>
<!DOCTYPE html>
<html lang="es" >
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1"> 
        <meta  charset="ISO-8859-1">
        <?php require_once '../../plantilla/vista/encabezado.php'; ?>
        <link rel="stylesheet" href="../../plantilla/vista/css/estiloplantilla.css" type="text/css">
        <script src="../../libreria/general/vista/DataTables/media/js/jquery.dataTables.js"></script>
        <link rel="stylesheet" href="../../libreria/general/vista/DataTables/media/css/jquery.dataTables.css" type="text/css">
        <script src="../../clientedigitaliza/vista/js/tablaListaLote.js"></script> 
        <script src="../../consolidacion/vista/js/listaDocIndexa.js"></script> 
    </head>
    <body>
        <?php require_once '../../plantilla/vista/menu.php'; ?>
        <div class="container">
            <div class="col-sm-12"><br/></div>
            <div class="form-group">   
                <div class="col-sm-2">
                    <h4>LOTE No <?= $idloteimagen ?> </h4>
                </div>
                <div class="col-sm-10">

                    <button type="button" name="cerrarLote" id="cerrarLote" class="btn btn-default" value="1">Cerrar Lote</button>
                </div>
            </div>
            <div class="col-sm-12">
                <?php
                if (is_array($rutasminiatura)) {
                    foreach ($rutasminiatura as $i => $srcImagen) {
                        ?>
                        <div class="col-md-3 thumbnail" >
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;
                                <b> Documento <?= ($i + 1) ?></b><br/>
                                <?php for ($j = 0; $j < count($titulosgrupo[$i]); $j++) { ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <b><?= $titulosgrupo[$i][$j]["nombrecampo"] ?>:<?= $titulosgrupo[$i][$j]["valorcampo"] ?></b><br/>
                                <?php } ?>
                            </p>

                            <?php
                            if (!isset($titulosgrupo[$i][0]["valorcampo"]) &&
                                    trim($titulosgrupo[$i][0]["valorcampo"]) == '') {
                                ?>
                                <a href="../../consolidacion/vista/formaindexaimagen.php?idocumento=<?= $i ?>&idloteimagen=<?= $idloteimagen ?>" id="img<?= $i ?>" onclick="verImagen(this, '<?= $i ?>');" >    
                                <?php } ?>
                                <img src="../../consolidacion/controlador/mostrarImagen.php?idimagen=<?= $i ?>"  id="imgsrc<?= $i ?>" alt="Imagen <?= ($i + 1) ?>" style="width:180px;height:230px">
                                <?php
                                if (!isset($titulosgrupo[$i][0]["valorcampo"]) &&
                                        trim($titulosgrupo[$i][0]["valorcampo"]) == '') {
                                    ?>
                                </a>
                            <?php } ?>

                        </div>
                        <?php
                    }
                }
                ?>
            </div>


        </div>


        <div class="modal fade" id="modalFrame" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" onclick="" >&times;</button>
                        <h4 class="modal-title">Acta de finalizacion de almacenamiento de imagenes</h4>
                    </div>
                    <form class="form-horizontal" method="post"  enctype="multipart/form-data">
                          <div class="modal-body">

                            <?php require_once '../../consolidacion/vista/formaactafinalalmacena.php'; ?>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="Enviar" id="Enviar"  class="btn btn-default"   >Guardar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"  onclick="" >Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>   


        <?php require_once '../../plantilla/vista/piepagina.php'; ?>
    </body>
</html>