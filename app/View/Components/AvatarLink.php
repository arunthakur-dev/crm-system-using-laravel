<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AvatarLink extends Component
{
    public $item;
    public $displayValue;
    public $routeName;
    public $initialField;

    /**
     * Create a new component instance.
     */
    public function __construct($item, $displayValue, $routeName, $initialField = null)
    {
        $this->item = $item;
        $this->displayValue = $displayValue;
        $this->routeName = $routeName;
        $this->initialField = $initialField;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.avatar-link');
    }

    /**
     * Helper to get initial letter.
     */
    public function initial()
    {
        $field = $this->initialField
            ? $this->item->{$this->initialField}
            : $this->displayValue;

        return strtoupper(substr($field, 0, 1));
    }
}
