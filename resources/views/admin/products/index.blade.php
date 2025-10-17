@extends('admin.dashboard')

@section('title', 'Products')

@section('admin_content')
    <h1>Products</h1>



    <a href="{{ route('admin.products.create') }}" class="btn btn-success mb-2">Add Product</a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Categories</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead> 
     <tbody>
        @if($products->isEmpty())
        <tr>
            <td colspan="4" class="text-center">No Products added</td>
        </tr>
      @else
            @foreach ($products as $product)
                <tr>
                   
                    <td>
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" width="50" alt="{{ $product->name }}">
                        @else
                            No image added
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>
                        @foreach ($product->categories as $category)
                            <span class="badge bg-info">{{ $category->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        {{$product->price}}
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
@stop
