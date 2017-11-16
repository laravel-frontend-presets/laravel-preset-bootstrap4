# Laravel 5.5.x Front-end Preset For Bootstrap 4

Preset for Bootstrap 4 scaffolding on new Laravel 5.5.x project.

*Current version*: **Bootstrap 4 beta**

## Usage
1. Fresh install Laravel 5.5.x and `cd` to your app.
2. Install this preset via `composer require laravel-frontend-presets/bootstrap-4`. Laravel 5.5.x will automatically discover this package. No need to register the service provider.
3. Use `php artisan preset bootstrap4` for basic Bootstrap 4 preset. **OR** Use `php artisan preset bootstrap4-auth` for basic preset, Auth route entry and Bootstrap 4 Auth views in one go. (**NOTE**: If you run this command several times, be sure to clean up the duplicate Auth entries in `routes/web.php`)
4. `npm install`
5. `npm run dev`
6. Configure your favorite database (mysql, sqlite etc.)
7. `php artisan migrate` to create basic user tables.
8. `php artisan serve` (or equivalent) to run server and test preset.
