@echo off
IF "%1" =="" (
echo You must specify a file type and a file name
goto end
)
IF "%2"=="" (
echo You must specify a file name
goto end
)


@php artisan make:%1 %2 %3 %4

if "%1" == "model" (
php artisan ide-helper:models -W
)

:end