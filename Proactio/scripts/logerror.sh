# *******************************************************************************
# *******************************************************************************
# **                                                                           **
# **                                                                           **
# **  Copyright 2015-2017 JK Technosoft                  					   **
# **  http://www.jktech.com                                           		   **
# **                                                                           **
# **  ProActio is free software; you can redistribute it and/or modify it      **
# **  under the terms of the GNU General Public License (GPL) as published     **
# **  by the Free Software Foundation; either version 2 of the License, or     **
# **  at your option) any later version.                                       **
# **                                                                           **
# **  ProActio is distributed in the hope that it will be useful, but WITHOUT  **
# **  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or    **
# **  FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License     **
# **  for more details.                                                        **
# **                                                                           **
# **  See TNC.TXT for more information regarding the Terms and Conditions      **
# **  of use and alternative licensing options for this software.              **
# **                                                                           **
# **  A copy of the GPL is in GPL.TXT which was provided with this package.    **
# **                                                                           **
# **  See http://www.fsf.org for more information about the GPL.               **
# **                                                                           **
# **                                                                           **
# *******************************************************************************
# *******************************************************************************
# 
#This script checks whether a database log file contains any errors.
# parameter 1 : full path of the database log file 
# parameter 2 : unique id assigned to that database
# parameter 3 : server name
#
# Author:
# 
#	JK Technosoft
# 	http://www.jktech.com
#	August 11, 2015
#
# History:
# 


ERR_NEW=`sh /getpath.sh TEMPDIR`$2.newerr
ERR_OLD=`sh /getpath.sh TEMPDIR`$2.olderr
ERR_FILE=`sh /getpath.sh TEMPDIR`$2.errorlog

#if file not exists then create a new one
test -e  ${ERR_NEW} || touch ${ERR_NEW}
test -e  ${ERR_OLD} || touch ${ERR_OLD}
test -e  ${ERR_FILE} || touch ${ERR_FILE}

ssh $3 exec /bin/sh -s "$1" > ${ERR_NEW} <<"EOF"
PATTERN="warning\|ERROR\|system\|core\|abnormal\|exceed\|fail\|fatal\|wrong\|unexpected\|bkiowrite\|(3773)\|invalid\|died\|dead\|overflow\|violation\|insufficient\|disappear\|missing\|drastic\|errno\|ignor\|socket\|critical"
/bin/grep ${PATTERN} $1
EOF

diff $ERR_NEW $ERR_OLD > ${ERR_FILE}
if [ -s $ERR_FILE ]  #if file has data
then
       echo `date +'%d-%m-%Y,%H:%M:%S'` Errors found for databse ${2}
else
	echo `date +'%d-%m-%Y,%H:%M:%S'` No Errors found for databse ${2}
fi
#replace newerr with olderr
mv -f ${ERR_NEW} ${ERR_OLD}
