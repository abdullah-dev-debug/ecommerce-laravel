<?php

namespace App\Factories;

use App\Services\BaseService;
use App\Utils\AppUtils;

class BaseFunctionFactory
{
    public static function make(string $modelClass, string $notFoundMsg): array
    {
        $model = new $modelClass;
        $utils = app(AppUtils::class);

        return [
            'service' => new BaseService($model, $notFoundMsg, $utils),
            'model'   => $model,
        ];
    }
}
