<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function redirectUser()
    {
        $redirect = null;

        if(Auth::user()->role == 'admin')
        {
            $redirect .= 'admin';
        } else if(Auth::user()->role == 'customer') {
            $redirect .= 'customer';
        }

        return redirect()->route($redirect.'.dashboard');
    }

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function customerDashboard(Request $request) {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                  ->orWhere('category', 'like', "%$search%");
        }

        $products = $query->latest()->paginate(10);

        $products->appends($request->all());
        return view('dashboard', compact('products'));
    }
}
