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
 * report_drv.p
 * Driver Program for generating database reports 
 * Connection to progress database required 
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
DEFINE VARIABLE lccommand   AS CHARACTER   NO-UNDO.
DEFINE VARIABLE lcid        AS character   NO-UNDO.
DEFINE VARIABLE lcdbname    as character   NO-UNDO.
DEFINE VARIABLE lchost      AS character   NO-UNDO.
DEFINE VARIABLE lcserver    AS character   NO-UNDO.
DEFINE VARIABLE lclocation  AS character   NO-UNDO.
DEFINE VARIABLE lcdbuser  AS character   NO-UNDO.
DEFINE VARIABLE lcdbpass  AS character   NO-UNDO.

lcQuery = "'SELECT   dbuid, dbname, server, port, dblocation, dbuser, dbpass from  configureddb;'".
lccommand = "/usr/bin/mysql -u" + {&User} +
            " -p" + {&Pass} +
            " -h " + {&Hostname} +
            " -P " + {&Portno} + " " + {&Dbname} +
            " -N -e " + lcQuery.
                                                
INPUT THROUGH VALUE(lccommand).
{common.i}
{dbcheck.i}   
                                             
REPEAT:                
  IMPORT delimiter ' '  lcid lcdbname lchost lcserver lclocation lcdbuser lcdbpass NO-ERROR.
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
         run value(lcRepProcPath + "connect.p") (input lcid).
         run value(lcRepProcPath + "areagrowth.p") (input lcid).
   	 run value(lcRepProcPath + "birep.p") (input lcid). 
         run value(lcRepProcPath + "databaseio.p") (input lcid).
         run value(lcRepProcPath + "idxstat.p") (input lcid).
         run value(lcRepProcPath + "tableio.p") (input lcid).    
         run value(lcRepProcPath + "userio.p") (input lcid).    
         run value(lcRepProcPath + "longtrans.p") (input lcid).
         run value(lcRepProcPath + "dbsize.p") (input lcid).

    END. 
    ELSE
    DO: 
          Message "Unable to connect to database - " + lcdbname.
    END.
    disconnect value(cldbname) NO-ERROR.  
   END.
   ELSE
          MESSAGE "Error : Database " + lcdbname + " is unavailable or Down or not exists.".
END. 
