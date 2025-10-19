<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    <!-- Product Name -->
    <div class="form-floating mb-3">
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
               placeholder="Product Name"
               value="{{ old('name', $product->name ?? '') }}" required>
        <label for="name" class="fw-normal text-secondary">Product Name</label>
        @error('name')
        <span class="text-damger small">{{$message}}</span>
        @enderror
    </div>

    <!-- Description -->
    <div class="form-floating mb-3">
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                  placeholder="Description" style="height: 100px">{{ old('description', $product->description ?? '') }}</textarea>
        <label for="description" class="fw-normal text-secondary">Description</label>
        @error ('description')
<span class="text-danger small">{{$message}}</span>
@enderror
    </div>

    <!-- Price -->
    <div class="form-floating mb-3">
        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price"
               placeholder="Price"
               value="{{ old('price', $product->price ?? '') }}">
        <label for="price" class="fw-normal text-secondary">Price</label>
        @error('price')
        <span class="text-danger small">{{$message}}</span>
        @enderror
    </div>

    <!-- Categories -->
    <div class="mb-3">
        <label class="label-dark">Select Categories</label>
        @foreach($categories as $category)
    <div class="form-check">
        <input type="checkbox"
               class="form-check-input"
               id="category_{{ $category->id }}"
               name="categories[]"
               value="{{ $category->id }}"
               @if( (collect(old('categories'))->contains($category->id)) || 
                     (isset($product) && $product->categories->contains($category->id) && !old('categories')) )
                   checked 
               @endif
        >
        <label for="category_{{ $category->id }}" class="form-check-label text-secondary">
            {{ $category->name }}
        </label>
    </div>
@endforeach

        @error('categories')
        <span class="text-danger small">{{$message}}</span>
        @enderror
    </div>

   <div class="mb-3">
    <label for="formFile" class="label-dark d-block">Upload Product Image</label>

   
    @if(isset($product) && $product->image)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 width="150" 
                 height="150"
                 class="img-thumbnail border">
        </div>
    @endif

    <input class="form-control @error('image') is-invalid @enderror" type="file" id="formFile" name="image" accept="image/*">
    @error('image')
    <span class="text-danger small">{{$message}}</span>
    @enderror
</div>

    <button type="submit" class="btn btn-{{ $method === 'POST' ? 'success' : 'primary' }}">
        {{ $method === 'POST' ? 'Create Product' : 'Update Product' }}
    </button>
</form>
