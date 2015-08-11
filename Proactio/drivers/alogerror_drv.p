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
 * alogerror_drv.p
 * driver for Log File Error alert, requiring connection to Progress database and information from VSTs
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
{connect.i}                              
{mysql.i}
{common.i}

DEFINE VARIABLE cldbname    AS character   NO-UNDO INITIAL "jkt".                                                    
DEFINE VARIABLE lcQuery     AS character   NO-UNDO.
DEFINE VARIABLE lcid        AS character   NO-UNDO.
define variable lcdbname    as character format "x(50)".
DEFINE VARIABLE lchost      AS character   NO-UNDO.
DEFINE VARIABLE lcserver    AS character   NO-UNDO.
DEFINE VARIABLE lclocation  AS character   NO-UNDO.
DEFINE VARIABLE iAlertid    AS INTEGER    NO-UNDO INITIAL 14.
DEFINE VARIABLE cRes  AS character   NO-UNDO.
DEFINE VARIABLE lcExecute  as CHARACTER   no-undo.

lcQuery = "'SELECT  dbuid, dbname, server, port, dblocation   from  configureddb;'".
lccommand = "/usr/bin/mysql -u" + {&User} +
            " -p" + {&Pass} +
            " -h " + {&Hostname} +
            " -P " + {&Portno} + " " + {&Dbname} +
            " -N -e " + lcQuery.
                                                
INPUT THROUGH VALUE(lccommand).
                                                
REPEAT:                
    IMPORT delimiter ' ' lcid lcdbname lchost lcserver lclocation  NO-ERROR.
    RUN errcheck.
END.


PROCEDURE errcheck:
 MESSAGE getdate() "Searching errors for database : " lcid " - Running logerror.sh".
 INPUT THROUGH sh value(lcScriptPath + "logerror.sh") value(lclocation + lcdbname + ".lg") value(lcid) value(lchost).
 IMPORT unformatted cRes.
 Message cRes.
 IF ENTRY(2,cRes," ") <> "No" THEN
 DO:
     lcExecute = 'INSERT INTO `alerts` (`desc_id`, `dbid`, `date`, `alert_read`) VALUES (' +
                                                                              string(iAlertid) + ',"' + lcid + '",NOW(),0);'.
     RUN mysqlExecute(input lcExecute).
     OS-COMMAND   echo "Errors found in database log file. See attachment." | mailx -s "\"Errors in Log File for Database " value(lcid) \" -a value(lcTempPath +
lcid + ".errorlog") {&email_list}.   
 END.                                                                                                                       
END PROCEDURE.
