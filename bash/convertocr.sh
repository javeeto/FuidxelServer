#!/bin/bash

#Borra imagen sobrante extraida

function eliminaSobrante {

dirorigen=$1
dirdestino=$2
archivoori=$3

echo ENTRO A ELIMINA SOBRANTE 

rmimagen=`pdfimages -list $dirorigen/$archivoori.pdf|grep smask|awk '{print $2}'`
archivos=`ls -lu $dirdestino/*pdf |awk '{print $9}'`
conarchivo=0
    for iarchivo in $archivos
    do
        for irmimagen in $rmimagen
         do
            echo ENTRO A PREGUNTA
            echo if [ "$conarchivo" == "$irmimagen" ] then
              if [ "$conarchivo" == "$irmimagen" ]; then
                  echo ENTRO A BORRAR IMAGEN 
	          echo rm -f $iarchivo
	          rm -f $iarchivo
	        #  exit
	         
              fi
         done
         ((conarchivo++))    
    done

}

#Procesa documento reconoce ocr y lo integra en 
# el pdf
function individualHocr {


    imagen=$2
    FILE=$1
    FINAL=$4
    TOTAL=$3
    
   # local CONTADOR=0
    #cd /$FILE
    mkdir -p /tmp/$FILE/temporal
    echo "Processing image $imagen ..."
    tesseract $imagen /tmp/$FILE/temporal/$imagen.hocr -l spa hocr 
    echo "tesseract $imagen /tmp//$FILE/temporal/$imagen.hocr -l spa hocr"
    
    hocr2pdf -i $imagen -s -o /tmp/$FILE/temporal/$imagen.pdf < /tmp/$FILE/temporal/$imagen.hocr.hocr 
    echo "hocr2pdf -i $imagen -s -o /tmp/$FILE/temporal/$imagen.pdf < /tmp/$FILE/temporal/$imagen.hocr.html &>/dev/null"
    #/usr/local/bin/
    
    pdftk /tmp/$FILE/temporal/*pdf  output /tmp/$FILE/salida.pdf
    echo "pdftk /tmp/$FILE/temporal/*pdf  output /tmp/$FILE/salida.pdf"
    
    #echo "null" > /tmp/$FILE/temporal/contador.txt

  #  c=$CONTADOROCRENV
  #  ((c++))
   #  export CONTADOROCRENV=$c


    echo SALIDA DE CONTADOR /tmp/$FILE/temporal/contador.txt
    cat /tmp/$FILE/temporal/contador.txt
    CONTADOR=$(cat /tmp/$FILE/temporal/contador.txt)
    c=$CONTADOR
    ((c++))
    echo "$c" > /tmp/$FILE/temporal/contador.txt
    echo "echo $c > /tmp/$FILE/temporal/contador.txt"
    CONTADOR=$(cat /tmp/$FILE/temporal/contador.txt)
    
    

    echo "$CONTADOR == $TOTAL"
    if [ "$CONTADOR" == "$TOTAL" ]; then
    
      eliminaSobrante $dirorig /tmp/$FILE/temporal $archivoori
    
      pdftk /tmp/$FILE/temporal/*pdf  output /tmp/$FILE/salida.pdf

      cp /tmp/$FILE/salida.pdf $4
      echo "cp /tmp/$FILE/salida.pdf $4"
      chmod 777 $4
      CARPETA=$(pwd)
      cd ..
      rm -r $CARPETA
      rm -r /tmp/$FILE
      rm /tmp/$FILE/salida.pdf

      CONPROCESO=$(cat /tmp/contadorprocesohocr.txt)
      conp=$CONPROCESO
      ((conp--))
      echo "$conp" > /tmp/contadorprocesohocr.txt
      echo http://localhost/fuixel/clientedigitaliza/controlador/conviertePDFtoPDFA.php?ruta=$4 -O /tmp/conversionpdfa.txt
      wget http://localhost/fuixel/clientedigitaliza/controlador/conviertePDFtoPDFA.php?ruta=$4 -O /tmp/conversionpdfa.txt
      pdftk $4 output $4TMP.pdf 
      rm -f $4
      mv $4TMP.pdf $4

    fi

    date
}

#Archivo origen sin extension
archivoori=$1
#Directorio origen 
dirorig=$2
#directorio y archivo destino
dirarchivodest=$3

rutainicial=$(pwd)

CONTADOR=0

date

mkdir -p /tmp/conversionocr/$archivoori/temporal
touch /tmp/conversionocr/$archivoori/temporal/contador.txt
echo "0" > /tmp/conversionocr/$archivoori/temporal/contador.txt
echo SALIDA DE CONTADOR /tmp/conversionocr/$archivoori/temporal/contador.txt
cat /tmp/conversionocr/$archivoori/temporal/contador.txt

      CONPROCESO=$(cat /tmp/contadorprocesohocr.txt)
      conp=$CONPROCESO
      ((conp++))
      echo "$conp" > /tmp/contadorprocesohocr.txt

echo $archivoori $dirorig $dirarchivodest

mkdir -p /tmp/conversionocr/$archivoori
pdfimages  -q $dirorig/$archivoori.pdf /tmp/conversionocr/$archivoori/$archivoori

echo "pdfimages  -q " $dirorig/$archivoori.pdf /tmp/conversionocr/$archivoori/$archivoori
#eliminaSobrante $dirorig /tmp/conversionocr/$archivoori $archivoori

cd /tmp/conversionocr/$archivoori

TOTAL=$(ls *ppm *pbm|wc -l)
 
for i in `ls *ppm `
do
#       esjpeg=$(tiffinfo $imagen|grep JPEG |wc -l)
#       if [ $esjpeg -gt 0 ];     
#        then        
        convert $i $i.jpeg
        convert -quality 50  $i.jpeg $i.tiff
        rm $i $i.jpeg        
        individualHocr conversionocr/$archivoori $i.tiff $TOTAL $dirarchivodest 
        echo "individualHocr conversionocr/$archivoori $i.tiff $TOTAL $dirarchivodest & "
        
        
done 

for i in `ls *pbm `
do
        #else
        convert $i $i.bk.tiff
        tiffcp -c g4 $i.bk.tiff $i.tiff
        rm $i $i.bk.tiff      
        
        individualHocr conversionocr/$archivoori $i.tiff $TOTAL $dirarchivodest $dirorig
        echo "individualHocr conversionocr/$archivoori $i.tiff $TOTAL $dirarchivodest $dirorig & "
        
       #fi
done

