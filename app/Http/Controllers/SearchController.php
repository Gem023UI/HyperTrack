<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Get the input and trim whitespace
        $query = trim($request->input('query'));

        // Optional: Validate query input to avoid empty searches
        if (empty($query)) {
            return redirect()->back()->with('error', 'Please enter a search term.');
        }

        // Perform a full-text search using Laravel Scout (e.g., Algolia)
        $results = Product::search($query)->paginate(10);

        // Return results to the search view
        return view('searchresult', compact('query', 'results'));
    }
}
