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
 * Buffer dHits % alert
 * alert id  = 12
 * initial Threshold 1 = 90%
 * Initial Threshold 2 = 80%
 *
 * alert generated when Buffer Hits are less than - Threshold1 (Minor alert) or Threshold 2 (Major Alert).
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
DEFINE input parameter dThold1 AS DECIMAL. /* 90.00. */
DEFINE input parameter dThold2 AS DECIMAL. /* 80.00. */

DEFINE VARIABLE iAlertid        AS INTEGER    NO-UNDO INITIAL 12.
DEFINE VARIABLE lcExecute       AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE lcQueryRes      AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE dHits           AS DECIMAL    NO-UNDO.
DEFINE VARIABLE hw              AS DECIMAL    NO-UNDO INITIAL 5.00.
DEFINE VARIABLE InsertQuery     AS CHARACTER  NO-UNDO.
DEFINE VARIABLE UpdateQuery     AS CHARACTER  NO-UNDO.
DEFINE VARIABLE id              AS CHARACTER   NO-UNDO.
DEFINE VARIABLE sub             AS CHARACTER   NO-UNDO.

{mysql.i}
{email.i}

for each _ActBuffer Where  _Buffer-Id=1 NO-LOCK:
      dHits = ((_Buffer-LogicRds)/(_Buffer-LogicRds + _Buffer-OSRds) * 100 ).
      Message "Hits Percentage :" string(dHits).
      IF dHits > dThold1  THEN
           NEXT.
       ELSE
           DO:
               IF dHits < dThold2 THEN
                   ASSIGN iAlertid = 13.
               ELSE
                   ASSIGN iAlertid = 12.

            InsertQuery =
                            'INSERT INTO `alerts`(`desc_id`, `dbid`, `date`, `alert_read`, `info`) VALUES (' +
                             string(iAlertid) +  ',"' +
                             dbid + '",NOW(),' +
                             string(0) + ',"' +
                             replace(string(dHits),",",".") + '%");'.

         UpdateQuery = 'UPDATE `alerts` SET  `info` = "' + string(dHits) + '" , `desc_id` = ' + string(iAlertid) + ',date = now() WHERE desc_id IN (12,13) and dbid = "' + dbid + '~ ";'.

            lcExecute = "Select distinct  info, alertid  from alerts where dbid =\"" + dbid + "\" AND desc_id IN (12,13) '|sed 's/\t/,/g".
            lcQueryRes = mysqlSelect(input lcExecute).
                IF lcQueryRes <> "" THEN
                DO:   
                        hw = INTEGER(Entry(1,lcQueryRes,".")).
                        IF dHits < hw THEN
                         DO:
                          id =ENTRY(2,lcQueryRes,",").        
                          RUN mysqlExecute(UpdateQuery).
                        END.
                END.
                ELSE
                  id = mysqlInsert(InsertQuery).
                if id <> "" then
                DO: /* generate email */
                  sub = composemail(dbid,id).
                  RUN sendalertmail(input sub, input {&email_list}).
                  id = "".
                END.
      END.
  
end.
