#!/bin/sh

stapletarget="/var/www/html/public/stapledirs/InputFiles"
workingdir="/var/www/html/public/stapledirs/stapleworking"
processeddir="/var/www/html/public/uiodirs/fordistribution"
#FinDir="download"

inotifywait -m -e moved_to --format "%f" "$stapletarget" \
        | while read FILENAME
                do
						[[ $FILENAME == StapleFamLawQ* ]] && pdfunite "$stapletarget/$FILENAME" "$stapletarget"/StaplePacks/FamLawQ/FamLawQ_Back.pdf "$workingdir/${FILENAME#*_}" && rm "$stapletarget/$FILENAME" && mv "$workingdir/${FILENAME#*_}" "$processeddir/${FILENAME#*_}"
						[[ $FILENAME == StapleIntakeQ* ]] && pdfunite "$stapletarget/$FILENAME" "$stapletarget"/StaplePacks/IntakeQ/IntakeQ_Back.pdf "$workingdir/${FILENAME#*_}" && rm "$stapletarget/$FILENAME" && mv "$workingdir/${FILENAME#*_}" "$processeddir/${FILENAME#*_}"
						[[ $FILENAME == StapleWitnessQ* ]] && pdfunite "$stapletarget/$FILENAME" "$stapletarget"/StaplePacks/WitnessQ/WitnessQ_Back.pdf "$workingdir/${FILENAME#*_}" && rm "$stapletarget/$FILENAME" && mv "$workingdir/${FILENAME#*_}" "$processeddir/${FILENAME#*_}"


                done
