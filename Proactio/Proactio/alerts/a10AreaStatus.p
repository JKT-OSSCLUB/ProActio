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
 * Area Status %used alert
 * Initial Threshold 1= 90%
 * Initial Threshold 2= 80%
 *
 * alert generated when any application area used% are greater than - Threshold 1 (Critical Alert) or threshold 2 (Major Alert).
 * Parameters :
 *  --dbid : unique id assigned to that database - Type : CHARACTER 
 *  --dThold1 : Threshold value
 *  --dThold2 : Threshold value
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
DEFINE input parameter dThold1 AS DECIMAL.    /* 90.00. */
DEFINE input parameter dThold2 AS DECIMAL.    /* 80.00. */

DEFINE VARIABLE iAlertid        AS INTEGER    NO-UNDO INITIAL 10.
DEFINE VARIABLE lcExecute       AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE lcQueryRes      AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE hw              AS DECIMAL    NO-UNDO.
DEFINE VARIABLE cInsertInfo     AS CHARACTER   NO-UNDO.
DEFINE VARIABLE used            AS DECIMAL     NO-UNDO.
DEFINE VARIABLE id              AS CHARACTER   NO-UNDO.
DEFINE VARIABLE InsertQuery     AS CHARACTER   NO-UNDO.
DEFINE VARIABLE UpdateQuery     AS CHARACTER   NO-UNDO.
DEFINE VARIABLE empty_blocks    AS DECIMAL     NO-UNDO.
DEFINE VARIABLE sub             AS CHARACTER   NO-UNDO.

{mysql.i}
{email.i}
FOR EACH  _Areastatus WHERE NOT (
            _Areastatus._AreaStatus-Areaname MATCHES('Primary Recovery Area*') OR
            _Areastatus._AreaStatus-Areaname MATCHES('Schema Area*') OR 
            _Areastatus._AreaStatus-Areaname MATCHES('Control Area*') OR
            _AreaStatus-Areaname  MATCHES('After Image Area*') )  NO-LOCK:
       
       empty_blocks = _AreaStatus-Totblocks - _AreaStatus-Hiwater - _AreaStatus-Extents. 
       used = (1.0 - (empty_blocks / _AreaStatus-Totblocks)) * 100.0. 
       cInsertInfo = STRING(_AreaStatus-Hiwater) + "/" + STRING(_AreaStatus-Totblocks) + " " + _Areastatus._AreaStatus-Areaname + " used".
       MESSAGE "Used Percentage : "  string(used) " Hiwater/Totblocks :" + cInsertInfo.               
       IF used < dThold2  THEN
           NEXT.
       ELSE 
           DO:
              IF used > dThold1 THEN
                   ASSIGN iAlertid = 11.
               ELSE
                   ASSIGN iAlertid = 10.

            InsertQuery = 'INSERT INTO `alerts` (`desc_id`, `dbid`, `date`, `alert_read`, `info`) VALUES (' +
                             string(iAlertid) + ',"' + dbid + '",NOW(),0,"' + cInsertInfo + '");'.       
                
            UpdateQuery = 'UPDATE `alerts` SET  desc_id = ' + string(iAlertid) + ', info = "' + cInsertInfo + 
                        '", date = NOW() WHERE desc_id IN (10,11) and dbid = "' + dbid + '"  AND Info LIKE "%' + _Areastatus._AreaStatus-Areaname + ' used"'.

            lcExecute = "Select  distinct  `info` , `alertid`  from alerts where dbid =\"" + dbid + 
            "\" AND desc_id IN (11,10) AND Info LIKE \"%" +  _Areastatus._AreaStatus-Areaname + " used\" '|sed 's/\t/,/g".
           
            lcQueryRes = mysqlSelect(input lcExecute).
            IF lcQueryRes <> "" THEN
            DO:
                  hw = INTEGER(ENTRY(1,lcQueryRes,"/")).
                  IF _Areastatus._AreaStatus-Hiwater > hw THEN
                  DO:                
                     id =  ENTRY(2,lcQueryRes,",").
                     RUN mysqlExecute(input UpdateQuery).                      
                  END.    
            END.
            ELSE 
                id = mysqlInsert(input InsertQuery).

                if id <> "" then
                DO: /* generate email */
                  sub = composemail(dbid,id).
                  RUN sendalertmail(input sub, input {&email_list}).
                  id = "".
                END.
                               
         END.
         PAUSE 1.
END.



