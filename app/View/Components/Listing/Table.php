<?php

namespace App\View\Components\Listing;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public $columns;
    public $rows;
    public $filters;
    public $route;
    public $searchPlaceholder;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $columns = [],
        $rows = [],
        $filters = [],
        $route = null,
        $searchPlaceholder = 'Rechercher...'
    ){
        $this->columns = $columns;
        $this->rows = $rows;
        $this->filters = $filters;
        $this->route = $route;
        $this->searchPlaceholder = $searchPlaceholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.listing.table');
    }
}
