#!/bin/bash

TARGET1="/var/www/html/public/LatchProcessing/LatchTrigger"

#PROCESSED="/common/common/Baker Fister LLC/FDDWebsite/Inotify/inotifytests/Download/"

inotifywait -m -e create -e moved_to --format "%f" "$TARGET1" \
        | while read FILENAME
                do

					#trigger omni macro in LO
						touch /var/www/html/public/LatchProcessing/testedgood.txt
					#soffice --nofirststartwizard --quickstart --nologo --headless --norestore --invisible "vnd.sun.star.script:Standard.Module1.FDD_LatchProcessing?language=Basic&location=application"
		
                        #echo parsing $FILENAME
                        
                        #TargetDirectory...
                       ## DISTDIRECTORY="${FILENAME%%_*}" #Get the distribute directory
                       ## tFILENAME="${FILENAME#*_}" #Get stripped filename with ext
                       ## tExtension="${tFILENAME##*.}" #Here's the extension
                       ## bnFILENAME="${tFILENAME%%.*}"	#Here's base file name
                       ## chmod 666 "$TARGET/$FILENAME" #open up the privs on the file
                       ## mv "$TARGET/$FILENAME" "$PROCESSED/$DISTDIRECTORY/$bnFILENAME"_`date +%m%d%y%H%M%S`.$tExtension;
                done

