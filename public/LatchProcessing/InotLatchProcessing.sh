#!/bin/bash

TARGET1="/var/www/html/public/LatchProcessing/LatchVotes/QuickCSSP"
TARGET2="/var/www/html/public/LatchProcessing/LatchVotes/QuickCSSS"
TARGET3="/var/www/html/public/LatchProcessing/LatchVotes/FamLawPackages"
TARGET4="/var/www/html/public/LatchProcessing/LatchVotes/PleadingsMotions"
TARGET5="/var/www/html/public/LatchProcessing/LatchVotes/Forms"
TARGET6="/var/www/html/public/LatchProcessing/LatchVotes/RecordDocuments"
#PROCESSED="/common/common/Baker Fister LLC/FDDWebsite/Inotify/inotifytests/Download/"

inotifywait -m -e create -e moved_to --format "%f" "$TARGET1" "$TARGET2"  "$TARGET3"  "$TARGET4"  "$TARGET5"  "$TARGET6" \
        | while read FILENAME
                do

					#touch /var/www/html/public/LatchProcessing/LatchTrigger/TriggerLatchProcessing.txt
					#sudo chown wbaker:wbaker /var/www/html/public/LatchProcessing/LatchTrigger/TriggerLatchProcessing.txt
					(umask 000; touch /var/www/html/public/LatchProcessing/LatchTrigger/TriggerLatchProcessing.txt)
                        #echo parsing $FILENAME
                        
                        #TargetDirectory...
                       ## DISTDIRECTORY="${FILENAME%%_*}" #Get the distribute directory
                       ## tFILENAME="${FILENAME#*_}" #Get stripped filename with ext
                       ## tExtension="${tFILENAME##*.}" #Here's the extension
                       ## bnFILENAME="${tFILENAME%%.*}"	#Here's base file name
                       ## chmod 666 "$TARGET/$FILENAME" #open up the privs on the file
                       ## mv "$TARGET/$FILENAME" "$PROCESSED/$DISTDIRECTORY/$bnFILENAME"_`date +%m%d%y%H%M%S`.$tExtension;
                done

