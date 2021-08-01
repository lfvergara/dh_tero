#!/bin/bash

NIS=$1
CANTIDAD=$2 
for (( i=0; i<$CANTIDAD; i++ ))
do
   php debug.php nis $NIS
done
