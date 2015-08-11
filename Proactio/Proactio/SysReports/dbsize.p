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
 * dbsize.p
 *
 * Takes data from _DbStatus table and loads in Proactio database for generating Db size growth Report.
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
 *	JK Technosoft
 *	http://www.jktech.com
 *	August 11, 2015
 *
 *
 * History:
 *
 */

DEFINE INPUT parameter dbid  AS CHARACTER.

DEFINE VARIABLE lcExecute    AS character   NO-UNDO.
DEFINE VARIABLE isizePerc    AS DECIMAL     NO-UNDO.
DEFINE VARIABLE sumhwter     AS INTEGER     NO-UNDO INITIAL 0. 
DEFINE VARIABLE sumtotblk    AS INTEGER     NO-UNDO INITIAL 0.
{mysql.i}
{common.i}

MESSAGE getdate() "Running dbsize.p script for database : " dbid.

FOR EACH _AreaStatus WHERE NOT (
            _Areastatus._AreaStatus-Areaname MATCHES('Primary Recovery Area*') OR
            _Areastatus._AreaStatus-Areaname MATCHES('Schema Area*') OR 
            _Areastatus._AreaStatus-Areaname MATCHES('Control Area*') OR
            _AreaStatus-Areaname  MATCHES('After Image Area*') )  NO-LOCK:
      sumhwter =  sumhwter + _AreaStatus-hiwater.
      sumtotblk = sumtotblk + _AreaStatus-totblocks.
END.

isizePerc = (sumhwter / sumtotblk )* 100.

lcExecute =  'INSERT INTO `dbsizerep`(`dbuid`, `date`, `size`) VALUES ("' +
                   dbid  + '",NOW(),' +
                   replace(string(isizePerc),',','.') + ');'.                    
 RUN mysqlExecute(input lcExecute).
                                                   
 









