echo Enter username
read UNAME
echo Enter password
read -s PASS
echo Enter Hostname
read HOST
echo Enter Port number
read PORT
rm -rf errlog
mysql -u $UNAME -p -h $HOST -P $PORT --password=$PASS 2>errlog <<EOF
CREATE DATABASE oemon; 
USE oemon;
SOURCE oemon.sql;
GRANT ALL PRIVILEGES ON oemon.* TO $UNAME@$HOST;
EOF
if [ -s errlog ]  #if file has data
then
echo Errors occured during setup. Check errlog file.
else
echo Database setup complete.
fi
