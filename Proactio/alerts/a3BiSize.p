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
 * BI size alert
 * alert id  = 3
 *
 * Calculates BI file size and generates alert if the size grows above a threshold. Uses `bisize.i` to calculate bi file size. 
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

DEFINE INPUT parameter dbid AS CHARACTER.

DEFINE VARIABLE iAlertid        AS INTEGER    NO-UNDO INITIAL 3.
DEFINE VARIABLE lcExecute       AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE lcQueryRes      AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE dPrevSize       AS INTEGER    NO-UNDO INITIAL 0.00.
DEFINE VARIABLE dCursize        AS INTEGER    NO-UNDO.
DEFINE VARIABLE id              AS CHARACTER   NO-UNDO.
DEFINE VARIABLE sub             AS CHARACTER   NO-UNDO.
DEFINE VARIABLE dThreshold      AS Decimal.
{mysql.i}
{bisize.i}
{email.i} 

 dCursize = getSize( OUTPUT iAlertid, OUTPUT dThreshold) .
 lcExecute = 'Select `info` from alerts where dbid = "' + dbid + '" AND desc_id = ' + string(iAlertid) + ' AND alert_read = 0 order by info asc;'.
 lcQueryRes = mysqlSelect(lcExecute).
 dPrevSize = INTEGER(lcQueryRes).

 IF ( dCurSize = -1 ) THEN
 DO:
        /* Perform update for prev issue resolved. */
        lcExecute = 'UPDATE `alerts` SET  `enddate`= NOW() ,`alert_read`= 1 WHERE desc_id IN (3,6,7) AND dbid = "' + dbid + '" AND alert_read = 0;'.
        RUN mysqlExecute(lcExecute).
 END.
 ELSE
 DO:
        IF ( lcQueryRes <> "" ) THEN
        dPrevSize = INTEGER(lcQueryRes).
        IF (dCursize > dPrevSize ) THEN
        DO:
                 /* Perform insert for new information */
                   lcExecute =  
                        'INSERT INTO `alerts`(`desc_id`, `dbid`, `date`, `alert_read`, `info`) VALUES (' +
                        string(iAlertid) + ',"' +
                        dbid + '",NOW(),0,"' +
                        string(dCursize) + '");'.
                id =  mysqlInsert(lcExecute).
                /*email*/
                sub = composemail(dbid,id).
                RUN sendalertmail(input sub, input {&email_list}).
        END.
 END.
 
