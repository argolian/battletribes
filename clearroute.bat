@echo off
php artisan route:clear
php artisan route:cache
php artisan route:list  --columns Method,URI,Name,Action