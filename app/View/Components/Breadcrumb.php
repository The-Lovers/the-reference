<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $title;
    public $items;
    
    /**
     * Create a new component instance.
     */
    public function __construct($title, $items = [])
    {
        $this->title = $title;
        $this->items = array_slice($items, 0, 3);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumb');
    }
}
