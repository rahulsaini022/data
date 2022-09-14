#!/bin/bash

touch /var/www/html/public/LatchProcessing/ExeStatus/testtrigstart.txt
[[ /var/www/html/public/LatchProcessing/LatchTrigger_cutoff/cutoff0.txt -ot /var/www/html/public/LatchProcessing/LatchTrigger/TriggerLatchProcessing.txt ]] && rm /var/www/html/public/LatchProcessing/LatchTrigger/TriggerLatchProcessing.txt
