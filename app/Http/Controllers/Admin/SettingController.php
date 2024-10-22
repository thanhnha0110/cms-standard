<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Facades\SettingStore;
use App\Http\Controllers\Controller;
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
     * SettingController constructor.
     */
    public function __construct(
        SettingRepository $settingRepository,
    ) {
        $this->settingRepository = $settingRepository;
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
        $page = $request->page;
        $size = $request->size;
        $search = $request->search;
        $items = $this->logRepository->serverPaginationFilteringFor($request);
        return view('settings.logs.index', compact(
            'title',
            'page',
            'size',
            'search',
            'items',
        ));
    }

    /**
     * Get and paginate all users
     */
    public function getApi(Request $request)
    {
        $title = trans('general.settings.api.title');
        $page = $request->page;
        $size = $request->size;
        $search = $request->search;
        $items = $this->logRepository->serverPaginationFilteringFor($request);
        return view('settings.logs.index', compact(
            'title',
            'page',
            'size',
            'search',
            'items',
        ));
    }
}