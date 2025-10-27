@extends('layouts.app')

@section('content')
    <div class="bg-white">
        <div class="pt-6">
            <!-- Image gallery -->
            <div class="mx-auto flex justify-center">
                <div class="w-full max-w-sm">
                    <div class="aspect-[2/3] overflow-hidden mx-auto">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="h-full w-full object-cover object-center" />
                    </div>
                </div>
            </div>

            <!-- Product info -->
            <div
                class="mx-auto max-w-2xl px-4 pt-10 pb-16 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pt-16 lg:pb-24">
                <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $product->name }}</h1>
                </div>

                <!-- Options -->
                <div class="mt-4 lg:row-span-3 lg:mt-0">
                    <h2 class="sr-only">Product information</h2>
                    <p class="text-3xl tracking-tight text-gray-900">{{ $product->price }}</p>

                    <!-- Reviews -->
                    <div class="mt-6">
                        <h3 class="sr-only">Reviews</h3>
                        <div class="flex items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                                    class="size-5 shrink-0 {{ $i <= 4 ? 'text-gray-900' : 'text-gray-200' }}">
                                    <path
                                        d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                        clip-rule="evenodd" fill-rule="evenodd" />
                                </svg>
                            @endfor
                            <p class="sr-only">4 out of 5 stars</p>
                            <a href="#" class="ml-3 text-sm font-medium text-indigo-600 hover:text-indigo-500">117
                                reviews</a>
                        </div>
                    </div>

                    <!-- Success/Error Messages -->
                    <div id="cart-message" class="mt-4 hidden p-3 rounded"></div>

                    <!-- Add to Bag (for both users and guests) -->
                    <form class="mt-10" id="add-to-cart-form" action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit"
                            class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none">
                            Add to bag
                        </button>
                    </form>
                </div>

                <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pt-6 lg:pr-8 lg:pb-16">
                    <!-- Description and details -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">Category</h3>
                        <ul role="list" class="list-disc space-y-2 pl-4 text-sm mt-4">
                            @foreach ($product->categories as $category)
                                <li class="text-gray-600">{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mt-10">
                        <h2 class="text-sm font-medium text-gray-900">Details</h2>
                        <div class="mt-4 space-y-6">
                            <p class="text-sm text-gray-600">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Login Prompt Modal -->
        <dialog id="login-prompt-modal" class="backdrop:bg-gray-900/50 p-0 rounded-lg">
            <div class="max-w-md w-full bg-white p-6 sm:p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Please Log In</h2>
                <p class="text-sm text-gray-600 mb-4">You need to be logged in to add items to your cart.</p>
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="document.getElementById('login-prompt-modal').close()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancel
                    </button>
                    <a href="{{ route('login') }}?redirect_to={{ urlencode(url()->current()) }}"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                        Log In
                    </a>
                </div>
            </div>
        </dialog>
    </div>

    <!-- JavaScript for AJAX -->
    <script>
        document.getElementById('add-to-cart-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const messageDiv = document.getElementById('cart-message');
            messageDiv.classList.remove('hidden', 'bg-green-100', 'bg-red-100');
            try {
                const response = await fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const result = await response.json();
                messageDiv.classList.add(response.ok ? 'bg-green-100' : 'bg-red-100');
                messageDiv.textContent = response.ok ? result.success : result.error;
                if (response.ok) {
                    // Optionally update cart counter
                    updateCartCount();
                } else if (response.status === 401) {
                    document.getElementById('login-prompt-modal').showModal();
                }
            } catch (error) {
                messageDiv.classList.add('bg-red-100');
                messageDiv.textContent = 'An error occurred.';
            }
        });

        // Optional: Update cart count
        async function updateCartCount() {
            try {
                const response = await fetch('{{ route('cart.count') }}');
                const data = await response.json();
                const cartCount = document.getElementById('cart-count');
                if (cartCount) cartCount.textContent = data.count;
            } catch (error) {
                console.error('Error updating cart count:', error);
            }
        }
    </script>
@endsection