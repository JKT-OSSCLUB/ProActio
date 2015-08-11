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
 *
 * idxstat.p
 *
 * Takes data from _IndexStat and _Index tables and loads in Proactio database for generating Index Report.
 *
 * Parameters :
 *  --dbid : unique id assigned to that database - Type : CHARACTER
 *
 * Known Bugs & Issues:
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

DEFINE INPUT PARAMETER dbid AS CHARACTER.
DEFINE VARIABLE lcExecute    AS character   NO-UNDO.
{mysql.i}
{common.i}

MESSAGE getdate() "Running idxstat.p script for database :" dbid .

FOR EACH _file WHERE _file-number > 0 and _file-number < 32768 NO-LOCK:
     FOR EACH _index OF _File NO-LOCK:
            FOR each _indexstat where  _INDEXstat._Indexstat-id = _Index._idx-num no-lock:
                                                           
               lcExecute =  'insert into idxstat values("' +
                   dbid + '",NOW(),' +
                   string(_indexstat._Indexstat-id) + ',' +
                   string(_indexstat._Indexstat-blockdelete) + ',' +
                   string(_indexstat._Indexstat-create) + ',' +
                   string(_indexstat._Indexstat-delete) + ',' +
                   string(_indexstat._Indexstat-read) + ',"' +
                   _index._index-name + '",' +
                   string(_indexstat._Indexstat-split) + ');'.           
   
                  RUN mysqlExecute(input lcExecute). 
END.
END.   
END.   








    
