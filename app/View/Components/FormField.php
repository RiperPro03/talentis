<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormField extends Component
{

    public $name;
    public $label;
    public $type;
    public $options;
    public $placeholder;
    public $value;
    public $class;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label = null, $type = 'text', $options = [], $placeholder = '', $value = null, $class = '')
    {
        $this->name = $name;
        $this->label = $label ?? ucfirst($name);
        $this->type = $type;
        $this->options = $options;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-field');
    }
}
