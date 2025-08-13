<?php

namespace App\Modules\Organization\app\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home()
    {
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
