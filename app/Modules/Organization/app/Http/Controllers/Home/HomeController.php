<?php

namespace App\Modules\Organization\app\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Admin\app\Models\Employee\Employee;
use App\Modules\Organization\app\Models\Brand\Brand;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\Order\Order;
use App\Modules\Organization\app\Models\Product\Product;

class HomeController extends Controller
{
    public function home()
    {
        $organization_id = auth()->user()->organization_id;
        $data = [
            'pendingOrders' => Order::where('organization_id', $organization_id)->count(),
            'approvedOrders' => Order::where('organization_id', $organization_id)->count(),
            'totalOrders' => Order::where('organization_id', $organization_id)->count(),
            'products' => Product::where('organization_id', $organization_id)->count(),
            'brands' => Brand::where('organization_id', $organization_id)->count(),
            'categories' => Category::where('organization_id', $organization_id)->count(),
            'employees' => Employee::where('organization_id', $organization_id)->count(),
            'users' => User::count(),
        ];

        return view('organization::dashboard.index', compact('data'));
    }

    public function profile()
    {
        return view('organization::auth.user-profile');
    }

    public function user_profile()
    {
        return view('organization::auth.user-management');
    }
}
