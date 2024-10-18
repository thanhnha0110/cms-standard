<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public $title;


    /**
     * DashboardController constructor.
     */
    public function __construct(
        //
    ) {
        $this->title = trans('general.dashboard.title');
    }


    /**
     * Create
     */
    public function index()
    {
        $title = $this->title;
        return view('dashboard.index', compact('title'));
    }

}