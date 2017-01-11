#!/bin/bash

FILES=$1
FINAL=$2
RAIZ=$(pwd)
echo "ls $FILES"
cd $FILES
date
mkdir -p /tmp/$FILES/temporal
#mogrify -format png *.tiff
#mogrify -format tiff *.png
rm *png
echo "mkdir -p $FILES/temporal"

for i in `ls *color`
do
convert -compress jpeg $i $i.tiff
rm $i
done

TOTAL=$(ls *tif *tiff *TIF *color|wc -l)

for i in `ls *TIF *tif *tiff *TIF `
do
$RAIZ"/./"hocrindividual.sh $FILES $i $TOTAL $FINAL &

echo $RAIZ"/./hocrindividual.sh $FILES $i $FINAL"
done
#pdftk temporal/*pdf  output salida.pdf
#echo "pdftk temporal/*pdf  output salida.pdf"
#date
