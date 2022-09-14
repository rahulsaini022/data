#!/bin/sh

TARGET="/var/www/html/public/uiodirs/fordistribution"
PROCESSED="/var/www/html/public/uiodirs"
FinDir="download"

inotifywait -m -e moved_to --format "%f" "$TARGET" \
        | while read FILENAME
                do
					[[ $FILENAME == Staple* ]] && mv "$TARGET/$FILENAME" /var/www/html/public/stapledirs/InputFiles/$FILENAME || mv "$TARGET/$FILENAME" "$PROCESSED/${FILENAME%%_*}/$FinDir/${FILENAME#*_}"
                done
