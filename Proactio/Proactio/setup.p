/* Procedure AddToPropath.p adds to PROPATH & runs Application Compiler */

DEFINE VARIABLE pth AS CHARACTER  NO-UNDO.
DEFINE VARIABLE locpath  AS CHARACTER  NO-UNDO.
DEFINE VARIABLE filepath AS CHARACTER  NO-UNDO.

INPUT THROUGH sh /getpath.sh value("MAINDIR").
IMPORT Unformatted locpath.
filepath = locpath + "PropathEntries.txt".

PROPATH = locpath + "," + PROPATH.
INPUT FROM value(filepath).
REPEAT:
    IMPORT UNFORMATTED pth.
    PROPATH = locpath + pth + "," + PROPATH.
END.

/* Compile drivers first */
MESSAGE "Compiling Drivers".
RUN compileDrivers.p.
/* Connect to testdb before compiling any other files. */
connect -db "compiledb" -ld value("jkt")  NO-ERROR.
IF ERROR-STATUS:ERROR THEN
 DO:
    DEFINE VARIABLE ix        AS INTEGER   NO-UNDO.
        DO ix = 1 TO ERROR-STATUS:NUM-MESSAGES:
            MESSAGE ERROR-STATUS:GET-NUMBER(ix) ERROR-STATUS:GET-MESSAGE(ix).
        END.
 END.
 ELSE IF CONNECTED ("jkt")  then
 DO:
        MESSAGE "Compiling Files".
	RUN compileOthers.p.
 END.
DISCONNECT "jkt".
QUIT.
/* RUN _comp.p. /* Opens Application compiler */ */
