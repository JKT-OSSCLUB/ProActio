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
# Current Location of Proactio is root.
# Author:
# 
#	JK Technosoft
# 	http://www.jktech.com
#	August 11, 2015
#
# History:
# 

# This file must always kept in the root directory (/)
# Modify LOCATION to absolute path of Proactio directory
# (eg if Proactio directory is in /mydir/mychilddir/ then Location=/mydir/mychilddir/ ).
LOCATION=/

case $1 in
CONFIG) echo ${LOCATION}Proactio/config;;
MAINDIR) echo ${LOCATION}Proactio/;;
ALERTDIR) echo ${LOCATION}Proactio/alerts/;;
SCRIPTDIR) echo ${LOCATION}Proactio/scripts/;;
INCLUDEDIR) echo ${LOCATION}Proactio/include/;;
LOGDIR) echo ${LOCATION}Proactio/logs/;;
VSTLIB) echo ${LOCATION}Proactio/vstlib/;;
TEMPDIR) echo ${LOCATION}Proactio/temp/;;
CRONDIR) echo ${LOCATION}Proactio/cron/;;
DRVDIR) echo ${LOCATION}Proactio/drivers/;;
REPDIR) echo ${LOCATION}Proactio/SysReports/;;
esac

