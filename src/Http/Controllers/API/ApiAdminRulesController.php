<?php

namespace Flute\Modules\Rules\src\Http\Controllers\API;

use Flute\Core\Admin\Http\Middlewares\HasPermissionMiddleware;
use Flute\Core\Http\Middlewares\CSRFMiddleware;
use Flute\Core\Support\AbstractController;
use Flute\Core\Support\FluteRequest;
use Flute\Modules\Rules\src\Services\RulesService;
use Flute\Modules\Rules\database\Entities\RulesItem;
use Flute\Modules\Rules\database\Entities\RulesItemBlock;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiAdminRulesController extends AbstractController
{
    protected $rulesService;

    public function __construct(RulesService $rulesService)
    {
        $this->rulesService = $rulesService;

        HasPermissionMiddleware::permission(['admin', 'admin.rules']);
        $this->middleware(HasPermissionMiddleware::class);
        $this->middleware(CSRFMiddleware::class);
    }

    public function saveOrder(FluteRequest $request)
    {
        $order = $request->input("order");
        if (!$order)
            return $this->error('Order is empty', 404);

        foreach ($order as $value){
            $item = rep(RulesItem::class)->select()->where(['id' => (int) $value['id']])->fetchOne();

            if ($item) {
                $item->position = $value['position'];

                transaction($item)->run();
            }
        }

        return $this->success();
    }

    public function update(FluteRequest $request, $id) : Response
    {
        try {
            $this->rulesService->update(
                (int) $request->input('id'),
                $request->rule,
                $request->input('blocks', '[]')
            );

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function add(FluteRequest $request)
    {
        $input = $request->input();

        $item = new RulesItem();
        $item->rule = $input['rule'];
        $block = new RulesItemBlock();
        $block->json = $input['blocks'];
        $block->item = $item;

        $item->blocks = $block;

        transaction($item)->run();

        return $this->success();
    }

    public function delete (FluteRequest $request, string $id)
    {
        $item = $this->getItem($id);

        if ($item instanceof JsonResponse)
            return $item;

        transaction($item, 'delete')->run();

        return $this->success();
    }

    public function getItem(string $id)
    {
        $list = rep(RulesItem::class)->findByPK((int) $id);

        if (!$list)
            return $this->error(__('rules.admin.empty'), 404);

        return $list;

    }

    public function saveSettings(FluteRequest $request): Response
    {
        try {
            $rulesTitle = $request->input('rules_title', 'Rules');

            // Сохранение настроек в базу данных
            $this->rulesService->saveSetting('rules_title', $rulesTitle);

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
