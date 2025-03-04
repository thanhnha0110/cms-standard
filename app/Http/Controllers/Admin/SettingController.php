<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Facades\SettingStore;
use App\Http\Controllers\Controller;
use App\Repositories\EmailTemplateRepository;
use App\Repositories\SettingRepository;
use Exception;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @var EmailTemplateRepository
     */
    private $emailTemplateRepository;

    /**
     * SettingController constructor.
     */
    public function __construct(
        SettingRepository $settingRepository,
        EmailTemplateRepository $emailTemplateRepository,
    ) {
        $this->settingRepository = $settingRepository;
        $this->emailTemplateRepository = $emailTemplateRepository;
    }


    /**
     * Get general
     */
    public function getGeneral(Request $request)
    {
        $title = trans('general.settings.general.title');
        return view('settings.general', compact('title'));
    }

    /**
     * Update general
     */
    public function postGeneral(Request $request)
    {
        try {
            $params = SettingStore::prepareInsertData($request->all());
            $this->settingRepository->updateOrCreateMany($params);
            return redirect()->route('settings.general.get')->with('success', trans('notices.create_success_message'));
        } catch (Exception $e) {
            return redirect()->route('settings.general.get')->with('error', $e->getMessage());
        }
    }

    /**
     * Get and paginate all users
     */
    public function getEmail(Request $request)
    {
        $title = trans('general.settings.email.title');
        $emailTemplates = $this->emailTemplateRepository->all();
        return view('settings.email', compact('title', 'emailTemplates'));
    }

    /**
     * Update email setting
     */
    public function postEmail(Request $request)
    {
        try {
            $params = SettingStore::prepareInsertData($request->all());
            $this->settingRepository->updateOrCreateMany($params);
            return redirect()->route('settings.email.get')->with('success', trans('notices.create_success_message'));
        } catch (Exception $e) {
            return redirect()->route('settings.email.get')->with('error', $e->getMessage());
        }
    }

    /**
     * Get and paginate all users
     */
    public function editEmailTemplate(Request $request)
    {
        $title = trans('general.settings.email.title');
        $emailTemplates = $this->emailTemplateRepository->all();
        return view('settings.email', compact('title', 'emailTemplates'));
    }

    /**
     * Get and paginate all users
     */
    public function getApi(Request $request)
    {
        $title = trans('general.settings.api.title');
        return view('settings.api', compact('title'));
    }

    /**
     * Update email setting
     */
    public function postApi(Request $request)
    {
        try {
            $params = SettingStore::prepareInsertData($request->all());
            $this->settingRepository->updateOrCreateMany($params);
            return redirect()->route('settings.api.get')->with('success', trans('notices.create_success_message'));
        } catch (Exception $e) {
            return redirect()->route('settings.api.get')->with('error', $e->getMessage());
        }
    }
}