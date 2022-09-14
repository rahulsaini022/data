#!/bin/bash

TARGET1="/var/www/html/public/LatchProcessing/LatchVotes/QuickCSSP"

TARGET2="/var/www/html/public/LatchProcessing/LatchVotes/QuickCSSS"

TARGET3="/var/www/html/public/LatchProcessing/LatchVotes/FamLawPackages"

TARGET4="/var/www/html/public/LatchProcessing/LatchVotes/PleadingsMotions"

TARGET5="/var/www/html/public/LatchProcessing/LatchVotes/Forms"

TARGET6="/var/www/html/public/LatchProcessing/LatchVotes/RecordDocuments"



inotifywait -m -e create -e moved_to --format "%f" "$TARGET1" "$TARGET2"  "$TARGET3"  "$TARGET4"  "$TARGET5"  "$TARGET6" \

        | while read FILENAME

                do

(umask 000; touch /var/www/html/public/LatchProcessing/LatchTrigger/TriggerLatchProcessing.txt)

                done
