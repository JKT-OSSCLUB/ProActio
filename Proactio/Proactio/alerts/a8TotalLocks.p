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
 * Total Locks for a Process 
 * alert id  = 8
 *
 * Checks Lock table for locks currently held by a process.
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

Define input parameter dbid as character.

DEFINE VARIABLE iAlertid        AS INTEGER    NO-UNDO INITIAL 8.
DEFINE VARIABLE lcExecute       AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE lcQueryRes      AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE cInfo           AS CHARACTER  NO-UNDO.
DEFINE VARIABLE id             AS CHARACTER   NO-UNDO.
DEFINE VARIABLE sub             AS CHARACTER   NO-UNDO.

{mysql.i}
{email.i}

DEFINE TEMP-TABLE tt_lockinfo 
                         FIELD usr  LIKE _lock._Lock-Usr
                         FIELD uname LIKE  _Connect._Connect-Name
                         FIELD utype LIKE _Connect._Connect-Type
                         FIELD pid LIKE _Connect._Connect-Pid
                         FIELD tbl LIKE _file._file-name.

FOR EACH _Lock NO-LOCK WHERE _Lock-Usr <> ? BREAK BY _lock._Lock-Usr:
      IF FIRST-OF(_lock._Lock-Usr)  THEN 
      DO:
            CREATE tt_lockinfo.
            ASSIGN tt_lockinfo.usr = _lock._Lock-Usr.
            FIND FIRST _file WHERE _file-number = _Lock._Lock-Table NO-LOCK NO-ERROR.
            FIND FIRST _Connect WHERE _Connect-usr = _Lock._Lock-Usr NO-LOCK NO-ERROR.
            IF NOT AVAILABLE _file THEN
                MESSAGE "ERROR No corresponding 'file' information about locked record is available".
            ELSE IF NOT AVAILABLE _Connect THEN
                MESSAGE "ERROR No corresponding 'connect' information about locked record is available".
            ELSE
            DO:
                ASSIGN tt_lockinfo.uname = _Connect._Connect-Name
                       tt_lockinfo.utype = _Connect._Connect-Type
                       tt_lockinfo.pid = _Connect._Connect-Pid
                       tt_lockinfo.tbl = _file._file-name.
             
            END.
      END.
END.
                                    
FOR EACH tt_lockinfo NO-LOCK:
  cInfo =  "Usr:" + string(usr) + "; " +
           "User Name:" + string(uname) + "; " +
           "UsrType: " + string(utype) + "; " +
           "UsrPid:" + string(pid) + "; " +
           "Table: " + string(tbl) . 
  MESSAGE cInfo. 
  lcExecute = 'INSERT INTO `alerts`(`desc_id`, `dbid`, `date`, `alert_read`, `info`) VALUES (' +
                                                                            string(iAlertid) +  ',"' +
                                                                            dbid + '",NOW(),0,"' +
                                                                            cInfo + '");'.

  id = mysqlInsert(lcExecute).
  sub = composemail(dbid,id).
  RUN sendalertmail(input sub, input {&email_list}).
       
PAUSE 1.
END.       
                               
