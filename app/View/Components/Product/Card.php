<?php

namespace App\View\Components\Product;

use Illuminate\View\Component;

class Card extends Component
{
    public $product;

    public function __construct($product = null)
    {
        $this->product = $product;
    }

    public function render()
    {
        // Prevent rendering if product is null
        if (!$this->product) {
            return '';
        }

        return view('components.product.card');
    }
}
