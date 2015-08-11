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
 **  See TNC.TXT for more information regarding the Terms and Conditions    **
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
 * usertable.i
 *
 * Known Bugs & Issues:
 *
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
 * User connections % caculation
 * Returns information of user table if greater than threshold
 *
 */
FUNCTION getInfo RETURNS CHARACTER(INPUT dThreshold AS DECIMAL):
 DEFINE VARIABLE iCount AS INTEGER      NO-UNDO INITIAL 0.
 DEFINE VARIABLE dPerc  AS DECIMAL      NO-UNDO.
 DEFINE VARIABLE cInfo  AS CHARACTER    NO-UNDO INITIAL "".
 FIND FIRST _startup NO-LOCK NO-ERROR.
 FOR EACH _Connect NO-Lock:
    IF _Connect-Usr <> ? THEN
        iCount = iCount + 1.
 END.
 MESSAGE "Currently Connected Users : " iCount " Maximum number of users (-n) : " string(_Startup-MaxUsers).
 dPerc = (iCount * 100) / _Startup-MaxUsers.
 MESSAGE "Pecentage = " dPerc "%".
 IF  dPerc > dThreshold THEN
 DO:
     cInfo =  "Currently Connected Users : " + string(iCount) + " Maximum number of users (-n) : " + string(_Startup-MaxUsers).
 END.
RETURN cInfo.
END. 
