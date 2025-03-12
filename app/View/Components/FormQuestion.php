<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormQuestion extends Component
{
    /**
     * Create a new modular form.
     */

    public $question;
    public $answers;

    public function __construct($question, $answers = [])
    {
        $this->question = $question;
        $this->answers = $answers;
    }

    /**
     * Get the view / contents that represent the component.
     */
    
    public function render()
    {
        return view('components.form-question');
    }
}
