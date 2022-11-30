<?php

namespace Corals\Modules\Utility\Location;

use Corals\Modules\Utility\Location\Facades\Address;
use Corals\Modules\Utility\Location\Models\Location;
use Corals\Modules\Utility\Location\Providers\UtilityAuthServiceProvider;
use Corals\Modules\Utility\Location\Providers\UtilityRouteServiceProvider;
use Corals\Settings\Facades\Modules;
use Corals\Settings\Facades\Settings;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class UtilityLocationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'utility-location');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'utility-location');

        $this->mergeConfigFrom(
            __DIR__ . '/config/utility-location.php',
            'utility-location'
        );
        $this->publishes([
            __DIR__ . '/config/utility-location.php' => config_path('utility-location.php'),
            __DIR__ . '/resources/views' => resource_path('resources/views/vendor/utility-location'),
        ]);

        $this->registerMorphMaps();
        $this->registerCustomFieldsModels();

        $this->registerModulesPackages();
    }

    public function register()
    {
        $this->app->register(UtilityAuthServiceProvider::class);
        $this->app->register(UtilityRouteServiceProvider::class);

        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Address', Address::class);
        });
    }

    protected function registerMorphMaps()
    {
        Relation::morphMap([
            'UtilityLocation' => Location::class,
        ]);
    }

    protected function registerCustomFieldsModels()
    {
        Settings::addCustomFieldModel(Location::class, 'Location (Utility)');
    }

    protected function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/utility-location');
    }
}
