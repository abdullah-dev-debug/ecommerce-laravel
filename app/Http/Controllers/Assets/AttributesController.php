<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Sizes;
use App\Models\Unit;
use App\Utils\AppUtils;
use Illuminate\Contracts\View\View;

class AttributesController extends Controller
{
    public const VIEW_NAMESPACE = "catalog.attributes.";
    public const STATUS_ACTIVE = 1;
    protected $sizes, $units;
    public function __construct(AppUtils $appUtils, Sizes $sizeModel, Unit $unitModel)
    {
        parent::__construct($appUtils, new Color());
        $this->sizes = $sizeModel;
        $this->units = $unitModel;
    }

    private function returnAttributesList(): string
    {
        $role = $this->getcurrentRole();
        return $role . self::VIEW_NAMESPACE . 'index';
    }
    // AttributesController.php
    public function index()
    {
        return parent::executeWithTryCatch(function () {
            $view = $this->returnAttributesList();
            $colors = $this->getAllResources();
            $sizes = $this->sizes->get();
            $units = $this->units->get();
            $data = [
                "colors" => $colors,
                "sizes" => $sizes,
                "units" => $units
            ];
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'colorTable' => view('admin.catalog.attributes.partials._color_table', ['colors' => $colors])->render(),
                    'sizeTable' => view('admin.catalog.attributes.partials._size_table', ['sizes' => $sizes])->render(),
                    'unitTable' => view('admin.catalog.attributes.partials._unit_table', ['units' => $units])->render(),
                    'colorCount' => $colors->count(),
                    'sizeCount' => $sizes->count(),
                    'unitCount' => $units->count()
                ]);
            }

            return $this->successView($view, ["attributes" => $data]);
        });
    }
}
