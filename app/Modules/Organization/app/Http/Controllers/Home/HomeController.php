<?php

namespace App\Modules\Organization\app\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Organization\app\Models\Brand\Brand;
use App\Modules\Organization\app\Models\Category\Category;
use App\Modules\Organization\app\Models\Order\Order;
use App\Modules\Organization\app\Models\Product\Product;

class HomeController extends Controller
{
    public function home()
    {
        $data = [
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'approvedOrders' => Order::where('status', 'approved')->count(),
            'totalOrders' => Order::count(),
            'products' => Product::count(),
            'brands' => Brand::count(),
            'categories' => Category::count(),
            'users' => User::count(),
        ];
        return view('organization::dashboard.index');
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
