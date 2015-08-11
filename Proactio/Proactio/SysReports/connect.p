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
 * connect.p
 *
 * Takes data from _Connect table and loads in Proactio database for generating Database Connection summary Report.
 *
 * Parameters :
 *  --dbid : unique id assigned to that database - Type : CHARACTER
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
DEFINE VARIABLE lcExecute  AS CHARACTER   NO-UNDO.
{mysql.i}
{common.i}

MESSAGE getdate() "Running connect.p script for database :" dbid.

FOR  EACH _Connect NO-LOCK:
               
     IF _Connect._Connect-name = ? or
        _Connect._Connect-type = ? or
        _Connect._Connect-time = ? then
             next.                                    
     lcExecute = 'insert into connect values("' +
                dbid + '",NOW(),"' +
                _Connect-name + '","' +
                _Connect-type + '","' +
                _Connect-Device + '","' +
                _Connect-time + '",' +
                string(_Connect._Connect-pid) + ',' +
                string(_Connect-Usr) + ');' .
 
 RUN mysqlExecute(input lcExecute).
                                 
END.
                                                                                             
                                                                                             












  
                   
















 
 


 
  
 






                            



                                          















                        


