@extends('admin.dashboard')

@section('title', 'Add Products')

@section('admin_content')
    <h1 class="form_header">Add New Product</h1>

    @include('admin.partials.product-form', [
        'action' => route('admin.products.store'),
        'method' => 'POST',
        'categories' => $categories
    ])
@stop
