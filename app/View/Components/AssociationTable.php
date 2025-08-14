<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AssociationTable extends Component
{
    public $items;   // the data to display
    public $columns; // array of column definitions
    /**
     * Create a new component instance.
     */
    public function __construct($items = [], $columns = [])
    {
        $this->items = $items;
        $this->columns = $columns;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.association-table');
    }
}
