@echo off
echo === VK CHEKKU ENNAI DATABASE SETUP ===
echo.
echo Step 1: Starting XAMPP services...
echo Please ensure XAMPP Control Panel is running and Apache + MySQL are started
echo.
echo Step 2: Opening phpMyAdmin...
start http://localhost/phpmyadmin
echo.
echo Step 3: In phpMyAdmin:
echo   - Click "New" in left sidebar
echo   - Database name: vk_chekku_ennai
echo   - Click "Create"
echo.
echo Step 4: Copy project files...
echo Copy your vk folder to: C:\xampp\htdocs\vk
echo.
echo Step 5: Run database setup...
echo Open browser to: http://localhost/vk/setup_database.php
echo.
echo Step 6: Test the website...
echo Open: http://localhost/vk/
echo.
echo Default admin login: admin / admin123
echo.
pause