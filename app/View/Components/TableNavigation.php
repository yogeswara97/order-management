<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;

class TableNavigation extends Component
{
    public $dataset;
    public $perPage;

    public function __construct($dataset, $perPage)
    {
        $this->dataset = $dataset;
        $this->perPage = $perPage;
    }

    public function render()
    {
        return view('components.table.table-navigation');
    }
}

