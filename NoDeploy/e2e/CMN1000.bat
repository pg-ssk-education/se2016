if exist temp rd /s /q temp
mkdir temp

:LOOP
if not exist temp goto LOOP

vendor/bin/phpunit CMN1000.php > temp/CMN1000.output
