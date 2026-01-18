<?php

namespace App\Policies;

use App\Constants\ProductStatus;
use App\Constants\Role;
use App\Models\Admin;
use App\Models\Product;

class ProductPolicy
{
    // Single product approval
    public function approve(Admin $admin, Product $product): bool
    {
        return $admin->role_id === Role::ADMIN
            && $product->status === ProductStatus::PENDING;
    }

    // Bulk approve (can reuse single approve logic)
    public function bulkApprove(Admin $admin): bool
    {
        return $admin->role_id === Role::ADMIN;
    }

    // Toggle status
    public function toggleStatus(Admin $admin, Product $product): bool
    {
        return $admin->role_id === Role::ADMIN;
    }
    public function vendorProducts(Admin $admin): bool
    {
        return $admin->role_id === Role::ADMIN;
    }

    public function rejected(Admin $admin, Product $product)
    {
        return $admin->role_id === Role::ADMIN
            && $product->status !== ProductStatus::REJECTED;
    }
}
