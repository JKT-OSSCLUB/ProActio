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
 *
 * userio.p
 *
 * Takes data from _UserIO table and loads in Proactio database for generating User IO Report.
 *
 * Parameters :
 *  --dbid : unique id assigned to that database - Type : CHARACTER
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
 */

DEFINE INPUT parameter dbid AS  CHARACTER.
DEFINE VARIABLE lcExecute    AS character   NO-UNDO.
{mysql.i}
{common.i}

MESSAGE getdate() "Running userio.p script for database : " dbid.
FOR EACH _UserIo NO-LOCK:
  IF _Userio._Userio-name = ? THEN
	NEXT.
 
  lcExecute =  'insert into userio values("' +
        dbid + '",NOW(),' +
        string(_Userio._Userio-DbAccess) + ',' +
        string(_Userio._Userio-DbWrite) + ',' +
        string(_Userio._Userio-DbRead)  + ',"' +
        _Userio._Userio-name + '");'.                                                                                                                                                                                                                                               
 RUN mysqlExecute(input lcExecute).
end.



