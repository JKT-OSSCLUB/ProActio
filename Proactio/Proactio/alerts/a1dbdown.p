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
 * Database Down alert
 * alert id  = 1
 * script used = dbdown.sh
 * 
 * alert generated when database is unavailable or down.
 *
 * Parameters :
 *  --dbid : unique id assigned to that database - Type : CHARACTER
 *  --dbpath : dull path of the database - Type : CHARCTER
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

Define input parameter dbid as character.
Define input parameter dbpath   as character.        /* Complete path of database */

DEFINE VARIABLE iAlertid        AS INTEGER    NO-UNDO INITIAL 1.
DEFINE VARIABLE cReturnCode     AS CHARACTER  NO-UNDO.
DEFINE VARIABLE lcExecute       AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE lcQueryRes      AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE id              AS CHARACTER   NO-UNDO.
DEFINE VARIABLE sub             AS CHARACTER   NO-UNDO.

{mysql.i}
{email.i}

INPUT THROUGH sh value(lcScriptPath + "dbcheck.sh") value(dbpath).
IMPORT unformatted cReturnCode.
if cReturnCode <> string(2) then        /* if valid database then */ 
DO:
    lcExecute='SELECT alertid from alerts where  desc_id = ' + string(iAlertid) + ' AND dbid ="' + dbid + '" AND alert_read = 0;'.
    lcQueryRes = mysqlSelect (input lcExecute).
     
    if lcQueryRes = "" THEN                /* if no previous entry found */
    DO:
        if  cReturnCode = string(0) then        /* database is down */
        DO:
            Message getdate() "Database :" dbid "Found down. ReturnCode = 0".           
            lcExecute = 'INSERT INTO alerts (desc_id,dbid,date,alert_read) VALUES (' + string(iAlertid) + ',"' + dbid + '", NOW(),0);'.
            id = mysqlInsert (input lcExecute).
            /* generate email*/
	     sub = composemail(dbid,id).
             RUN sendalertmail(input sub, input {&email_list}).		            
        END.   
    END.
    else
    DO:
        if (cReturnCode = string(16) OR cReturnCode = string(14)) then
         DO:
            Message getdate() "Database : " dbid " Found up again. ReturnCode = " cReturnCode.
            lcExecute = 'UPDATE alerts SET  alert_read = 1, enddate = NOW() WHERE alertid = ' + lcQueryRes + ';'.
            RUN  mysqlExecute (input lcExecute).
         END.
    END.
END.            

