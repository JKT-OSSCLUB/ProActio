/*******************************************************************************
 *******************************************************************************
 **                                                                           **
 **                                                                           **
 **  Copyright 2015-2017 J K Technosoft                  					  **
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
 * compile.p 
 * common code for compiling files in a directory
 *
 * Author:
 *
 *	J K Technosoft
 *	http://www.jktech.com
 *	August 11, 2015
 *
 *
 * History:
 *
 */

DEFINE INPUT PARAMETER cDirectoryList AS CHARACTER NO-UNDO.
DEFINE INPUT PARAMETER cTargetDiretory AS CHARACTER NO-UNDO.

DEFINE VARIABLE iCount as Integer No-Undo INITIAL 0.
DEFINE VARIABLE cCurrentDiretory AS CHARACTER NO-UNDO.
DEFINE VARIABLE cCurrentFile AS CHARACTER NO-UNDO.
DEFINE VARIABLE iCounterVariable AS INTEGER NO-UNDO.
DEFINE STREAM myStream.

DO iCounterVariable = 1 TO NUM-ENTRIES(cDirectoryList):
    ASSIGN
        cCurrentDiretory = ENTRY(iCounterVariable, cDirectoryList).
      INPUT STREAM myStream FROM OS-DIR(cCurrentDiretory).
    REPEAT:
        /* Get the current directory's .p files only */
        /* Compile and save in the target directory */
        IMPORT STREAM myStream cCurrentFile.
        IF LENGTH(cCurrentFile) < 3 THEN NEXT.
        IF cCurrentFile MATCHES "*~~.p" THEN
        DO:
            COMPILE VALUE(cCurrentDiretory + "/" + cCurrentFile) SAVE INTO VALUE(cTargetDiretory). 
            iCount = iCount + 1.
        END.
    END.
    Message "Compilation Finished." skip "Directory :" cCurrentDiretory skip "No of Files Compiled = " iCount VIEW-AS ALERT-BOX.
    iCount = 0.
END.
