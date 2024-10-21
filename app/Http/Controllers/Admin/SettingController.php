<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\LogRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public $title;

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
        $this->title = trans('general.logs.title');
    }


    /**
     * Get and paginate all users
     */
    public function getGeneral(Request $request)
    {
        $title = $this->title;
        $page = $request->page;
        $size = $request->size;
        $search = $request->search;
        $items = $this->logRepository->serverPaginationFilteringFor($request);
        return view('logs.index', compact(
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
        $title = $this->title;
        $page = $request->page;
        $size = $request->size;
        $search = $request->search;
        $items = $this->logRepository->serverPaginationFilteringFor($request);
        return view('logs.index', compact(
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
        $title = $this->title;
        $page = $request->page;
        $size = $request->size;
        $search = $request->search;
        $items = $this->logRepository->serverPaginationFilteringFor($request);
        return view('logs.index', compact(
            'title',
            'page',
            'size',
            'search',
            'items',
        ));
    }
}