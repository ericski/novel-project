<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{

    public $tabs;
    public $active;

    /**
     * Create a new component instance.
     *
     * @param array $tabs
     * @param string $active
     * @return void
     */
    public function __construct($tabs = [], $active = '')
    {
        $this->tabs = $tabs;
        $this->active = $active;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
