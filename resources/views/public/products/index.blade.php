{{-- resources/views/public/products/index.blade.php --}}
@extends('layouts.public')

@section('title', 'Shop - BuyBLiss')

@section('content')
<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Shop</h1>
                </div>
            </div>
            <div class="col-lg-7"></div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<!-- Start Product Grid Section -->
<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">

            @forelse ($products as $product)
                <div class="col-12 col-md-4 col-lg-3 mb-5">
                    <a class="product-item group transform transition duration-200 hover:scale-105 hover:shadow-lg"
                       href="{{ route('showproduct', $product->id) }}">
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="img-fluid product-thumbnail">

                        <h3 class="product-title">{{ $product->name }}</h3>
                        <strong class="product-price">${{ number_format($product->price, 2) }}</strong>

                        <span class="icon-cross">
                            <img src="{{ asset('images/cross.svg') }}" class="img-fluid">
                        </span>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-10">
                    <p class="text-gray-600 text-lg">No products available yet.</p>
                </div>
            @endforelse

        </div>

        <!-- Pagination -->
        @if ($products->hasPages())
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
<!-- End Product Grid Section -->
@endsection