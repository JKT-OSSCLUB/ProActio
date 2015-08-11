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
 * bisize.i
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
 * BI size calculation
 * Returns size of bi file if size is greater than threshold value else returns -1
 * Threshold values can be modified. 
 * Current threshold values 50 MB (Minor alert), 1000 MB (Major alert), 1400 MB (Critical alert)
 *
 */
FUNCTION getSize RETURNS DECIMAL(OUTPUT iId AS INTEGER, OUTPUT iThold AS INTEGER):
 DEFINE VARIABLE dSize      AS DECIMAL    NO-UNDO. 
 DEFINE VARIABLE dThreshold1      AS DECIMAL    NO-UNDO INITIAL 50.00.
 DEFINE VARIABLE dThreshold2      AS DECIMAL    NO-UNDO INITIAL 1000.00.
 DEFINE VARIABLE dThreshold3      AS DECIMAL    NO-UNDO INITIAL 1400.00.
 FIND FIRST _DbStatus NO-LOCK.
 FIND FIRST _AreaStatus WHERE _AreaStatus-Areaname = "Primary Recovery Area" no-lock.
 dSize = (_DbStatus-BiBlkSize  * _AreaStatus-hiwater) / (1024 * 1024) .
 MESSAGE "Current BI size : " string(dSize) "MB".
 CASE TRUE:
    WHEN dSize < dThreshold1 THEN
       ASSIGN dSize = -1.
    WHEN  dSize < dThreshold2 THEN
       ASSIGN iId = 3 iThold = dThreshold1.
    WHEN  dSize < dThreshold3 THEN
        ASSIGN iId = 6 iThold =  dThreshold2.
    WHEN  dSize > dThreshold3 THEN
         ASSIGN iId = 7 iThold = dThreshold3.
 END CASE.
RETURN dSize.
END. 
