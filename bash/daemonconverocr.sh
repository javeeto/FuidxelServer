#!/bin/bash 
#/opt/fuixel/bash/daemonconverocr.sh /mnt/digitalizacion/convertocrin /mnt/digitalizacion/convertocrout /mnt/digitalizacion/convertocrtmp
dirin=$1
dirout=$2
dirtmp=$3
touch /tmp/coladeconversion.txt
touch /tmp/contadorprocesohocr.txt
touch /tmp/procesoconcurrente.txt

echo "1" > /tmp/coladeconversion.txt
echo "1" > /tmp/contadorprocesohocr.txt
echo "5" > /tmp/procesoconcurrente.txt


procesos=`cat /tmp/procesoconcurrente.txt`
contcola=`cat /tmp/coladeconversion.txt`
contproceso=`cat /tmp/contadorprocesohocr.txt`  

while [ $contcola -gt 0 ]; do

 #set -x
 #echo "Dentro de while"
 if [ -n "${contproceso}" ]; then
  if [ $contproceso -lt "$procesos" ]; then
  #set +x
    listapdf=$(ls $dirin/*pdf|tail -n 1)
    
      for ipdf in $listapdf
      do
       #contproceso=`cat /tmp/contadorprocesohocr.txt`
       #set -x
      # echo "Dentro de for"
       contproceso=`ps aux|grep convertocr|wc -l`
       echo if [ $contproceso -lt $procesos ] then
       
        if [ -n "${contproceso}" ]; then
	  if [ $contproceso -lt "$procesos" ]; then
	# echo "Entro o si"
	#set +x
	  
	  
	    archivo=`echo $ipdf|sed s/'.*\/'/""/g`
	    nomarch=`echo $archivo|sed s/'\.pdf$'/""/g`
	    mv $ipdf $3/
	    echo $ipdf $archivo $nomarch
	    echo convertocr $nomarch $dirtmp $dirout/$archivo
	    /opt/fuixel/bash/./convertocr.sh $nomarch $dirtmp $dirout/$archivo &
	  #  set -x
	    ((conteoproceso++))
	  #  set +x
	    #exit
	  #else    
	  
	  #  while [ $contproceso -ge "$procesos" ]; do
	  
	  #      contproceso=`cat /tmp/contadorprocesohocr.txt`
	  #  exit
	  #done
	  #conteoproceso=`echo $contproceso`
	  #else
	   #  break
	  fi
       #else
	#  break
       fi        
       
      done
      #contproceso=`cat /tmp/contadorprocesohocr.txt`
  fi
 fi
 contproceso=`ps aux|grep convertocr|wc -l`
 contcola=`cat /tmp/coladeconversion.txt`
done
