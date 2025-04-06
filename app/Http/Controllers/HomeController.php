<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Optional: Handle search input from home page
        $query = trim($request->input('query'));

        if (!empty($query)) {
            // If search term is provided, use Laravel Scout search
            $products = Product::search($query)->paginate(10);
        } else {
            // Default: Fetch all products with pagination
            $products = Product::paginate(10);
        }

        return view('home', compact('products', 'query'));
    }
}
