@extends('layouts.app')
@section('content')
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="sr-only">Products</h2>

            <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
              <!--for else to loop over items but also show a fallback message if the list is empty-->
              @forelse ($products as $product)
                    <a href="#" class="group">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="aspect-square w-full rounded-lg bg-gray-200 object-cover group-hover:opacity-75 xl:aspect-7/8" />

                        <h3 class="mt-4 text-sm text-gray-700">{{ $product->name }}</h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $product->price }}</p>
                    </a>
                   <!-- <a href="#" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                      Add to cart
                    </a>-->
@empty 
<p class="text-gray-600">No products available yet.</p>
@endforelse
    

    
            </div>
        </div>
    </div>
@endsection
