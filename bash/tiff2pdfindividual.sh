i#!/bin/bash
RUTARAIZ=$1
cd $RUTARAIZ


for i in *`ls *tif *tiff *TIF`
do

       # TAMANOTIF=$(stat --printf="%s" $i)
       # if [ $TAMANOTIF -gt 200000 ];
       TAMANOTIF=$(tiffinfo $i|grep JPEG |wc -l)
       if [ $TAMANOTIF -gt 0 ];     
        then
          convert -compress JPEG $i $i.pdf
       else
	  tiff2pdf $i -o $i.pdf
	  TAMANO=$(stat --printf="%s" $i.pdf)
	  if [ $TAMANO -gt 1000 ];
	  then
		  echo "tiff2pdf $i -o $i.pdf"            
	  else
		  convert $i $i.pdf
		  echo  "convert $i $i.pdf"
	  fi
       fi 
       
       #TAMANOTIF=$(tiffinfo $i|grep LZW |wc -l)
       #if [ $TAMANOTIF -gt 0 ];     
       # then
       #   convert -compress JPEG $i $i.pdf
       #fi
done
for i in `ls *color*tiff`
do
                 convert -compress JPEG $i $i.pdf
                 echo  "convert -compress JPEG  $i $i.pdf"

done

pdftk *pdf  output salida.pdf
