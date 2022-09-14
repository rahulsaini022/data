#!/bin/bash

SOURCE=/var/www/html/public/StripPDFBlank/InputPDF_Documents
WORKDIR=/var/www/html/public/StripPDFBlank/workdir
PROCESSED=/var/www/html/public/StripPDFBlank/OutputPDF_Documents
DIST=/var/www/html/public/uiodirs/fordistribution

shopt -s nullglob # Sets nullglob
for FILENAME in $SOURCE/*.{pdf,Pdf,PDf,PdF,pDf,PDF}; do
shopt -u nullglob # Unsets nullglob
	bnwext=$(basename "$FILENAME") &> /dev/null
	bnFILENAME=$(basename "${FILENAME%%.*}") &> /dev/null
#	echo $bnFILENAME
	current_time=$(($(date "+%Y%m%d%H%M%S%3N"))) &> /dev/null
	#get number of pages
	numpages=$(strings < $""$SOURCE"/$(basename "$FILENAME")" | sed -n 's|.*/Count -\{0,1\}\([0-9]\{1,\}\).*|\1|p' | sort -rn | head -n 1) &> /dev/null
	#hash attorneyusernumber and current_time to make unique file prepend
	uniquefilename=$""$1"_"$current_time"" &> /dev/null
	#replace filename and put in workdir
	mv "$SOURCE"/"$bnwext" "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp.pdf &> /dev/null
	
#get last page
		qpdf "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp.pdf --pages "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp.pdf z -- "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp_LastPage.pdf
		#test of already just image - get text
		pdftotext "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp_LastPage.pdf "$WORKDIR"/"$uniquefilename"_"$bnwext"_FDD_TEMP_dummy0.txt &> /dev/null
#test for blankness only - less than 10 bytes
#	echo $(stat -c%s "$WORKDIR"/"$uniquefilename"_"$bnwext"_FDD_TEMP_dummy0.txt)
		if [[ $(stat -c%s "$WORKDIR"/"$uniquefilename"_"$bnwext"_FDD_TEMP_dummy0.txt) < 10 ]] 
		then 		qpdf "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp.pdf --pages "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp.pdf 1-r2 -- "$PROCESSED"/"$bnFILENAME"
		else mv "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp.pdf "$PROCESSED"/"$bnFILENAME"
		fi

	
done
	rm "$WORKDIR"/* "$SOURCE"/* &> /dev/null

mv "$PROCESSED"/* "$DIST"
