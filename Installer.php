<?php

namespace Flute\Modules\Rules;

use Flute\Core\Database\Entities\Permission;
use Flute\Modules\Rules\src\Widgets\RulesWidget;

class Installer extends \Flute\Core\Support\AbstractModuleInstaller
{
    public function install(\Flute\Core\Modules\ModuleInformation &$module): bool
    {
        $permission = rep(Permission::class)->findOne([
            'name' => 'admin.rules'
        ]);

        if (!$permission) {
            $permission = new Permission;
            $permission->name = 'admin.rules';
            $permission->desc = 'rules.perm_desc';

            transaction($permission)->run();
        }

        return true;
    }

    public function uninstall(\Flute\Core\Modules\ModuleInformation &$module): bool
    {
        $permission = rep(Permission::class)->findOne([
            'name' => 'admin.rules'
        ]);

        if ($permission) {
            transaction($permission, 'delete')->run();
        }

        widgets()->unregister(RulesWidget::class);

        return true;
    }
}