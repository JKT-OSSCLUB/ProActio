/*******************************************************************************
 *******************************************************************************
 **                                                                           **
 **                                                                           **
 **  Copyright 2015-2017 JK Technosoft                                                            **
 **  http://www.jktech.com                                                             **
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
 * birep.p
 *
 * Takes data from _Logging table and loads in Proactio database for generating BI summary Report.
 *
 * Parameters :
 *  --dbid : unique id assigned to that database - Type : CHARACTER
 *
 * Known Bugs & Issues:
 *
 *
 * Author:
 *
 *        JK Technosoft
 *        http://www.jktech.com
 *        August 11, 2015
 *
 *
 * History:
 *
 */
DEFINE INPUT PARAMETER dbid AS CHARACTER.
DEFINE VARIABLE lcExecute    AS CHARACTER   NO-UNDO.
DEFINE VARIABLE clsize       AS DECIMAL   NO-UNDO.
{mysql.i}
{common.i}
 
MESSAGE getdate() "Running birep.p script for database : " dbid.
FIND FIRST _ActBILog NO-LOCK NO-ERROR.
IF AVAILABLE _ActBILog THEN
DO: 
  FOR EACH _Logging NO-LOCK:           
       clsize =(_Logging-BiClSize / 1024).                            
       lcExecute =  'insert into bireport values("' +
                dbid + '",' +
                string(_Logging-bilogsize) + ',' + 
                string(clsize) + ',' +
                string(_ActBILog._BiLog-Trans) + ',NOW());' .
       RUN mysqlExecute(input lcExecute).                    
  END.
END.
ELSE
        MESSAGE getdate() "No _ActBILog record found.".
                                                                                             
                                                                                             












  
                   
















 
 


 
  
 






                            



                                          















                        


