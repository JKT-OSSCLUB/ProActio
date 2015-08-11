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
 * Lock Table (-L)% left alert
 * alert id  = 2
 * Threshold = 50%
 * 
 * alert generated when size of locking table (-L) increses above a threshold  
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

Define input parameter dbid as character.
Define input parameter dThreshold AS DECIMAL. /* 50 */

DEFINE VARIABLE iAlertid        AS INTEGER    NO-UNDO INITIAL 2.
DEFINE VARIABLE lcExecute       AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE lcQueryRes      AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE cInsertInfo     AS CHARACTER  NO-UNDO.
DEFINE VARIABLE dPrevhwater     AS INTEGER    NO-UNDO INITIAL 0.00.
DEFINE VARIABLE dCurhwater      AS INTEGER    NO-UNDO.
DEFINE VARIABLE id              AS CHARACTER   NO-UNDO.
DEFINE VARIABLE sub             AS CHARACTER   NO-UNDO.

{mysql.i}
{locktable.i}
{email.i}

 cInsertInfo = getinfo(input dThreshold,output dCurhwater) .
  
 lcExecute = 'Select info from alerts where dbid = "' + dbid + '" AND desc_id = ' + string(iAlertid) + ' AND alert_read = 0 order by info asc;'.
 lcQueryRes = mysqlSelect(lcExecute).                                                
 IF ( cInsertInfo = "" ) THEN
 DO:
          /* Perform update for prev issue resolved. */
        lcExecute = 'UPDATE `alerts` SET  `enddate`= NOW() ,`alert_read`= 1 WHERE desc_id = ' + string(iAlertid) + ' AND dbid = "' + dbid + '" AND alert_read = 0;'.
        RUN mysqlExecute(lcExecute).
 END.
 ELSE
 DO:
         IF ( lcQueryRes <> "" ) THEN     /* if previous entries in mysql found then extract prev hwater */
         dPrevhwater = INTEGER(ENTRY(2,lcQueryRes ,"/")).
         IF (dCurhwater > dPrevhwater ) THEN
         DO:
                 /* Perform insert for new information */
                 lcExecute =
                         'INSERT INTO `alerts`(`desc_id`, `dbid`, `date`, `alert_read`, `info`) VALUES (' +
                          string(iAlertid) + ',"' +
                          dbid + '",NOW(),0,"' +
                         cInsertInfo + '");'.
                 
                 id = mysqlInsert(lcExecute).
                  
                 /* generate email */
                 sub = composemail(dbid,id).
                 RUN sendalertmail(input sub, input {&email_list}).
                 
          END.
 END.
