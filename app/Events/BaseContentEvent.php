<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class BaseContentEvent 
{
    use SerializesModels;

    public $screen;
    public $request;
    public $model;

    public function __construct($screen, $request, $model)
    {
        $this->screen = $screen;
        $this->request = $request;
        $this->model = $model;
    }
}