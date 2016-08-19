#!/bin/bash

clear

date +"%m/%d/%Y %H:%M:%S ------------------------------------------------" >> gcs_error.log
date +"%m/%d/%Y %H:%M:%S ------------------------------------------------" >> gcs_success.log

re='^[0-9]+$'
last_id=0
error=1
success=0
fails=0

while read line
do
    if [[ $line =~ $re ]]
    then
        if [ $error -eq 0 ] 
        then
            msg="$(app/console abo:image:remove $last_id)"
            if [[ $msg =~ '^Error' ]]
            then
                echo "$msg" >> gcs_error.log
            else
                [ -f ./web/$msg ] && sudo -u www-data rm ./web/$msg || echo "/web/$msg does not exist, or can't be deleted, image id = $last_id" >> gcs_error.log
            fi
        fi
        last_id=$line
        error=0
    else
        if [ $error -eq 0 ]
        then
            if ! gsutil -q -h Cache-Control:public,max-age=2592000 cp ./web$line gs://mtbucket$line 
            then
                echo "image id = $last_id, failure: $?" >> gcs_error.log
                error=1
                ((fails++))
            else
                ((success++))
            fi
        fi
    fi
done < image_listing.txt 

echo "successful uploads = $success" >> gcs_success.log
echo "failed uploads = $fails" >> gcs_error.log
echo "clearing liip cache..."
sudo -u www-data app/console liip:imagine:cache:remove

