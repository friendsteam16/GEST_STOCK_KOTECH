@echo off
title Lancer Laravel + Vite

REM === Chemin vers ton projet Laravel ===
cd /d C:\wamp64\www\laravel-projects\test

REM === Démarrer Laravel avec PHP 8.4.5 ===
start "Laravel Server" cmd /k "C:\wamp64\bin\php\php8.4.5\php artisan serve"

REM === Ouvre Vite dans une autre fenêtre CMD ===
start "Vite (npm run dev)" cmd /k "npm run dev"

REM === Ouvre le navigateur automatiquement ===
start http://localhost:8000
