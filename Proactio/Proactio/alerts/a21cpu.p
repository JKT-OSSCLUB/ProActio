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
 * CPU Utilization % alert
 * alert id  = 21
 * initial Threshold = 90%
 *
 *
 * alert generated when CPU is overloaded, CPU utilization more than Threshold value
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
Define input parameter serv as character.
Define input parameter dThreshold AS DECIMAL.        /* 90 */

DEFINE VARIABLE iAlertid        AS INTEGER    NO-UNDO INITIAL 21.
DEFINE VARIABLE dPrevThreshold  AS DECIMAL    NO-UNDO.
DEFINE VARIABLE cRes            AS CHARACTER  NO-UNDO.
DEFINE VARIABLE dUtil           AS DECIMAL    NO-UNDO.
DEFINE VARIABLE lcExecute       AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE lcQueryRes      AS CHARACTER  NO-UNDO INITIAL "".
DEFINE VARIABLE id              AS CHARACTER   NO-UNDO.
DEFINE VARIABLE sub             AS CHARACTER   NO-UNDO.

{mysql.i}
{email.i}

MESSAGE getdate() "Running cpu utilization script for server : " serv.
INPUT THROUGH sh value(lcScriptPath + "cpu.sh") value(serv).

IMPORT unformatted cRes.
/*dUtil = DECIMAL(cRes).*/
dUtil = DECIMAL(ENTRY(1,cRes,".")).
MESSAGE getdate() "Calculated CPU Utilization % :" string(dUtil).
if dUtil >= dThreshold then
DO:    
        lcExecute='SELECT info , alertid from alerts where  desc_id = ' + string(iAlertid) + ' AND dbid ="' + dbid + '" AND alert_read = 0 \'|sed \'s/\t/,/g'.
        lcQueryRes = mysqlSelect (input lcExecute).        
        
        if ( lcQueryRes = "" ) THEN
        DO:
           /* Run insert*/
           lcExecute = 'INSERT INTO alerts (desc_id,dbid,date,alert_read,info) VALUES (' 
                                                                + string(iAlertid) + ',"'
                                                                + dbid + '", NOW(),0,"'
                                                                + string(dUtil) + '% CPU Utilization.");'.
           id = mysqlInsert (input lcExecute).

        END.
        ELSE
        DO:
           dPrevThreshold = DECIMAL(ENTRY(1,lcQueryRes,"%")).
           if ( dUtil <> dPrevThreshold ) then
           DO:           
            lcExecute = 'UPDATE alerts SET info = "' + string(dUtil) + '% CPU Utilization.", date = NOW()
                                         WHERE dbid ="' + dbid + '" AND desc_id = ' + string(iAlertid) + ';'.      
            RUN  mysqlExecute (input lcExecute).
            id = ENTRY(2,lcQueryRes,",").
                                      
           END.
        END.
           if id <> "" then
           DO: /* generate email */
              sub = composemail(dbid,id).
              RUN sendalertmail(input sub, input {&email_list}).
              id = "".
           END.
                                                                                                 
END.


