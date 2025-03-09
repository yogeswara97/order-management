<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CustomerModal extends Component
{
    public $customers;

    /**
     * Create a new component instance.
     */
    public function __construct($customers)
    {
        $this->customers = $customers;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.customer-modal');
    }
}
