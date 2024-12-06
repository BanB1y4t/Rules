<?php

namespace Flute\Modules\Rules\src\ServiceProviders\Extensions;

use Flute\Core\Admin\Builders\AdminSidebarBuilder;

class AdminExtension implements \Flute\Core\Contracts\ModuleExtensionInterface
{
    public function register(): void
    {
        $this->addSidebar();
    }

    private function addSidebar(): void
    {
        AdminSidebarBuilder::add('additional', [
            'title' => 'rules.admin.header',
            'icon' => 'ph-notebook',
            'permission' => 'admin.rules',
            'items' => [
                [
                    'title' => 'rules.admin.header',
                    'url' => '/admin/rules/list'
                ],
                [
                    'title' => 'rules.admin.settings_title',
                    'url' => '/admin/rules/settings'
                ],
            ]
        ]);
    }
}