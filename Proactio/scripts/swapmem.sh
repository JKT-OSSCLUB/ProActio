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
#swap memory %free space alert.
#It Uses `free` utility to calculate swap memory free space.
# Author:
# 
#	JK Technosoft
# 	http://www.jktech.com
#	August 11, 2015
#
# History:
# 
ssh $1 exec /bin/sh -s << "EOF"
stot=`free -m | grep Swap | awk -F" " '{print $2}'`
sfree=`free -m | grep Swap | awk -F" " '{print $4}'`
sfree_perc=$(bc <<< 'scale=5;'$sfree\*100/$stot)
echo $sfree_perc
EOF
