@echo off
echo Setting up VK Chekku Ennai database...

REM Copy project to htdocs
set "TARGET=C:\xampp\htdocs\vk"
if not exist "%TARGET%" (
    echo Copying project files to XAMPP...
    xcopy /E /I /Y "%~dp0" "%TARGET%"
) else (
    echo Project already exists in htdocs
)

echo.
set "XAMPP_PHP=C:\xampp\php\php.exe"
if exist "%XAMPP_PHP%" (
    echo Found XAMPP PHP at %XAMPP_PHP%
    echo Running database setup script...
    "%XAMPP_PHP%" "%TARGET%\setup_database.php"
    echo.
    echo If the script completed successfully, open: http://localhost/vk/
) else (
    echo Could not find XAMPP PHP at %XAMPP_PHP%.
    echo Please start XAMPP and then run the setup script manually.
    echo Opening phpMyAdmin so you can verify MySQL is running...
    start http://localhost/phpmyadmin
    echo.
    echo Then visit: http://localhost/vk/setup_database.php
)

echo.
echo Default admin: admin / admin123
echo.
pause