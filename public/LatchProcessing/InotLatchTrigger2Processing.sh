#!/bin/bash

inotifywait -m -e create -e moved_to --format "%f" "/var/www/html/public/LatchProcessing/LatchTrigger" \
     | while read FILENAME
                do
					soffice --nofirststartwizard --quickstart --nologo --headless --norestore --invisible "vnd.sun.star.script:Standard.Module1.FDD_LatchProcessing?language=Basic&location=application"
                done
