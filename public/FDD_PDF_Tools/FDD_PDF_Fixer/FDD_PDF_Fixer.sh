#!/bin/bash

#SOURCE=~/Desktop/ExhibitFactory/PDF_Fixer/InputPDF_Documents
#WORKDIR=~/Desktop/ExhibitFactory/PDF_Fixer/workdir
#PROCESSED=~/Desktop/ExhibitFactory/PDF_Fixer/OutputPDF_Documents
#DIST=None

DIST=/var/www/html/public/uiodirs/fordistribution
SOURCE=/var/www/html/public/FDD_PDF_Tools/FDD_PDF_Fixer/InputPDF_Documents
WORKDIR=/var/www/html/public/FDD_PDF_Tools/FDD_PDF_Fixer/workdir
PROCESSED=/var/www/html/public/FDD_PDF_Tools/FDD_PDF_Fixer/OutputPDF_Documents

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
		#replace filename
		mv "$SOURCE"/"$bnwext" "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp.pdf
		#uncompress the pdf file in the WORKDIR
		qpdf --qdf --object-streams=disable --coalesce-contents "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp.pdf "$WORKDIR"/"$uniquefilename"_FDD_TEMP_uncomp.qdf &> /dev/null
		#compress the pdf
		qpdf --linearize --object-streams=generate "$WORKDIR"/"$uniquefilename"_FDD_TEMP_uncomp.qdf "$WORKDIR"/"$uniquefilename"_FDD_TEMP_compLIN.pdf  &> /dev/null
		#hit again with gs
		gs -dBATCH -dNOPAUSE -sDEVICE=pdfwrite -q -o "$WORKDIR"/"$uniquefilename"_"$bnwext"_comp_postGS.pdf "$WORKDIR"/"$uniquefilename"_FDD_TEMP_compLIN.pdf &> /dev/null
		#fix meta data moving to processed
if [ $DIST != "None" ]
	then
			mv "$WORKDIR"/"$uniquefilename"_"$bnwext"_comp_postGS.pdf "$WORKDIR"/"$uniquefilename"_"$bnwext"
			#clear metadata
			exiftool -overwrite_original -m -q -all= "$WORKDIR"/"$uniquefilename"_"$bnwext" &> /dev/null #candidate 1
			#replace metadata
			exiftool -overwrite_original -tagsFromFile "$FILENAME" "$WORKDIR"/"$uniquefilename"_"$bnwext" &> /dev/null
			mv "$WORKDIR"/"$uniquefilename"_"$bnwext" "/var/www/html/public/uiodirs/""$distdirname""/download/""$bnFILENAME"_FDDFX.pdf
	else
			mv "$WORKDIR"/"$uniquefilename"_"$bnwext"_comp_postGS.pdf "$WORKDIR"/"$bnwext"
			#clear metadata
			exiftool -overwrite_original -m -q -all= "$WORKDIR"/"$bnwext" &> /dev/null #candidate 1
			#replace metadata
			exiftool -overwrite_original -tagsFromFile "$FILENAME" "$WORKDIR"/"$bnwext" &> /dev/null
			mv "$WORKDIR"/"$bnwext" "/var/www/html/public/uiodirs/""$distdirname""/download/""$bnFILENAME"_FDDFX.pdf
fi	
		#cleanup workdir
		rm "$WORKDIR"/"$uniquefilename"*
done
	
