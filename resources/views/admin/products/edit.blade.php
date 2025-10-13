@extends('admin.dashboard')

@section('title', 'Edit Products')

@section('admin_content')
    <h1 class="form_header">Edit Product</h1>

    @include('admin.partials.product-form', [
        'action' => route('admin.products.update',$product->id),
        'method' => 'PUT',
        'product' => $product,
    'categories' => $categories
    ])
@stop
