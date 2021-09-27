@echo off
Echo Recreating application databases
php artisan migrate:fresh --step 
Echo Seeding tables
php artisan db:seed
call models.bat 
