<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\LogRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * @var LogRepository
     */
    private $logRepository;

    /**
     * SettingController constructor.
     */
    public function __construct(
        LogRepository $logRepository,
    ) {
        $this->logRepository = $logRepository;
    }


    /**
     * Get and paginate all users
     */
    public function getGeneral(Request $request)
    {
        $title = trans('general.settings.general.title');
        $page = $request->page;
        $size = $request->size;
        $search = $request->search;
        $items = $this->logRepository->serverPaginationFilteringFor($request);
        return view('settings.general', compact(
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