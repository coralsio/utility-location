<?php

namespace Corals\Modules\Utility\Location\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Utility\Location\database\migrations\CreateAddressTables;
use Corals\Modules\Utility\Location\database\seeds\UtilityLocationDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateAddressTables::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilityLocationDatabaseSeeder = new UtilityLocationDatabaseSeeder();

        $utilityLocationDatabaseSeeder->rollback();
    }
}
