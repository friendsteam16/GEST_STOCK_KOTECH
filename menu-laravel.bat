@echo off
title Laravel Project Launcher
color 0A

:menu
cls
echo ===================================================
echo            🚀 LARAVEL LAUNCHER - BY PACÔME
echo ===================================================
echo.
echo  1. Lancer Laravel en mode DEVELOPPEMENT (npm run dev)
echo  2. Compiler pour la PRODUCTION (npm run build)
echo  3. Quitter
echo.
set /p choix=" Ton choix [1-3] : "

if "%choix%"=="1" goto dev
if "%choix%"=="2" goto build
if "%choix%"=="3" exit
goto menu

:dev
cd /d C:\wamp64\www\laravel-projects\test
start "Laravel Server" cmd /k "php artisan serve"
start "Vite (npm run dev)" cmd /k "npm run dev"
start http://127.0.0.1:8000
goto end

:build
cd /d C:\wamp64\www\laravel-projects\test
start "Build Laravel (npm run build)" cmd /k "npm run build"
goto end

:end
pause
