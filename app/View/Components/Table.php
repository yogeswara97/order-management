<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public $headers;
    // public $data;
    // public $actionCallback;

    public function __construct($headers,)
    {
        $this->headers = $headers;
        // $this->data = $data;
        // $this->actionCallback = $actionCallback;
    }


    public function render()
    {
        return view('components.table.table');
    }
}
