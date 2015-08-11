/*******************************************************************************
 *******************************************************************************
 **                                                                           **
 **                                                                           **
 **  Copyright 2015-2017 J K Technosoft                  					  **
 **  http://www.jktech.com                                           		  **
 **                                                                           **
 **  ProActio is free software; you can redistribute it and/or modify it      **
 **  under the terms of the GNU General Public License (GPL) as published     **
 **  by the Free Software Foundation; either version 2 of the License, or     **
 **  at your option) any later version.                                       **
 **                                                                           **
 **  ProActio is distributed in the hope that it will be useful, but WITHOUT  **
 **  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or    **
 **  FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License     **
 **  for more details.                                                        **
 **                                                                           **
 **  See TNC.TXT for more information regarding the Terms and Conditions      **
 **  of use and alternative licensing options for this software.              **
 **                                                                           **
 **  A copy of the GPL is in GPL.TXT which was provided with this package.    **
 **                                                                           **
 **  See http://www.fsf.org for more information about the GPL.               **
 **                                                                           **
 **                                                                           **
 *******************************************************************************
 *******************************************************************************
 *
 * compileOthers.p
 * compile files in alerts directory and Sysreports directory
 *
 * Author:
 *
 *	J K Technosoft
 *	http://www.jktech.com
 *	August 11, 2015
 *
 *
 * History:
 *
 */
DEFINE VARIABLE cSourceDir AS CHARACTER NO-UNDO.
DEFINE VARIABLE cRDir AS CHARACTER NO-UNDO.
{common.i}

/* compiling `alerts` directory ; store .r files in the same directory */
ASSIGN  cSourceDir = getpath("ALERTDIR")
        cRDir = getpath("ALERTDIR").

RUN compile.p (input cSourceDir, input cRDir).

/* compiling `SysReports` directory ; store .r files in the same directory */
ASSIGN  cSourceDir = getpath("REPDIR")
        cRDir = getpath("REPDIR").

RUN compile.p (input cSourceDir, input cRDir).
