#!/bin/bash

inotifywait -m -e create -e moved_to -e attrib --format "%f" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Quick_CSSS_PDF" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Quick_CSSP_PDF" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_DB_CSSS_PDF" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_DB_CSSP_PDF" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Attorney_Self_DOC" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Attorney_Self_PDF" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Prospect_DOC" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Prospect_PDF" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_CoreCase_DOC" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_CoreCase_PDF" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_CoreCase_FamLaw_ALL_DOC" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_CoreCase_FamLaw_ALL_PDF" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_CoreCase_SR_DOC" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_CoreCase_SR_PDF" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Real_Estate_PDF" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Probate_DOC" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Probate_PDF" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_EstatesTrusts_DOC" "/var/www/html/public/LatchProcessing/LatchVotes/FDD_View_EstatesTrusts_PDF" \
     | while read FILENAME
                do
					(umask 000; touch /var/www/html/public/LatchProcessing/LatchTrigger/TriggerLatchProcessing.txt)
                done