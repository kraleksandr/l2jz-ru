@echo off

REM ############################################
REM ## You can change here your own DB params ##
REM ############################################
REM MYSQL BIN PATH
set mysqlBinPath=F:\Program Files\mysql5\bin

REM GAMESERVER
set gsuser=root
set gspass=
set gsdb=l2jdb
set gshost=localhost
REM ############################################

set mysqldumpPath="%mysqlBinPath%\mysqldump"
set mysqlPath="%mysqlBinPath%\mysql"

echo Installling L2JZ tables.
%mysqlPath% -h %gshost% -u %gsuser% --password=%gspass% -D %gsdb% < l2jz.sql

echo Setting correct flags.
%mysqlPath% -h %gshost% -u %gsuser% --password=%gspass% -D %gsdb% < set_flags.sql
pause