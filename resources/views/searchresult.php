@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h2 class="text-2xl font-semibold mb-6">
        Search Results for: <span class="text-indigo-600">{{ $query }}</span>
    </h2>

    @if($results->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($results as $product)
                <div class="bg-white shadow-md rounded-2xl p-6 hover:shadow-lg transition duration-300">
                    <h3 class="text-lg font-bold mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600">{{ Str::limit($product->description, 100) }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $results->appends(['query' => $query])->links() }}
        </div>
    @else
        <div class="mt-6 text-center text-gray-500">
            No products found matching your search.
        </div>
    @endif
</div>
@endsection
