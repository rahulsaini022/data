#!/bin/sh

TARGET="/var/www/html/public/uiodirs/fordistribution"
PROCESSED="/var/www/html/public/uiodirs"

inotifywait -m -e create -e moved_to --format "%f" "$TARGET" \
        | while read FILENAME
                do
                        #echo Detected $FILENAME, moving
                        #echo parsing $FILENAME
                        
                        #TargetDirectory...
                        FinDir="download"
                        DISTDIRECTORY="${FILENAME%%_*}" #Get the distribute directory
                        tFILENAME="${FILENAME#*_}" #Get stripped filename with ext
                        tExtension="${tFILENAME##*.}" #Here's the extension
                        bnFILENAME="${tFILENAME%%.*}"	#Here's base file name
                        chmod 666 "$TARGET/$FILENAME" #open up the privs on the file
                        # mv "$TARGET/$FILENAME" "$PROCESSED/$DISTDIRECTORY/$FinDir/$bnFILENAME"_`date +%m%d%y%H%M%S`.$tExtension;
mv "$TARGET/$FILENAME" "$PROCESSED/$DISTDIRECTORY/$FinDir/$bnFILENAME".$tExtension;
                done
