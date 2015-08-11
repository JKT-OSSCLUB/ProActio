 /*******************************************************************************
 *******************************************************************************
 **                                                                           **
 **                                                                           **
 **  Copyright 2015-2017 JK Technosoft                  					  **
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
 * common.i 
 * contains common functions 
 *
 * Author:
 *
 *	JK Technosoft
 *	http://www.jktech.com
 *	August 11, 2015
 *
 *
 * History:
 *
 */
DEFINE VARIABLE lcScriptPath AS CHARACTER   NO-UNDO.
DEFINE VARIABLE lcAlProcPath  AS character   NO-UNDO.
DEFINE VARIABLE lcRepProcPath  AS character   NO-UNDO.
DEFINE VARIABLE lcTempPath  AS character   NO-UNDO.
DEFINE VARIABLE lcLogdirPath  AS character   NO-UNDO.

FUNCTION getdate RETURN CHARACTER:  
    DEFINE VARIABLE cdt    AS CHARACTER  NO-UNDO.
    INPUT THROUGH date +'%d-%m-%Y,%H:%M:%S'.
    IMPORT Unformatted cdt.
    RETURN cdt + ":".
END.

FUNCTION getpath RETURN CHARACTER (INPUT dir AS CHARACTER):
    DEFINE VARIABLE cdirpath    AS CHARACTER  NO-UNDO.
    INPUT THROUGH sh /getpath.sh value(dir).
    IMPORT Unformatted cdirpath.
    RETURN cdirpath.
END.

lcScriptPath = getpath("SCRIPTDIR").
lcAlProcPath = getpath("ALERTDIR").
lcRepProcPath = getpath("REPDIR").
lcTempPath = getpath("TEMPDIR").
