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
 * server_report_drv.p
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
DEFINE VARIABLE lcQuery     AS character   NO-UNDO.
DEFINE VARIABLE lclocation  AS CHARACTER   NO-UNDO.
DEFINE VARIABLE lcid        AS character   NO-UNDO.
DEFINE VARIABLE lcdbname    AS character   NO-UNDO.
DEFINE VARIABLE lcserver    AS CHARACTER   NO-UNDO.
DEFINE VARIABLE cRetcode    AS CHARACTER   NO-UNDO.
DEFINE VARIABLE lcExecute   AS CHARACTER   NO-UNDO.
{mysql.i}
{common.i}

lcQuery = "'SELECT  dbuid, dbname, server, dblocation  from  configureddb group by server;'".
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
    /* No ned to check for database when server is being monitored
    INPUT THROUGH sh value(lcScriptPath + "dbcheck.sh") value(lclocation + lcdbname).
    IMPORT unformatted cRetCode.
    if cRetCode <> string(2) then
    DO:
    */
	 Message getdate() "Generating Server Monitoring Reports for :"  + lcserver.
         RUN diskinsert(input lcserver).   
         RUN meminsert(input lcserver).  
         RUN cpuinsert(input lcserver).   
    /* END.                                               
    ELSE
         Message "Unable to find database : " + lcdbname + " on server :" + lcserver.       
    */	
END PROCEDURE.

PROCEDURE diskinsert :
DEFINE INPUT PARAMETER lcserv  as char.
 Message getdate() "Running diskrep.sh ".
 INPUT THROUGH sh value(lcScriptPath + "diskrep.sh") value(lcserver). 
 REPEAT:
 IMPORT unformatted cRetcode.

 lcExecute = 'insert into diskrep  values("' + lcid + '",NOW(),' +
                                                         ENTRY(1,cRetcode,' ') + ',' +
                                                         ENTRY(2,cRetcode,' ') + ',' +
                                                         ENTRY(3,cRetcode,' ') + ',"' +
							 ENTRY(4,cRetcode,' ') + '");'.                                                         
  RUN mysqlExecute(input lcExecute).
 END.
END PROCEDURE.

PROCEDURE cpuinsert:
DEFINE INPUT PARAMETER lcserv  as char.
 Message getdate() "Running cpurep.sh ".
 INPUT THROUGH sh value(lcScriptPath + "cpurep.sh") value(lcserver).
 IMPORT unformatted cRetcode.
  lcExecute = 'insert into cpurep  values(NOW(),"' + lcid + '",' +
                                                        ENTRY(1,cRetcode,',') + ',' +
                                                        ENTRY(2,cRetcode,',') + ',' +
                                                        ENTRY(3,cRetcode,',') + ',' +
                                                        ENTRY(4,cRetcode,',') + ',' + 
                                                        ENTRY(5,cRetcode,',') + ',' +
                                                        ENTRY(6,cRetcode,',') + ');'.

  RUN mysqlExecute(input lcExecute).
END PROCEDURE.

               
PROCEDURE meminsert:
DEFINE INPUT PARAMETER lcserv  as char.
Message getdate() "Running memrep.sh".
 INPUT THROUGH sh value(lcScriptPath + "memrep.sh") value(lcserver).
 IMPORT unformatted cRetcode.
 lcExecute = 'insert into memrep  values("' + lcid + '",NOW(),' +
                                                       ENTRY(1,cRetcode,' ') + ',' +
                                                       ENTRY(2,cRetcode,' ') + ',' +
                                                       ENTRY(3,cRetcode,' ') + ',' +
                                                       ENTRY(4,cRetcode,' ') + ',' +
                                                       ENTRY(5,cRetcode,' ') + ',' +
                                                       ENTRY(6,cRetcode,' ') + ');'.
                                                                                                                  
 RUN mysqlExecute(input lcExecute).
END PROCEDURE.
                                                          
