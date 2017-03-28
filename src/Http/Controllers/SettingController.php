<?php namespace WebEd\Base\Settings\Http\Controllers;

use WebEd\Base\Http\Controllers\BaseAdminController;

use WebEd\Base\Settings\Repositories\Contracts\SettingContract;

class SettingController extends BaseAdminController
{
    protected $module = 'webed-settings';

    /**
     * @var \WebEd\Base\Settings\Repositories\SettingRepository
     */
    protected $repository;

    public function __construct(SettingContract $settingRepository)
    {
        parent::__construct();

        $this->repository = $settingRepository;

        $this->breadcrumbs->addLink(trans('webed-settings::base.settings'), route('admin::settings.index.get'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setPageTitle(trans('webed-settings::base.settings'));

        $this->getDashboardMenu($this->module);

        $this->assets
            ->addStylesheets('bootstrap-tagsinput')
            ->addJavascripts('bootstrap-tagsinput');

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_SETTINGS, 'index.get')->viewAdmin('index');
    }

    /**
     * Update settings
     * @method POST
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $data = $this->request->except([
            '_token',
            '_tab',
        ]);

        $data = do_filter(BASE_FILTER_BEFORE_UPDATE, $data, WEBED_SETTINGS, 'edit.post');

        $result = $this->repository->updateSettings($data);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_SETTINGS, $data, $result);

        $msgType = $result['error'] ? 'danger' : 'success';

        flash_messages()
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        return redirect()->back();
    }
}
