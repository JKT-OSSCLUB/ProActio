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
 * locktable.i  
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
 * Lock Table %free calculation
 * Returns information in form of Numlocks/MostLocks if Lock Table (-L)% is greater than threshold value 
 *
 */
FUNCTION getInfo RETURN CHARACTER  (INPUT dThreshold AS DECIMAL,OUTPUT dCurhwater as INTEGER):
 DEFINE VARIABLE lcInfo       AS CHARACTER  NO-UNDO INITIAL "".
 DEFINE VARIABLE dPercFree    AS DECIMAL    NO-UNDO.

 FIND FIRST _DbStatus no-lock.
 FIND FIRST _startup no-lock.
 dPercFree = ( _DbStatus-NumLocks * 100) / _Startup-LockTable.
 MESSAGE "Current (-L) Used Percentage : " string(dPercFree).
 MESSAGE "% Lock Table Entries in use(NumLocks)/Lock Table Hiwater mark(MostLocks) : " STRING(_DbStatus-NumLocks) + "/" + string(_DbStatus-MostLocks).
   
 IF dPercFree > dThreshold THEN
 DO:
        lcInfo = STRING(_DbStatus-NumLocks) + "/" + string(_DbStatus-MostLocks).
        dCurhwater = _DbStatus-MostLocks.
 END.

RETURN lcInfo.
END. 
