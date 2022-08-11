#!/usr/bin/env bash

##script to install latch processing in AWS Ubuntu Environments

##final file owner
fileowner=wbaker:wbaker

##basic directories
topdir=/var/www/html/public/LatchProcessing
#topdir=~/junktest/LatchProcessing
latchvotedir=/var/www/html/public/LatchProcessing/LatchVotes
#latchvotedir=~/junktest/LatchProcessing/LatchVotes
latchtriggerdir=/var/www/html/public/LatchProcessing/LatchTrigger
#latchtriggerdir=~/junktest/LatchProcessing/LatchTrigger

##systemd/system for service files locations
sysddir=/etc/systemd/system

##create basic directories if they don't already exist
if [ ! -d $latchvotedir ]; then
  mkdir -p $latchvotedir;
fi
if [ ! -d $latchtriggerdir ]; then
  mkdir -p $latchtriggerdir;
fi

## Declare an array of string of Latch Voting directory names to be used for voting and cutoffs
declare -a StringArray=("FDD_View_Quick_CSSS_PDF" "FDD_View_Quick_CSSP_PDF" "FDD_View_DB_CSSS_PDF" "FDD_View_DB_CSSP_PDF" "FDD_View_Attorney_Self_DOC" "FDD_View_Attorney_Self_PDF" "FDD_View_Prospect_DOC" "FDD_View_Prospect_PDF" "FDD_View_CoreCase_DOC" "FDD_View_CoreCase_PDF" "FDD_View_CoreCase_FamLaw_ALL_DOC" "FDD_View_CoreCase_FamLaw_ALL_PDF" "FDD_View_CoreCase_SR_DOC" "FDD_View_CoreCase_SR_PDF" "FDD_View_Real_Estate_PDF" "FDD_View_Probate_DOC" "FDD_View_Probate_PDF" "FDD_View_EstatesTrusts_DOC" "FDD_View_EstatesTrusts_PDF")

# Iterate the string array using for loop to create voting directories (and, maybe, corresponding cutoffs)
for val in ${StringArray[@]}; do
  
  ##concot inotify watch directories
  watchdirs=${watchdirs}" "\"$"$latchvotedir"/"$val"\"
  
  ##create latch voting directories if they don't already exist
  if [ ! -d "$latchvotedir"/"$val" ]; then
      echo "$latchvotedir"/"$val"
    mkdir -p "$latchvotedir"/"$val";
  fi
#    echo "$latchvotedir"/"$val"
   ###create latch voting cutoff directories if they don't already exist
  #if [ ! -d "$latchvotedir"/"$val""_cutoff" ]; then
    #mkdir -p "$latchvotedir"/"$val""_cutoff";
  #fi
done

##create latch processing trigger cutoff directory if it doesn't already exist
  if [ ! -d "$latchtriggerdir""_cutoff" ]; then
    mkdir -p "$latchtriggerdir""_cutoff";
  fi

##recursively fix ownership and permissions
chown -R $fileowner $latchvotedir
chown -R $fileowner $latchtriggerdir
chmod -R 775 $latchvotedir
chmod -R 775 $latchtriggerdir



############################################Create InotLatchVote2Trigger.sh##################################
##watches voting directories and promotes to latch processing trigger
echo "#!/bin/bash
">"$topdir"/InotLatchVote2Trigger.sh

##create watch directories for inotifywait and create the shell script
echo "inotifywait -m -e create -e moved_to -e attrib --format \"%f\"" $watchdirs" \\">>"$topdir"/InotLatchVote2Trigger.sh

echo  "     | while read FILENAME
                do
					(umask 000; touch $latchtriggerdir/TriggerLatchProcessing.txt)
                done">>"$topdir"/InotLatchVote2Trigger.sh
##chown, chmod, set privs to execute
chown $fileowner "$topdir"/InotLatchVote2Trigger.sh
chmod 777 "$topdir"/InotLatchVote2Trigger.sh
############################################InotLatchVote2Trigger.sh##################################




############################################Create InotLatchTrigger2Processing.sh##################################
#watches latch processing trigger directory and invokes Latch Processing!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
echo "#!/bin/bash
">"$topdir"/InotLatchTrigger2Processing.sh

##create watch directories for inotifywait and create the shell script
echo "inotifywait -m -e create -e moved_to --format \"%f\" \"$latchtriggerdir\" \\">>"$topdir"/InotLatchTrigger2Processing.sh

echo  "     | while read FILENAME
                do
					$topdir/LatchProcessing.sh
                done">>"$topdir"/InotLatchTrigger2Processing.sh
##chown, chmod, set privs to execute
chown $fileowner "$topdir"/InotLatchTrigger2Processing.sh
chmod 777 "$topdir"/InotLatchTrigger2Processing.sh
#
############################################InotLatchTriggering.sh##################################





############################################Create LatchProcessing.sh##################################
echo "#!/bin/bash
">"$topdir"/LatchProcessing.sh
echo "soffice --nofirststartwizard --quickstart --nologo --headless --norestore --invisible \"vnd.sun.star.script:Standard.Module1.FDD_LatchProcessing?language=Basic&location=application\"">>"$topdir"/LatchProcessing.sh
##chown, chmod, set privs to execute
chown $fileowner "$topdir"/LatchProcessing.sh
chmod 777 "$topdir"/LatchProcessing.sh
############################################LatchProcessing.sh##################################




############################################Create testtrigger.sh##################################
echo "#!/bin/bash
">"$topdir"/testtrigger.sh
echo "if [ /var/www/html/public/LatchProcessing/LatchTrigger/TriggerLatchProcessing.txt -ot /var/www/html/public/LatchProcessing/LatchTrigger_cutoff/cutoff0.txt ]; then
    rm /var/www/html/public/LatchProcessing/LatchTrigger/TriggerLatchProcessing.txt;
fi">>"$topdir"/LatchProcessing.sh
##chown, chmod, set privs to execute
chown $fileowner "$topdir"/testtrigger.sh
chmod 777 "$topdir"/testtrigger.sh
############################################testtrigger.sh##################################







####create service files for Latch Processing if they don't already exist
##if [ ! -f $sysddir/fddvote.service ]
##then
##echo $sysddir/fddvote.service
    ##echo "[Unit]
##After=mariadb.service

##[Service]
##ExecStart=${topdir}/InotLatchVote2Trigger.sh

##[Install]
##WantedBy=default.target" > /home/wbaker/junktest/fddvote.service
###WantedBy=default.target" > ${sysddir}/fddvote.service
###chown root:root ${sysddir}/fddvote.service
###chmod 644 ${sysddir}/fddvote.service
##systemctl enable fddvote.service
##fi

##if [ ! -f $sysddir/fddlatch.service ]
##then
##echo $sysddir/fddlatch.service
    ##echo "[Unit]
##After=mariadb.service

##[Service]
##ExecStart=${topdir}/InotLatchTrigger2Processing.sh

##[Install]
##WantedBy=default.target" > /home/wbaker/junktest/fddlatch.service
###WantedBy=default.target" > ${sysddir}/fddlatch.service
###chown root:root ${sysddir}/fddlatch.service
###chmod 644 ${sysddir}/fddlatch.service
##systemctl enable fddlatch.service
##fi

##systemctl daemon-reload fddvote.service
##systemctl daemon-reload fddlatch.service
####



###sleep 15
