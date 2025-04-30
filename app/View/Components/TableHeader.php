<?php

namespace App\View\Components;

use App\Models\Customer;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableHeader extends Component
{
    public $create;
    public $dataset;
    public $routeReset;
    public $routeCreate;
    /**
     * Create a new component instance.
     */
    public function __construct($create, $dataset, $routeReset, $routeCreate)
    {
        $this->create = $create;
        $this->dataset = $dataset;
        $this->routeReset = $routeReset;
        $this->routeCreate = $routeCreate;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.table-header');
    }
}
