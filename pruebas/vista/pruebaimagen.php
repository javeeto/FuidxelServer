<?php
require_once '../../satelite/controlador/EdicionImagen.php';
$pathOrigen="/srv/digitalizacion/batch0001/";
$file="imagen01.bmp";
$pathDestino="/srv/digitalizacion/batch0001/";
$newfile="imagen01.tiff";


$objimagen = new EdicionImagen($pathOrigen . $file);

                $objimagen->setRutaDestino($pathDestino . $newfile);
				$timeinicioimg=time();
				
                $objimagen->convertirTif();
				
				$timefinimg=time();
				$diftime=$timefinimg-$timeinicioimg;
				echo "<h1>De $pathOrigen . $file a $pathDestino . $newfile  en $diftime</h1>";
				
?>