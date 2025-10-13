@extends('admin.dashboard')

@section('title', 'Edit Category')

@section('admin_content')
    <h1 class="form_header">Edit Category</h1>

    @include('admin.partials.category-form', [
        'action' => route('admin.categories.update', $category->id),
        'method' => 'PUT',
        'category' => $category,
    ])
@stop
