<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilePreview extends Component
{
    public $path, $alt, $width, $height, $class,$containerClasss;

    public function __construct(
        $path = null,
        $alt = "Icon",
        $width = 200,
        $height = 200,
        $class = '',
        $containerClasss = ''
    ) {
        $this->path = $path;
        $this->alt = $alt;
        $this->width = $width;
        $this->height = $height;
        $this->class = $class;
        $this->containerClasss = $containerClasss;
    }

    public function render()
    {
        return view('components.file-preview');
    }
}

