@echo off
IF "%1" =="" (
echo You must specify a route name
goto end
)
php artisan route:list --name=%1   --columns Method,URI,Name,Action
:end
