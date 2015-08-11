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
 * adbdown_drv.p
 * Driver program for database down alert
 * No connection to Progress database required
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
DEFINE VARIABLE lccommand   AS CHARACTER   NO-UNDO.
DEFINE VARIABLE lclocation  AS CHARACTER   NO-UNDO.
DEFINE VARIABLE lcid        AS character   NO-UNDO.
DEFINE VARIABLE lcdbname    AS CHARACTER   NO-UNDO.

lcQuery = "'SELECT  dbuid, dblocation, dbname  from  configureddb;'".
lccommand = "/usr/bin/mysql -u" + {&User} +
            " -p" + {&Pass} +
            " -h " + {&Hostname} +
            " -P " + {&Portno} + " " + {&Dbname} +
            " -N -e " + lcQuery.
    
INPUT THROUGH VALUE(lccommand).
REPEAT:                
        IMPORT delimiter ' '  lcid lclocation lcdbname NO-ERROR.
        run value(lcAlProcPath + "a1dbdown.p") (input lcid , input lclocation + lcdbname).
END. 
