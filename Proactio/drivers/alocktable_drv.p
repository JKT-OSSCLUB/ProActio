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
 * alocktable_drv.p
 * Driver for Lock table alert
 * Connection to Progress database Required
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
DEFINE VARIABLE cldbname    AS character   NO-UNDO INITIAL "jkt".                                                    
DEFINE VARIABLE lcQuery     AS character   NO-UNDO.
DEFINE VARIABLE lcid        AS character   NO-UNDO.
DEFINE VARIABLE lccommand   AS CHARACTER   NO-UNDO.
define variable lcdbname    as character format "x(50)".
DEFINE VARIABLE lchost      AS character   NO-UNDO.
DEFINE VARIABLE lcserver    AS character   NO-UNDO.
DEFINE VARIABLE lclocation  AS CHARACTER   NO-UNDO.
DEFINE VARIABLE lcdbuser    AS character   NO-UNDO.
DEFINE VARIABLE lcdbpass    AS character   NO-UNDO.
DEFINE VARIABLE dThreshold  AS Decimal NO-UNDO.

/*Threshold value*/
ASSIGN dThreshold = 50.00.


lcQuery = "'SELECT  dbuid, dbname, server, port, dblocation, dbuser, dbpass   from  configureddb;'".
lccommand = "/usr/bin/mysql -u" + {&User} +
            " -p" + {&Pass} +
            " -h " + {&Hostname} +
            " -P " + {&Portno} + " " + {&Dbname} +
            " -N -e " + lcQuery.
                                                
INPUT THROUGH VALUE(lccommand).
{common.i}
{dbcheck.i}


REPEAT:                
   IMPORT delimiter ' ' lcid lcdbname lchost lcserver lclocation lcdbuser lcdbpass NO-ERROR.
   IF isRunning(lclocation + lcdbname) THEN
   DO:
    connect -db  value(lcdbname) -ld value(cldbname) -H value(lchost) -S value(lcserver) -U value(lcdbuser) -P value(lcdbpass) NO-ERROR.
    IF ERROR-STATUS:ERROR THEN
    DO:
    DEFINE VARIABLE ix        AS INTEGER   NO-UNDO.
        DO ix = 1 TO ERROR-STATUS:NUM-MESSAGES:
            MESSAGE ERROR-STATUS:GET-NUMBER(ix) ERROR-STATUS:GET-MESSAGE(ix).
        END.     
    END.
    ELSE IF CONNECTED (cldbname)  then
    DO:
        MESSAGE getdate() "Connected to " + lcdbname + " successfully".
        run value(lcAlProcPath + "a2LockTable.p") (input lcid,input dThreshold). 
    END. 
    ELSE
    DO: 
          Message getdate() "Unable to connect to database - " + lcdbname.
    END.
    disconnect value(cldbname) NO-ERROR.
   END.
   ELSE
      MESSAGE getdate() "Error : Database " + lcdbname + " is Unavailable or Down or not exists.".
                  
END.

