if exist temp rd /s /q temp
mkdir temp

:LOOP
if not exist temp goto LOOP

vendor/bin/phpunit CMN2000.php > temp/CMN2000.output
