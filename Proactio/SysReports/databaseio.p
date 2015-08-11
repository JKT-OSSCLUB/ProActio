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
 * databaseio.p
 *
 * Takes data from _ActSummary table and loads in Proactio database for generating Database IO Report.
 *
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

DEFINE INPUT PARAMETER dbid AS  CHARACTER.
DEFINE VARIABLE lcExecute   AS CHARACTER   NO-UNDO.
{mysql.i}
{common.i}

MESSAGE getdate() "Running databaseio.p script for database : " dbid.
FOR  EACH _ActSummary NO-LOCK:
  /*if  = ? or
        = ? or
        = ? then
              next.
  */
        lcExecute =  'insert into databaseio values("' +
               dbid + '",NOW(),' +
               string(_Summary-Commits) + ',' +
               string(_Summary-Undos) + ',' +
               string(_Summary-RecUpd) + ',' +
               string(_Summary-RecReads) + ',' +
               string(_Summary-RecCreat) + ',' +
               string(_Summary-RecDel) + ',' +
               string(_Summary-DbWrites) + ',' +
               string(_Summary-DbReads) + ',' +
               string(_Summary-RecLock) + ',' +
               string(_Summary-RecWait) + ',' +
               string(_Summary-Chkpts) + ',' +
               string(_Summary-Flushed) + ');'.
        RUN mysqlExecute(input lcExecute).
END.
    
    
  

















    




                     
