<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SortLink extends Component
{
    /**
     * Create a new component instance.
     */
    public $field, $label, $sortField, $sortDirection;

    public function __construct($field, $label, $sortField, $sortDirection)
    {
        $this->field = $field;
        $this->label = $label;
        $this->sortField = $sortField;
        $this->sortDirection = $sortDirection;
    }

    public function render()
    {
        $nextDirection = ($this->sortField === $this->field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $icon = '';

        if ($this->sortField === $this->field) {
            $icon = $this->sortDirection === 'asc' ? ' ▲' : ' ▼';
        }

        $url = request()->fullUrlWithQuery(['sort' => $this->field, 'direction' => $nextDirection]);

        return view('components.sort-link', compact('url', 'icon'));
    }
}
