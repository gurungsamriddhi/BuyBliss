@extends('admin.dashboard')

@section('title', 'Categories')

@section('admin_content')
    <h1 class="form_header">Categories List</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-success mb-2">Add Category</a>
    
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @if ($categories->isEmpty())
                <tr>
                    <td colspan="3" class="text-center">No categories added</td>
                </tr>
                @else
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type= "button" class="btn btn-sm btn-danger delete-btn" >
                                {{-- Create a modal view like dialog box to showup on click with delete and cancel button --}}
                                    
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    
@stop
