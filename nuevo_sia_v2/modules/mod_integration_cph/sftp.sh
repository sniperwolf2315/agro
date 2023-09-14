# tempfile="./envio_archivos/agrocampo-oc-cph.csv"
# tempfile="./envio_archivos/transfer.txt"
tempfile="transfer.txt"

# user="magentodoo"
# server="192.168.1.115"
# user="agrocamp"
# server="190.25.224.2"
# port="953"
# password="Coas2023$"
# count=1
# echo "put -P \"$tempfile\""
# expect -c "spawn sftp -o "BatchMode=no" -b "$tempfile" "$user@$server" expect -nocase \"*password:\" { send \"(!Magent0doo.)\r\"; interact }"




# echo "opcion 2" 
HOST="190.25.224.2"
PORT="953"
USER="agrocamp"
PASSWORD="Coas2023$"
SOURCE_FILE="agrocampo-oc-cph.csv"
TARGET_DIR="/Agrocampo"

 /usr/bin/expect<<EOD 
 spawn sftp -o Port=$PORT $USER@$HOST
 expect "password:"
 send "$PASSWORD\r"
 expect "sftp>"
 send "put $SOURCE_FILE $TARGET_DIR\r"
 expect "sftp>"
 send "bye\r"
 EOD

RC=$?
if [[ ${RC} -ne 0 ]]; then
  cat output.log | mail -s "Errors Received" "email@domain.com"
else
  echo "Success" | mail -s "Transfer Successful" "email@domain.com"
fi


