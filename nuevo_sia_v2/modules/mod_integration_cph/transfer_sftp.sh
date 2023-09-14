#!/bin/bash
#
# Description:
# Get user, remote server, source directory with absolute path and 
# remote directory details as input to sync the latest added files
# with remote server
#
# Execute SFTP command example in Unix shell script with password
# Using batch file with expect
##################################################################

# tempfile="./transfer_sftp.$$"
tempfile="./envio_archivos/agrocampo-oc-cph.csv"
# tempfile="./envio_archivos/"
filename="agrocampo-oc-cph.csv"
server="192.168.6.55";
count=0

# <Output trimmed>

# if [ $count -eq 0 ] ; then
#   echo "$0: No files require uploading to $server" >&2
#   exit 1
# fi

# echo "quit" >> $tempfile
# echo "put -P \"$filename\""
# tempfile="put \"$filename\""
# echo $tempfile
expect -c "spawn sftp -o "BatchMode=no" -b "$tempfile" "magentodoo@$server"
expect -nocase \"*password:\" { send \"(!Magent0doo.)\r\"; interact }"

# echo "Synchronizing: Found $count files in local folder to upload."

# touch $timestamp
# rm -f $tempfile
exit 0