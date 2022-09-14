#!/bin/bash

#SOURCE=~/Desktop/ExhibitFactory/PDF_Squeezer/InputPDF_Documents
#WORKDIR=~/Desktop/ExhibitFactory/PDF_Squeezer/workdir
#PROCESSED=~/Desktop/ExhibitFactory/PDF_Squeezer/OutputPDF_Documents
#DIST=None

DIST=/var/www/html/public/uiodirs/fordistribution
SOURCE=/var/www/html/public/FDD_PDF_Tools/FDD_PDF_Squeezer/InputPDF_Documents
WORKDIR=/var/www/html/public/FDD_PDF_Tools/FDD_PDF_Squeezer/workdir
PROCESSED=/var/www/html/public/FDD_PDF_Tools/FDD_PDF_Squeezer/OutputPDF_Documents

shopt -s nullglob # Sets nullglob
for FILENAME in $SOURCE/*.{pdf,Pdf,PDf,PdF,pDf,PDF}; do
shopt -u nullglob # Unsets nullglob
	n1="${FILENAME##*/}" #bname
	distdirname="${n1%%_*}"	
	postdistname="${n1#*_}"
	bnwext=$(basename "$FILENAME")
	bnFILENAME=$(basename "${FILENAME%%.*}")
	current_time=$(($(date "+%Y%m%d%H%M%S%3N")))
	#hash attorneyusernumber and current_time to make unique file prepend
	uniquefilename="$1"_"$current_time"
  	#replace filename with uniquefile_JUNK.pdf
	cp "$FILENAME" "$WORKDIR"/"$uniquefilename"_JUNK.pdf
	#let ghostcript do it
	gs -dBATCH -dNOPAUSE -sDEVICE=pdfwrite -dPDFSETTINGS=/ebook -q -o "$WORKDIR"/"$uniquefilename"_comp_JUNK.pdf "$WORKDIR"/"$uniquefilename"_JUNK.pdf &> /dev/null
	#Now, clear the meta data of the pdf document
	exiftool -overwrite_original -m -q -all= "$WORKDIR"/"$uniquefilename"_comp_JUNK.pdf &> /dev/null
	#restore original metadata to the squeezed pdf document
	exiftool -overwrite_original -tagsFromFile "$FILENAME" "$WORKDIR"/"$uniquefilename"_comp_JUNK.pdf &> /dev/null
	#compare and keep the smaller file
	if [ $DIST = "None" ]
	then
	[ $(stat -c%s "$WORKDIR"/"$uniquefilename"_comp_JUNK.pdf) -ge $(stat -c%s "$FILENAME") ] && mv "$FILENAME" "/var/www/html/public/uiodirs/""$distdirname""/download/""$bnFILENAME"_FDDSQ.pdf || mv "$WORKDIR"/"$uniquefilename"_comp_JUNK.pdf "/var/www/html/public/uiodirs/""$distdirname""/download/""$bnFILENAME"_FDDSQ.pdf &> /dev/null
	else
	[ $(stat -c%s "$WORKDIR"/"$uniquefilename"_comp_JUNK.pdf) -ge $(stat -c%s "$FILENAME") ] && mv "$FILENAME" "/var/www/html/public/uiodirs/""$distdirname""/download/""$bnFILENAME"_FDDSQ.pdf || mv "$WORKDIR"/"$uniquefilename"_comp_JUNK.pdf "/var/www/html/public/uiodirs/""$distdirname""/download/""$bnFILENAME"_FDDSQ.pdf &> /dev/null
	fi

	#clear workdir of unique files associated with attorneyusernumber and current_time
	rm $WORKDIR/"$uniquefilename"_*
done

