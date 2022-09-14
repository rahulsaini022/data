#!/bin/sh

#set some directories
#LOworkDIR="/var/www/html/public/LOworking/""$1"
PPinputDIR="/var/www/html/public/DOCPostProcess/Input/"
PPworkingDIR="/var/www/html/public/DOCPostProcess/Working/"
PPoutputDIR="/var/www/html/public/DOCPostProcess/Output/"


mv "$PPinputDIR"* "$PPworkingDIR"
chmod 777 "$PPworkingDIR"*

FILES="$PPworkingDIR"*.docx



for fpname in $FILES
do

/usr/bin/soffice -env:SingleAppInstance="false" -env:UserInstallation="file:///home/wbakerfdd/.config/libreoffice/4/user38" --nofirststartwizard --quickstart --nologo --headless --norestore --invisible "vnd.sun.star.script:Standard.Module1.PostprocDOC?language=Basic&location=application" "$fpname"
	n1="${fpname##*/}" #bname
	distdirname="${n1%%_*}"	
	postdistname="${n1#*_}" ; staplename="${postdistname%%_*}"
	mv "$fpname" "/var/www/html/public/uiodirs/""$distdirname""/download/""${n1#*_}"
done



rm /var/www/html/public/LatchProcessing/LatchVotes/PostprocDOCwaitdir/*
