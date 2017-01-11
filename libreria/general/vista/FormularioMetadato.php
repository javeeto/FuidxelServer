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
 * Descripcion del codigo de FormularioMetadato
 * 
 * @file FormularioMetadato.php
 * @author Javier Lopez Martinez
 * @date 14/11/2016
 * @brief Contiene ...
 */
require '../../libreria/general/controlador/controlGestionMetadato.php';
?>

<div id="formulario_f<?= $s_idformulario ?>" class="">

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
         <div class="panel-group" id="accordion<?= $s_idformulario ?>">
        <?php for ($ig = 0; $ig < count($datosgrupometadato); $ig++) { ?>
           
                <div class="panel panel-primary">
                    <div class="panel-heading">

                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion<?= $s_idformulario ?>" href="#collapse<?= $s_idformulario.$ig ?>">
                                <?= $datosgrupometadato[$ig]["nombregrupometadato"] ?>
                            </a>
                        </h4>



                    </div>
                    <div id="collapse<?= $s_idformulario.$ig ?>" class="panel-collapse collapse <?php if ($ig == 0) { ?> in <?php } ?>">
                        <div class="panel-body">

                            <?php for ($i = 0; $i < count($arrPanel[$ig]["errormetadato"]); $i++) { ?>

                                <div class="form-group <?= $arrPanel[$ig]["errormetadato"][$i] ?>">
                                    <?= $arrPanel[$ig]["opcionMetadato"][$i] ?>
                                </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>
           
        <?php } ?>
              </div>
        <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="enviar_f<?= $s_idformulario ?>" id="envia_f<?= $s_idformulario ?>" class="btn btn-default" value="1">Guardar</button>
            </div>
        </div>
    </form>
</div>