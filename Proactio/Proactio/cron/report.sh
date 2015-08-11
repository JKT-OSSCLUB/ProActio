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
# Author:
# 
#	JK Technosoft
# 	http://www.jktech.com
#	August 11, 2015
#
# History:
# 
#Source in Proactio environment variables
. `sh /getpath.sh CONFIG`/proactio.profile

SCRIPT_NAME=report_drv.p
echo "${DATE}: Report Generation script started at ${HOSTNAME}" >> ${LOGDIR}/report.log
$DLC/bin/_progres -b -p ${PROGDIR}/${SCRIPT_NAME} >> ${LOGDIR}/report.log
if [ $? -eq "0" ]
then
        echo "${DATE}: Report Generation script executed successfully on ${HOSTNAME}" >> ${LOGDIR}/report.log
else
        ERRMSG="${DATE}: Errors occurred while executing Report Generation script on hostname = ${HOSTNAME} : script name = ${SCRIPT_NAME}"
        echo $ERRMSG >> ${LOGDIR}/report.log
        echo $ERRMSG | mailx -s "Proactio Notification Mail" ${EMAIL_LIST}
fi
