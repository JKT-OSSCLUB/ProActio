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
 * mysql.i
 * contains common functions for inserting querying updating Proactio database
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
DEFINE VARIABLE lcConnect as CHARACTER NO-UNDO.
DEFINE VARIABLE lcCommand as CHARACTER NO-UNDO.
DEFINE VARIABLE lcMail as CHARACTER NO-UNDO.

lcConnect = "/usr/bin/mysql -u" + {&User} +
            " -p" + {&Pass} +
            " -h " + {&Hostname} +
            " -P " + {&Portno} + " " + {&Dbname} +
            " -N -e '".

/* Executes the Query passed as argument. Used for insert, update delete query */
PROCEDURE mysqlExecute :
 DEFINE INPUT PARAMETER lcQuery AS CHARACTER. 
 DEFINE VARIABLE lcLine    as CHARACTER NO-UNDO INITIAL "".
 lcCommand = lcConnect + lcQuery + "'".
 INPUT THROUGH VALUE(lcCommand).        
 IMPORT unformatted lcLine NO-ERROR.
 IF lcLine BEGINS "ERROR" THEN 
        MESSAGE lcLine.
END PROCEDURE.


/*Executes the Query passed as argument returning results of query. Used for select query */

FUNCTION mysqlSelect RETURN CHARACTER  (INPUT lcQuery AS CHARACTER):
 DEFINE VARIABLE lcLine    as CHARACTER NO-UNDO.
 lcLine = "". 
 lcCommand = lcConnect + lcQuery + "'".
 INPUT THROUGH VALUE(lcCommand).
        REPEAT:
           IMPORT  unformatted  lcLine  NO-ERROR.
        END.
 RETURN lcLine.
END.

/* insert and get id of last inserted row*/
FUNCTION mysqlInsert RETURNS CHARACTER (INPUT lcQuery AS CHARACTER):
 DEFINE VARIABLE id        as CHARACTER NO-UNDO INITIAL "-1".
 DEFINE VARIABLE lcLine    as CHARACTER NO-UNDO INITIAL "".
 lcCommand = lcConnect + lcQuery + ";SELECT LAST_INSERT_ID();'".
  INPUT THROUGH VALUE(lcCommand).        
  IMPORT unformatted lcLine NO-ERROR.
  IF lcLine BEGINS "ERROR" THEN 
        MESSAGE lcLine.
 ELSE
 id = lcLine.
 RETURN id.
END.

/* get dbinfo from configureddb table */
FUNCTION getdbinfo RETURN CHARACTER (INPUT dbid AS CHARACTER):
 DEFINE VARIABLE lcQuery AS CHARACTER.
 DEFINE VARIABLE lcDbinfo AS CHARACTER.

 lcQuery = 'SELECT dbuid,
                   server,
                   port 
            FROM configureddb where dbuid = "' + dbid + '" \'|sed \'s/\t/,/g'.
 lcCommand = lcConnect + lcQuery + "'".
 INPUT THROUGH VALUE(lcCommand).        
 IMPORT unformatted lcDbinfo NO-ERROR.
 IF lcDbinfo BEGINS "ERROR" THEN 
        MESSAGE lcDbinfo.
 RETURN lcDbinfo.
END.

/* get Alert information based on alertid*/
FUNCTION getalertinfo RETURN CHARACTER (INPUT alid AS CHARACTER):
 DEFINE VARIABLE lcQuery AS CHARACTER.
 DEFINE VARIABLE lcAlertinfo AS CHARACTER.

 lcQuery = "SELECT alerttype,
                   info,
                   date,
                   alertdisc
             FROM alerts, alertdesc
             WHERE alertid = " + alid + " AND alerts.desc_id = alertdesc.desc_id '|sed 's/\t/,/g".
 lcCommand = lcConnect + lcQuery + "'".
 INPUT THROUGH VALUE(lcCommand).        
 IMPORT unformatted lcAlertinfo NO-ERROR.
 IF lcAlertinfo BEGINS "ERROR" THEN 
        MESSAGE lcAlertinfo.
 RETURN lcAlertinfo.
END.


