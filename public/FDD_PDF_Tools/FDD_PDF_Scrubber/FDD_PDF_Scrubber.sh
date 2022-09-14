#!/bin/bash

#SOURCE=~/Desktop/ExhibitFactory/PDF_Scrubber/InputPDF_Documents
#WORKDIR=~/Desktop/ExhibitFactory/PDF_Scrubber/workdir
#PROCESSED=~/Desktop/ExhibitFactory/PDF_Scrubber/OutputPDF_Documents
#DIST=None

DIST=/var/www/html/public/uiodirs/fordistribution
SOURCE=/var/www/html/public/FDD_PDF_Tools/FDD_PDF_Scrubber/InputPDF_Documents
WORKDIR=/var/www/html/public/FDD_PDF_Tools/FDD_PDF_Scrubber/workdir
PROCESSED=/var/www/html/public/FDD_PDF_Tools/FDD_PDF_Scrubber/OutputPDF_Documents

shopt -s nullglob # Sets nullglob
for FILENAME in $SOURCE/*.{pdf,Pdf,PDf,PdF,pDf,PDF}; do
shopt -u nullglob # Unsets nullglob
	n1="${FILENAME##*/}" #bname
	distdirname="${n1%%_*}"	
	postdistname="${n1#*_}"
	bnwext=$(basename "$FILENAME") &> /dev/null
	bnFILENAME=$(basename "${FILENAME%%.*}") &> /dev/null
	current_time=$(($(date "+%Y%m%d%H%M%S%3N"))) &> /dev/null
	#get number of pages
	numpages=$(strings < $""$SOURCE"/$(basename "$FILENAME")" | sed -n 's|.*/Count -\{0,1\}\([0-9]\{1,\}\).*|\1|p' | sort -rn | head -n 1) &> /dev/null
	#hash attorneyusernumber and current_time to make unique file prepend
	uniquefilename=$""$1"_"$current_time"" &> /dev/null
	#replace filename
	mv "$SOURCE"/"$bnwext" "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp.pdf &> /dev/null
#first find if this is simply an image with ocr
		#uncompress the pdf file in the WORKDIR
		qpdf --qdf --object-streams=disable --coalesce-contents "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp.pdf "$WORKDIR"/"$uniquefilename"_FDD_TEMP_uncomp.qdf &> /dev/null
		#test of already just image - get text
		pdftotext "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp.pdf "$WORKDIR"/"$uniquefilename"_"$bnwext"_FDD_TEMP_dummy0.txt &> /dev/null
		#remove 3 Tr (invisible text) with sed
		sed -i -e '/3 Tr/,/ET/d' -e '/BaseFont/d' -e '/Tz(/d' -e '/Tm(/d' "$WORKDIR"/"$uniquefilename"_FDD_TEMP_uncomp.qdf &> /dev/null
		#compress the pdf
		qpdf --linearize --object-streams=generate "$WORKDIR"/"$uniquefilename"_FDD_TEMP_uncomp.qdf "$WORKDIR"/"$uniquefilename"_1_"$bnwext" &> /dev/null
		#get text
		pdftotext "$WORKDIR"/"$uniquefilename"_1_"$bnwext" "$WORKDIR"/"$uniquefilename"_"$bnwext"_FDD_TEMP_dummy1.txt &> /dev/null
		cp "$WORKDIR"/"$uniquefilename"_"$bnwext"_FDD_TEMP_dummy1.txt "$WORKDIR"/"$uniquefilename"_"$bnwext"_FDD_TEMP_dummy2.txt &> /dev/null
		#sed to remove ctrl-ls
		sed -i -e 's/\f//g' "$WORKDIR"/"$uniquefilename"_"$bnwext"_FDD_TEMP_dummy2.txt &> /dev/null
#test for image only, image + ocr, others
		if [[ $(stat -c%s "$WORKDIR"/"$uniquefilename"_"$bnwext"_FDD_TEMP_dummy2.txt) -eq "0" ]] && [[ $(stat -c%s "$WORKDIR"/"$uniquefilename"_"$bnwext"_FDD_TEMP_dummy0.txt) -gt "5" ]]
			then
			#no squeezing needed
			#clear metadata
			exiftool -overwrite_original -m -q -all= "$WORKDIR"/"$uniquefilename"_1_"$bnwext" &> /dev/null
			#replace metadata
			exiftool -overwrite_original -tagsFromFile "$FILENAME" "$WORKDIR"/"$uniquefilename"_1_"$bnwext" &> /dev/null
				if [ $DIST != "None" ]
					then
					mv "$WORKDIR"/"$uniquefilename"_1_"$bnwext" "/var/www/html/public/uiodirs/""$distdirname""/download/""$bnFILENAME"_FDDSC.pdf &> /dev/null
					else
					mv "$WORKDIR"/"$uniquefilename"_1_"$bnwext" "$PROCESSED"/"$bnwext" &> /dev/null
				fi			
			else
			#squeezing needed
			#create a default print of the pdf, this will preserve vector text which will be removed next
			gs -dBATCH -dNOPAUSE -sDEVICE=pdfwrite -dPDFSETTINGS=/ebook -q -o "$WORKDIR"/"$uniquefilename"_GS_"$bnwext" "$WORKDIR"/"$uniquefilename"_FDD_TEMP_comp.pdf &> /dev/null
			#break into jpegs with desired resolution (dpi) prepending with JUNK 
			pdftoppm -r 300 -jpeg "$WORKDIR"/"$uniquefilename"_GS_"$bnwext" "$WORKDIR"/JUNK_"$uniquefilename" &> /dev/null
			#take jpegs back into to a pdf document
			img2pdf $(find "$WORKDIR" -iname "JUNK_"$uniquefilename"*" | sort -V) -o $""$WORKDIR"/"$uniquefilename"_2_$(basename "$FILENAME")"  &> /dev/null
##			convert "$WORKDIR"/"JUNK_"$uniquefilename"*" "$WORKDIR"/"$uniquefilename"_$(basename "$FILENAME") &> /dev/null #flatten option with white background
			#rename file for compression or squeezing
			mv "$WORKDIR"/"$uniquefilename"_2_"$bnwext" "$WORKDIR"/"$uniquefilename"_2_"$bnwext"_comp_JUNK &> /dev/null
			#let ghostcript clean up img2pdf product
			gs -dBATCH -dNOPAUSE -sDEVICE=pdfwrite -dPDFSETTINGS=/ebook -q -o "$WORKDIR"/"$uniquefilename"_2_"$bnwext" "$WORKDIR"/"$uniquefilename"_2_"$bnwext"_comp_JUNK &> /dev/null
			#clear metadata
			exiftool -overwrite_original -m -q -all= "$WORKDIR"/"$uniquefilename"_2_"$bnwext" &> /dev/null #candidate 1
			#replace metadata
			exiftool -overwrite_original -tagsFromFile "$FILENAME" "$WORKDIR"/"$uniquefilename"_2_"$bnwext" &> /dev/null
				if [ $DIST != "None" ]
					then
					mv "$WORKDIR"/"$uniquefilename"_2_"$bnwext" "/var/www/html/public/uiodirs/""$distdirname""/download/""$bnFILENAME"_FDDSC.pdf &> /dev/null
					else
					mv "$WORKDIR"/"$uniquefilename"_2_"$bnwext" "$PROCESSED"/"$bnwext" &> /dev/null
				fi
		fi
	rm "$WORKDIR"/"$uniquefilename"* "$WORKDIR"/JUNK_"$uniquefilename"* &> /dev/null
	
done
