<?php

namespace App\Factories;

use App\Services\BaseAuthService;
use App\Utils\AppUtils;

class AuthFactory
{
    public static function make(string $modelClass)
    {
        $model = new $modelClass;
        $utils = app(AppUtils::class);
        return new BaseAuthService($model, $utils);
    }
}
