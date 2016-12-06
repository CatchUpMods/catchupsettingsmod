<?php use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$router->group(['middleware' => ['web']], function (Router $router) {

    $adminRoute = config('webed.admin_route');

    $moduleRoute = 'settings';

    /*
     * Admin route
     * */
    $router->group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
        $router->get('/', 'SettingController@index')
            ->name('admin::settings.index.get')
            ->middleware('has-permission:view-settings');

        $router->post('', 'SettingController@store')
            ->name('admin::settings.update.post')
            ->middleware('has-permission:edit-settings');
    });
});
