<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MultiSelectFilter extends Component
{
    public string $name;
    public string $label;
    public $items;
    public string $key;

    /**
     * Create a new component instance.
     */
    public function __construct(string $name, string $label, $items, string $key = 'name')
    {
        $this->name = $name;
        $this->label = $label;
        $this->items = $items;
        $this->key = $key;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.multi-select-filter');
    }
}
