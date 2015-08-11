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
 * server_alert_drv.p
 * driver program for running server monitoring alerts  
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
{common.i}                                                                                 
DEFINE VARIABLE lcQuery     AS character   NO-UNDO.
DEFINE VARIABLE lclocation  AS CHARACTER   NO-UNDO.
DEFINE VARIABLE lcid        AS character   NO-UNDO.
DEFINE VARIABLE lcdbname    AS character   NO-UNDO.
DEFINE VARIABLE lcserver    AS CHARACTER   NO-UNDO.
DEFINE VARIABLE cRetcode    AS CHARACTER   NO-UNDO.
DEFINE VARIABLE lcExecute   AS CHARACTER   NO-UNDO.
DEFINE VARIABLE lccommand   AS CHARACTER   NO-UNDO.
DEFINE VARIABLE CPU_Thold AS DECIMAL NO-UNDO.
DEFINE VARIABLE DISKIO_Thold AS DECIMAL NO-UNDO.
DEFINE VARIABLE PHYMEM_Thold AS DECIMAL NO-UNDO.
DEFINE VARIABLE SWAPMEM_Thold AS DECIMAL NO-UNDO.
DEFINE VARIABLE DISKFREE_Thold AS DECIMAL NO-UNDO.

ASSIGN CPU_Thold = 90
        DISKIO_Thold = 90
        PHYMEM_Thold = 10
        SWAPMEM_Thold = 10
        DISKFREE_Thold = 10.

lcQuery = "'SELECT  dbuid, dbname, server, dblocation from  configureddb group by server;'".
lccommand = "/usr/bin/mysql -u" + {&User} +
            " -p" + {&Pass} +
            " -h " + {&Hostname} +
            " -P " + {&Portno} + " " + {&Dbname} +
            " -N -e " + lcQuery.
    
INPUT THROUGH VALUE(lccommand).
REPEAT:                
        IMPORT delimiter ' '  lcid lcdbname lcserver lclocation NO-ERROR.
        RUN dbchk.
END.               

PROCEDURE dbchk:
 INPUT THROUGH sh value(lcScriptPath + "dbcheck.sh") value(lclocation + lcdbname).
 IMPORT unformatted cRetCode.
 if cRetCode <> string(2) then
         DO:
             run value(lcAlProcPath + "a21cpu.p") (input lcid, input lcserver,input CPU_Thold).
             run value(lcAlProcPath + "a22diskio.p") (input lcid, input lcserver,input DISKIO_Thold).
             run value(lcAlProcPath + "a23physicalmem.p") (input lcid, input lcserver,input PHYMEM_Thold).
             run value(lcAlProcPath + "a24swapmem.p") (input lcid, input lcserver,input SWAPMEM_Thold).
             run value(lcAlProcPath + "a25diskfree.p") (input lcid, input lcserver,input DISKFREE_Thold).
         END.
  ELSE
         Message getdate() "Unable to find database : " + lcdbname + " on server :" + lcserver.
         
END PROCEDURE.
                                               

