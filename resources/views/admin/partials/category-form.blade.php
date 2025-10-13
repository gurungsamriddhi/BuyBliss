<form action="{{ $action }}" method="POST">
    @csrf

    {{-- Use PUT method for edit --}}
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="form-floating mb-3">
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            placeholder="Enter Category Name" value="{{ old('name', $category->name ?? '') }}" required>
        <label class="label-light"for="name">Category Name</label>
        @error('name')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-floating mb-3">
        <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Description" id="description"
            name="description" style="height: 100px">{{ old('description', $category->description ?? '') }}</textarea>
        <label class="label-light" for="description">Description</label>
        @error('description')
            <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>


        <button type="submit" class="btn btn-{{ $method === 'POST' ? 'success' : 'primary' }}">
            {{ $method === 'POST' ? 'Create Category' : 'Update Category' }}
        </button>
    </form>
