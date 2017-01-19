php artisan scout:import App\\Models\\Model
php artisan scout:import App\\Models\\Vehicle
php artisan scout:import App\\Models\\Customer

php artisan tntsearch:fix App\\Models\\Model
php artisan tntsearch:fix App\\Models\\Vehicle
php artisan tntsearch:fix App\\Models\\Customer

echo "*** Recordar cambiar los permisos"

# sudo chown dgtal:www-data storage/*.index
# sudo chmod 775 storage/*.index