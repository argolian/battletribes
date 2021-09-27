@echo off

echo Installing Voyager
composer require tcg/voyager
echo Running Voyager Installer
php artisan voyager:install --with-dummy
