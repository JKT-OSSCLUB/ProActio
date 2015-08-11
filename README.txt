#############
Prerequisites 
#############
1.Install MySQL 5.6.21 on Linux machine. Remember the MySQL root username, password, hostname and port number. 

2.Create a "sysprogress" user (if not exists) on Progress RDBMS (which need to be monitored). Remember sysprogress username, password, host name and port number. 

3.Ssh : In order to execute server monitoring scripts on a remote machine, we need an ssh connection,therefore ssh must be enabled and, setting of rsa keys must be done prior before running any server monitoring scripts.
Steps to set up RSA keys:
 1.Enter the following command into the host terminal :  ssh-keygen -t rsa
 2.Respond to each prompt from ssh-keygen by pressing the Return key (leaving the reply blank)
 3.If prompted for overwriting the file .ssh/id_rsa, type 'y' if you want keys to be regenerated, otherwise type 'n' to use previously generated keys.
 4.This procedure has generated an RSA SSH key pair, located in the .ssh hidden directory within user's home directory. These files are:
  ~/.ssh/id_rsa: The private key. DO NOT SHARE THIS FILE!
  ~/.ssh/id_rsa.pub: The associated public key. This can be shared freely without consequence.
 5.We next need to move one file (public key) to the remote server where Progress database is configured. ssh access to that remote server is needed to complete this final step. Use the following command
  ssh-copy-id -i  /root/.ssh/id_rsa.pub username@remote_host
 6.This will prompt you for the user account's password on the remote system.After typing in the password, the contents of your ~/.ssh/id_rsa.pub key will be appended to the end of the user account's ~/.ssh/authorized_keys file.

4.Other settings : We need to create a Progress database "compiledb" inside the "Proactio" directory. Navigate to the main directory, "Proactio", and run the following command 
	prodb compiledb empty - This command will create the `compiledb` database
	proserve compiledb	- This command will start the server process against compiledb
5.Browser support : The following Web browsers are currently  supported :
	Firefox 9.0+
	Chrome 3.0+
 In addition, the following options must be enabled:
	JavaScript Enabled
	Ajax Enabled
6.pdf viewer : To view Reports, A pdf viewer is required.
7.ODBC 11.3 Installed on host machine.
OPTIONAL
8.buy the ssl certificate for encryption : For https Protocol (optional)
9.buy a domain name : To deploy Front end on Linux machine.

###################
Configuration setup
###################
Below is the list of files needed to be modified before Proactio (Backend) setup.

1.getpath.sh file (file location : Proactio/getpath.sh) : it resolves all path references
This file stores the location of the main directory (“Proactio” directory),where all the source code resides. Default location of the main directory is root (“/”) directory. Modify this file to store the exact location of the main directory (“Proactio” directory), e.g, if location of “Proactio” directory is like “/mydir/mychilddir/Proactio/..” set the  LOCATION=/mydir/mychilddir/

  Note : after modifying “getpath.sh”,  copy the “getpath.sh” file to the root (“/”) directory. This step is mandatory as “getpath.sh” file resolves all path refrences. Changes in this file requires recompilation of all files in “Proactio/drivers/” , “Proactio/alerts/”, “Proactio/SysReports/”  directories.

2.connect.i file ; (file location : Proactio/config/connect.i)
Common parameters for Mysql connection are listed in connect.i file. To change the Mysql connection parameters  or  modify the list of email-ids for alert notification mails, modify this file. This file contains: 
1. User - Username
2. Pass - Password
3. Hostname - Hostname
4. Portno - Port Number
5. Dbname - Database name (ie oemon)
6. email_list - comma-separated list of email-ids for sending alert emails

changes in this file requires recompilation of all files in “Proactio/drivers/” , “Proactio/alerts/”, “Proactio/SysReports/”  directories.

3.proactio.profile ; (file location : Proactio/config/proactio.profile)
This file stores Linux environment variables and list of email ids to send notification mails in case any script fails to execute. This file can be modified. The changes made to this file need not require recompilation of any files. This file is used by every cron script.
1.DLC path
2.HOSTNAME
3.Date
4.TERM (Terminal environment variable)
5.List of email ids to send notification mail in case any script fails to execute

Below is the list of files needed to be modified before Proactio (Front end) setup.

4.sqlconnect.php and sqlconnectver2.php (file location : Proactio Front\sqlconnect.php ,Proactio Front\sqlconnectver2.php): These files stores MySQL connection parameters. Modify MySQL credentials (username,password,hostname) in sqlconnect.php and sqlconnectver2.php files.
5.settings.json (file location : Proactio Front\settings.json) : Change the host machines IP Address in this file.

#########################################
Installation of Proactio on a new server:
#########################################
SETUP(Front end)
1.Download the Folder for front end - “Proactio Front” to the location where you want to set up Proactio.
2.Modify "Proactio Front\sqlconnect.php" and "Proactio Front\sqlconnectver2.php" files to store the MySQL connection parameters.
3.Modify "Proactio Front\settings.json" file to store IP address of host machine.
Execution:
4.Run Proactio.exe file.
5.Login as Admin User (DBA Login)  username = "admin" ; password = "proactio" (without quotes)
6.Change Admin Password: Click on options -> Change Settings -> Change Password
SETUP(Back end)
1.Download the Folder for back end - “Proactio” to the location where you want to set up Proactio. 
2.Run "Proactio/setup.sh" file to setup Mysql database.
	sh setup.sh 
It will ask for mysql credentials. Provide Mysql username password hostname and portnumber. It will create Mysql database and tables for Proactio.Provide correct Mysql connection credentials. In case of errors check "Proactio/errlog" file.
3.Modify the “getpath.sh” file to set  the exact location of “Proactio” directory. Copy this file to the root (“/”) directory. 
	This step is required every time when the location of “Proactio” directory will be changed.
4.Modify the file “Proactio/config/connect.i” to store the MySQL connection parameters and list of email-ids (comma-separated) to send database alert notification emails.
5.Check the file “Proactio/config/proactio.profile” for Linux environment variables and list of email-ids to send notification emails in case of script malfunctioning. Modify this file if required.  
6.Recompile the files in  “Proactio/drivers/” , “Proactio/alerts/”, “Proactio/SysReports/”  directories by running command :
_progres -p setup.p 

Executing Scripts:
6.All executable scripts are in “Proactio/cron” folder. These scripts can be scheduled in crontab or can be executed individually (sh {scriptname}). 
7.To get information about the output produced by the script, check the log file (having same name as that of the script) in “Proactio/logs” folder.
8.Threshold values for the alert scripts are hard-coded. If there is a need to change the threshold value of a certain alert script, the corresponding driver file (Proactio/drivers/xxx_drv.p) or utility function in vstlib (Proactio/vstlib/xxx.i) needs to be changed and recompiled.
Note : This step is required due to hard coding of threshold values in these files. This hard coding of threshold values will be removed soon.
Note : This step is required due to hard coding of threshold values in these files. This hard coding of threshold values will be removed soon.

All the monitoring scripts can be scheduled as per organisations requirments.

