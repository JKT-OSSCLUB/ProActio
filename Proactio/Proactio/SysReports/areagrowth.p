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
 **  See TNC.TXT for more information regarding the Terms and Conditions    **
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
 * 
 *
 * areagrowth.p
 *
 * Takes data from _AreaStatus table and loads in Proactio database for generating Area Status summary Report.
 * If no hiwater mark specified mysql will store -1 as hiwater
 *
 * Parameters :
 *  --dbid : unique id assigned to that database - Type : CHARACTER
 *
 * Known Bugs & Issues:
 *
 *
 * Author:
 *
 *      JK Technosoft
 *      http://www.jktech.com
 *      August 11, 2015
 *
 *
 * History:
 *
 */

DEFINE INPUT parameter dbid  AS CHARACTER.

DEFINE VARIABLE lcExecute    AS character   NO-UNDO.
DEFINE VARIABLE hwater     AS INTEGER   NO-UNDO.
DEFINE VARIABLE blksz AS INTEGER     NO-UNDO. 
{mysql.i}
{common.i}

MESSAGE getdate() "Running areagrowth.p script for database : " dbid.

FIND FIRST _DbStatus NO-LOCK.
blksz = _DbStatus-dbblksize / 1024.

FOR EACH _AreaStatus where NOT (
             _Areastatus._AreaStatus-Areaname MATCHES('Primary Recovery Area*') OR
             _Areastatus._AreaStatus-Areaname MATCHES('Schema Area*') OR
             _Areastatus._AreaStatus-Areaname MATCHES('Control Area*') OR
             _AreaStatus-Areaname  MATCHES('After Image Area*') )  NO-LOCK:
                                                 
if _AreaStatus-Areaname = ?  then
  next.
if _AreaStatus-hiwater = ?  then
     hwater = -1.
else
     hwater = _AreaStatus-hiwater * blksz.                                               

     lcExecute =  'INSERT INTO `areagrowth`(`dbid`, `date`, `areaname`, `totalalloc`, `hiwater`) VALUES ("' +
                     dbid  + '",' +
                     "NOW()" + ',"' +
                     _AreaStatus-Areaname  + '",' +
                      string(_Areastatus-Totblocks * blksz) + ',' +
                      string(hwater)  + ');'.   
                          
     RUN mysqlExecute(input lcExecute).
end.
                                                   
 









