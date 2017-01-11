#!/bin/bash
i=$2
FILE=$1
FINAL=$4
TOTAL=$3
#cd $FILE
 echo "Processing image $i ..."
tesseract $i /tmp$FILE/temporal/$i.hocr -l spa hocr 
echo "tesseract $i /tmp$FILE/temporal/$i.hocr -l spa hocr"
 /usr/local/bin/hocr2pdf -i $i -s -o /tmp$FILE/temporal/$i.pdf < /tmp$FILE/temporal/$i.hocr.html 
 echo "hocr2pdf -i $i -s -o /tmp$FILE/temporal/$i.pdf < /tmp$FILE/temporal/$i.hocr.html &>/dev/null"
pdftk /tmp$FILE/temporal/*pdf  output /tmp$FILE/salida.pdf
echo "pdftk /tmp$FILE/temporal/*pdf  output /tmp$FILE/salida.pdf"
CONTADOR=$(cat /tmp$FILE/temporal/contador.txt)
echo "null" > /tmp$FILE/temporal/contador.txt
c=$CONTADOR
((c=c+1))
echo $c > /tmp$FILE/temporal/contador.txt
echo "echo $c > /tmp$FILE/temporal/contador.txt"
CONTADOR=$(cat /tmp$FILE/temporal/contador.txt)

echo "$CONTADOR == $TOTAL"
if [ "$CONTADOR" == "$TOTAL" ]; then

cp /tmp$FILE/salida.pdf $4
echo "cp /tmp$FILE/salida.pdf $4"
chmod 777 $4
CARPETA=$(pwd)
cd ..
rm -r $CARPETA
rm -r /tmp$FILE/temporal
rm /tmp$FILE/salida.pdf

CONPROCESO=$(cat /tmp/contadorprocesohocr.txt)
conp=$CONPROCESO
((conp--))
echo "$conp" > /tmp/contadorprocesohocr.txt

fi

date
