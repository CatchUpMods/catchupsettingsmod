<?php namespace WebEd\Base\Settings\Http\Middleware;

use \Closure;

class BootstrapModuleMiddleware
{
    public function __construct()
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  array|string $params
     * @return mixed
     */
    public function handle($request, Closure $next, ...$params)
    {
        dashboard_menu()->registerItem([
            'id' => 'webed-settings',
            'priority' => 1,
            'parent_id' => 'webed-configuration',
            'heading' => null,
            'title' => trans('webed-settings::base.admin_menu.title'),
            'font_icon' => 'fa fa-circle-o',
            'link' => route('admin::settings.index.get'),
            'css_class' => null,
            'permissions' => ['view-settings'],
        ]);

        return $next($request);
    }
}
