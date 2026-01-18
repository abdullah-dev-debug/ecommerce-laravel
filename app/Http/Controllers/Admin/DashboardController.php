<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Utils\AppUtils;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public const DASHBOARD_VIEW = 'dashboard';

    public function __construct(AppUtils $appUtils)
    {
        parent::__construct($appUtils, new Admin());
    }
    private function returnDashboardView(): string
    {

        return 'admin.' . self::DASHBOARD_VIEW;
    }
    public function dashboard()
    {
        return parent::executeWithTryCatch(function () {
            $view = $this->returnDashboardView();
            $admin = Auth::guard('admin')->user() ?? null;
            $this->storeAdminInSession($admin);
            return $this->successView($view);
        });

    }
    
    protected function storeAdminInSession($admin)
    {
        if (!$admin)
            return;

        session([
            'admin' => [
                'name' => $admin->name,
                'role_name' => $admin->role->name ?? null,
            ],
            'last_login' => now()->toDateTimeString(),
        ]);
    }
}
