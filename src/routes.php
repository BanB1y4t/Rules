<?php

use Flute\Core\Admin\Http\Middlewares\HasPermissionMiddleware;
use Flute\Core\Router\RouteGroup;
use Flute\Modules\Rules\src\Http\Controllers\API\ApiAdminRulesController;
use Flute\Modules\Rules\src\Http\Controllers\View\RulesView;

$router->group(function (RouteGroup $routeGroup) {
    $routeGroup->middleware(HasPermissionMiddleware::class);

    $routeGroup->group(function (RouteGroup $adminRouteGroup) {
        $adminRouteGroup->get('list', [RulesView::class, 'list']);
        $adminRouteGroup->get('add', [RulesView::class, 'add']);
        $adminRouteGroup->get('edit/{id}', [RulesView::class, 'update']);
        $adminRouteGroup->get('settings', [RulesView::class, 'settings']); // Новый маршрут
    }, 'rules/');

    $routeGroup->group(function (RouteGroup $adminRouteGroup) {
        $adminRouteGroup->post('add', [ApiAdminRulesController::class, 'add']);
        $adminRouteGroup->put('save-order', [ApiAdminRulesController::class, 'saveOrder']);
        $adminRouteGroup->put('{id}', [ApiAdminRulesController::class, 'update']);
        $adminRouteGroup->delete('{id}', [ApiAdminRulesController::class, 'delete']);
        $adminRouteGroup->post('settings', [ApiAdminRulesController::class, 'saveSettings']); // Новый маршрут
    }, 'api/rules/');
}, 'admin/');