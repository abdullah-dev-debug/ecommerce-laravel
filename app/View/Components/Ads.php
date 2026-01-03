<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Ads extends Component
{
    /**
     * Create a new component instance.
     */
    protected $ads;
    public function __construct($ads)
    {
        $this->ads = $ads;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ads',["ads"=> $this->ads]);
    }
}

?>