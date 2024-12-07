<?php

namespace Flute\Modules\Rules\src\Http\Controllers\View;

use Flute\Core\Admin\Http\Middlewares\HasPermissionMiddleware;
use Flute\Core\Admin\Services\PageGenerator\AdminFormPage;
use Flute\Core\Admin\Services\PageGenerator\AdminInput;
use Flute\Core\Admin\Services\PageGenerator\AdminTablePage;
use Flute\Core\Support\AbstractController;
use Flute\Core\Support\FluteRequest;
use Flute\Core\Support\Response;
use Flute\Modules\Rules\database\Entities\RulesItem;
use Flute\Modules\Rules\src\Services\RulesService;

class RulesView extends AbstractController
{
    protected RulesService $rulesService;

    public function __construct(RulesService $rulesService)
    {
        HasPermissionMiddleware::permission('admin.rules');
        $this->middleware(HasPermissionMiddleware::class);

        $this->rulesService = $rulesService;
    }

    public function list(FluteRequest $request)
    {
        $list = rep(RulesItem::class)->select()->orderBy(['position' => 'asc']) ->fetchAll();

        return view(mm('Rules', 'Resources/views/admin/list'),[
            "list" => $list,
        ]);
    }

    public function add(FluteRequest $request)
    {
        return view(mm('Rules', 'Resources/views/admin/add'));
    }

    public function update($id, RulesService $rulesService)
    {
        try {
            $rules = $rulesService->find((int) $id);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 404);
        }

        return view(mm('Rules', 'Resources/Views/admin/edit'), [
            'rules' => $rules
        ]);
    }

    public function settings(FluteRequest $request)
    {
        // Загрузка текущих настроек
        $rulesTitle = $this->rulesService->getSetting('rules_title') ?? 'Rules';
    
        $title = new AdminInput('rules_title', 'rules.admin.widget_title', 'rules.admin.widget_title_desc', 'text', true, $rulesTitle);
    
        $formPage = new AdminFormPage(
            'rules.admin.settings_title',
            'rules.admin.settings_desc',
            '/api/rules/settings',
            'settings',
            'rules'
        );
    
        $formPage->addInput($title);
    
        return $formPage->render();
    }
}
