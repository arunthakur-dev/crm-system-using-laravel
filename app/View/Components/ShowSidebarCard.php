<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ShowSidebarCard extends Component
{
    public $entity;
    public $fields;
    public $deleteRoute;
    /**
     * Create a new component instance.
     */
    public function __construct($entity, $fields = [], $deleteRoute = null)
    {
        $this->entity = $entity;
        $this->fields = $fields;
        $this->deleteRoute = $deleteRoute;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.show-sidebar-card');
    }
}
