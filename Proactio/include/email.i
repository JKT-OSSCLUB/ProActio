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
 * email.i
 * contains functions for sending alert notification emails
 *
 * Author:
 *
 *	JK Technosoft
 *	http://www.jktech.com
 *	August 11, 2015
 *
 *
 * History:
 */
{common.i}

PROCEDURE sendalertmail:
DEFINE INPUT PARAMETER subject AS CHARACTER.
DEFINE INPUT PARAMETER recepient_list AS CHARACTER.
 DEFINE VARIABLE filepath AS CHARACTER.
 filepath = lcTempPath + "maildescr.txt".

 OS-COMMAND cat value(filepath) | mailx -s \" value(subject)\"  value(recepient_list).
END PROCEDURE.
  
FUNCTION composemail RETURNS CHARACTER (INPUT dbid AS CHARACTER,INPUT alid AS CHARACTER):
DEFINE VARIABLE subject AS CHARACTER.
DEFINE VARIABLE filepath AS CHARACTER.
DEFINE VARIABLE lcDbinfo AS CHARACTER.
DEFINE VARIABLE lcAlertinfo AS CHARACTER.
  
filepath = lcTempPath + "maildescr.txt".

OUTPUT TO value(filepath).
lcDbinfo = getdbinfo(INPUT dbid).
lcAlertinfo = getalertinfo(INPUT alid).
subject = ENTRY(1,lcAlertinfo,",") + " Alert !! " + ENTRY(4,lcAlertinfo,",") + " in Database " + 
                  ENTRY(1,lcDbinfo,",") + " on Host " + 
                  ENTRY(2,lcDbinfo,",").  

    PUT "Database : " AT 2  ENTRY(1,lcDbinfo,",") FORMAT "X(20)" at 22 SKIP.
    PUT "Server : " AT 2  ENTRY(2,lcDbinfo,",") FORMAT "X(20)" AT 22 SKIP.
    PUT "Port Number : " AT 2  ENTRY(3,lcDbinfo,",") FORMAT "X(20)" AT 22 SKIP.
    PUT "Alert Description : " AT 2 ENTRY(4,lcAlertinfo,",") FORMAT "X(50)"  ENTRY(2,lcAlertinfo,",") FORMAT "X(100)" AT 22 SKIP.
    PUT "At Time : " AT 2  ENTRY(3,lcAlertinfo,",") FORMAT "X(20)" AT 22 SKIP.
OUTPUT CLOSE.
RETURN subject.
END.
