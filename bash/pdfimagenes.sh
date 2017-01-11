#!/bin/bash
RUTA=$2
FILE=$1
RAIZ=$(pwd)
mkdir "$RUTA/$FILE"

#pdftoppm -tiff -tiffcompression lzw  $RUTA/$FILE.pdf $RUTA/$FILE/$FILE
echo "0" > $RUTA/$FILE/contador.txt
$RAIZ/./conversionhocr.sh $RUTA/$FILE  $RUTA/$FILE-ocr.pdf

echo "$RAIZ/./conversionhocr.sh $RUTA/$FILE  $RUTA/$FILE-ocr.pdf"

