@extends('admin.dashboard')

@section('title', 'Add Category')

@section('admin_content')
    <h1 class="form_header">Add New Category</h1>

    @include('admin.partials.category-form', [
        'action' => route('admin.categories.store'),
        'method' => 'POST'
    ])
@stop
