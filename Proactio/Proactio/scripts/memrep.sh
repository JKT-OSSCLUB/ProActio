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
#memory monitoring for report generation
#it uses free utility to gather information
# Author:
# 
#	JK Technosoft
# 	http://www.jktech.com
#	August 11, 2015
#
# History:
# 
ssh $1 exec /bin/sh -s << "EOF"
 data=`free  |grep -i "Mem:" `
  TOTAL=`echo $data |awk -F" " '{print $2}'`
  USED=`echo $data |awk -F" " '{print $3}'`
  FREE=`echo $data |awk -F" " '{print $4}'`
 sdata=`free  |grep -i  "Swap:" `
  STOTAL=`echo $sdata |awk -F" " '{print $2}'`
  SUSED=`echo $sdata |awk -F" " '{print $3}'`
  SFREE=`echo $sdata |awk -F" " '{print $4}'`
echo $TOTAL $USED $FREE $STOTAL $SUSED $SFREE
EOF
