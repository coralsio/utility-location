<?php

namespace Corals\Modules\Utility\Location\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Utility\Location\database\migrations\CreateAddressTables;
use Corals\Modules\Utility\Location\database\seeds\UtilityLocationDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateAddressTables::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilityLocationDatabaseSeeder = new UtilityLocationDatabaseSeeder();

        $utilityLocationDatabaseSeeder->run();
    }
}
