<?php
namespace LaravelFrontendPresets\Bootstrap4Preset;

use Artisan;
use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset;

class Bootstrap4Preset extends Preset
{
    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install($withAuth = false)
    {
        static::updatePackages();
        static::updateSass();
        static::updateBootstrapping();
        static::updateMix();

        if($withAuth)
        {
            static::addAuthTemplates();
        }
        else
        {
            static::updateWelcomePage();
        }

        static::removeNodeModules();
    }

    /**
     * Update the given package array.
     *
     * @param  array  $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return [
            'bootstrap' => '^4.0.0-beta',
            'jquery' => '^3.2.1',
            'tether' => '^1.4.0',
            'popper.js' => '^1.12.4',
            'precss' => '^2.0.0',
        ] + Arr::except($packages, ['foundation-sites', 'bootstrap-sass', 'bulma', 'uikit']);
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function updateSass()
    {
        // clean up orphan files
        $orphan_sass_files = glob(resource_path('/assets/sass/*.*'));

        foreach($orphan_sass_files as $sass_file)
        {
            (new Filesystem)->delete($sass_file);
        }

        copy(__DIR__.'/bootstrap4-stubs/_custom.scss', resource_path('assets/sass/_custom.scss'));
        copy(__DIR__.'/bootstrap4-stubs/app.scss', resource_path('assets/sass/app.scss'));
    }

    /**
     * Update the bootstrapping files.
     *
     * @return void
     */
    protected static function updateBootstrapping()
    {
        (new Filesystem)->delete(
            resource_path('assets/js/bootstrap.js')
        );

        copy(__DIR__.'/bootstrap4-stubs/bootstrap.js', resource_path('assets/js/bootstrap.js'));
    }

    /**
     * Update the mix file.
     * 
     * @return void
     */
    protected static function updateMix()
    {
        (new Filesystem)->delete(
            base_path('webpack.mix.js')
        );

        copy(__DIR__.'/bootstrap4-stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    /**
     * Update the default welcome page file with Foundation buttons.
     *
     * @return void
     */
    protected static function updateWelcomePage()
    {
        // remove default welcome page
        (new Filesystem)->delete(
            resource_path('views/welcome.blade.php')
        );

        // copy new one with Bootstrap buttons
        copy(__DIR__.'/bootstrap4-stubs/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }

    /**
     * Copy Bootstrap Auth view templates.
     *
     * @return void
     */
    protected static function addAuthTemplates()
    {
        // Add Home controller
        copy(__DIR__.'/bootstrap4-stubs/Controllers/HomeController.php', app_path('Http/Controllers/HomeController.php'));

        // Add Auth route in 'routes/web.php'
        $auth_route_entry = "Auth::routes();\n\nRoute::get('/home', 'HomeController@index')->name('home');\n\n";
        file_put_contents('./routes/web.php', $auth_route_entry, FILE_APPEND);

        // Copy Bootstrap4 Auth view templates
        (new Filesystem)->copyDirectory(__DIR__.'/bootstrap4-stubs/views', resource_path('views'));
    }
}
