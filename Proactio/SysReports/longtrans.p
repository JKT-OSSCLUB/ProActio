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
 * longtrans.p
 * 
 * Takes data from _Trans table and loads in Proactio database for generating Long Transction summary Report.
 *
 * Parameters :
 *  --dbid : unique id assigned to that database - Type : CHARACTER
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

DEFINE INPUT PARAMETER dbid AS  CHARACTER.

DEFINE VARIABLE lcExecute    AS CHARACTER   NO-UNDO.
DEFINE VARIABLE dur	     as integer no-undo.
{mysql.i}
{common.i}

MESSAGE getdate() "Running longtrans.p script for database :" dbid.
FOR  EACH _Trans WHERE _Trans._Trans-Usrnum <> ? AND _Trans._Trans-State EQ "Active"  NO-LOCK:
    FIND _connect WHERE _Trans._Trans-Usrnum = _connect._Connect-usr NO-LOCK NO-ERROR.
    IF AVAILABLE _connect THEN
            DO:
		IF _Trans._Trans-Duration <> ? THEN
		ASSIGN  dur = _Trans._Trans-Duration.
                lcExecute =  'insert into longtrans values("' + 
                            dbid + '",NOW(),"' +
                            _Connect._Connect-name + '",' +
                            string(_Connect._Connect-pid) + ',' +
                            string( _Trans._Trans-Usrnum) + ',' +
                            string(dur) + ',' +
                            string(_trans._Trans-Num) + ');' .
                RUN mysqlExecute(lcExecute).
            END.
    ELSE
        MESSAGE getdate() "No _Connect record found for User number : " STRING(_Trans._Trans-Usrnum).        
END. 






