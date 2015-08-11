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
 * Long Running Transactions alert
 * alert id  = 9
 * Threshold = 20 sec
 *
 * alert generated when a transaction active for longer than threshold value is found.
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
Define input parameter iTimeInSeconds  AS INTEGER. /* 20 */

DEFINE VARIABLE iAlertid        AS INTEGER    NO-UNDO INITIAL 9.
DEFINE VARIABLE cReturnCode     AS CHARACTER  NO-UNDO.
DEFINE VARIABLE lcExecute       AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE lcQueryRes      AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE cInf            AS CHARACTER   NO-UNDO.
DEFINE VARIABLE iCurDur         AS INTEGER     NO-UNDO.
DEFINE VARIABLE InsertQuery     AS CHARACTER   NO-UNDO.
DEFINE VARIABLE UpdateQuery     AS CHARACTER   NO-UNDO.    
DEFINE VARIABLE id            AS CHARACTER   NO-UNDO.
DEFINE VARIABLE sub            AS CHARACTER   NO-UNDO.
{mysql.i}
{email.i}

FOR EACH _Trans WHERE _Trans._Trans-State EQ "Active" AND
                      _Trans._Trans-Duration GT iTimeInSeconds NO-LOCK:
 
    FIND FIRST _Connect WHERE _Connect._Connect-Usr = _Trans._Trans-UsrNum NO-LOCK NO-ERROR.
    IF AVAILABLE _Connect THEN 
    DO:
        MESSAGE "Transaction number : " string(_Trans-Num) "Found active".
        MESSAGE "Duration : " string(_Trans-Duration).
          cInf = 'Transaction number : ' + string(_Trans-Num) + ' active since : ' + string(_Trans-Duration) + ' seconds User No. : ' + string(_Trans-UsrNum)
                               + ' User Name :' + _Connect._Connect-Name.
          InsertQuery = 'INSERT INTO `alerts`(`desc_id`, `dbid`, `date`, `alert_read`, `info`) VALUES (' +
                                                                string(iAlertid) +  ',"' +
                                                                dbid + '",NOW(),0,"' +
                                                                cInf + '");'.
                                                                                                                                                       
          UpdateQuery = 'UPDATE `alerts` SET  `info` = "' + cInf + '" WHERE desc_id = ' + string(iAlertid) + ' and dbid = "' + dbid 
                        + '" AND Info LIKE \"% '+ string(_Trans-Num) + ' active since%\";'.

          lcExecute = "Select `info`, `alertid`   from alerts where dbid =\"" + dbid + "\" AND desc_id =" + string(iAlertid) 
                        + " AND Info LIKE \"% "+ string(_Trans-Num) + " active since%\" '|sed 's/\t/,/g".
          lcQueryRes = mysqlSelect(input lcExecute).
          IF lcQueryRes <> "" THEN
          DO:
            iCurDur = INTEGER(ENTRY(2,ENTRY(3,lcQueryRes,":")," ")).
            IF  _Trans-Duration  > iCurDur THEN 
            DO:
                 id = ENTRY(2,lcQueryRes,",").                
                 RUN mysqlExecute(input UpdateQuery).
             END.               
           END.
          ELSE
                 id = mysqlInsert(input InsertQuery).
             
                /* email */   
               IF id <> "" then
               DO: /* generate email */
                  sub = composemail(dbid,id).
                  RUN sendalertmail(input sub, input {&email_list}).
                  id = "".
               END.
    PAUSE 1.
    END. 
END.  
                
