<?php

namespace Flute\Modules\Rules\src\ServiceProviders;

use Flute\Core\Support\ModuleServiceProvider;
use Flute\Modules\Rules\src\ServiceProviders\Extensions\AdminExtension;
use Flute\Modules\Rules\src\Widgets\RulesWidget;

class RulesServiceProvider extends ModuleServiceProvider
{
    public array $extensions = [
        AdminExtension::class
    ];

    public function boot(\DI\Container $container): void
    {
        $this->loadEntities();
        $this->loadTranslations();
        $this->loadRoutesFrom('app/Modules/Rules/src/routes.php');

        widgets()->register(new RulesWidget);
    }

    public function register(\DI\Container $container): void
    {
        $this->loadTranslations();
    }
}