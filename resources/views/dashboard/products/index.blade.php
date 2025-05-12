<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Products</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage Products Data</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="flex justify-between items-center mb-4">
        <div>
            <form action="{{ route('products.index') }}" method="get">
                @csrf
                <flux:input icon="magnifying-glass" name="q" value="{{ $q ?? '' }}" placeholder="Search Product" class="w-full sm:w-80" />
            </form>
        </div>
        <div>
            <flux:button icon="plus">
                <flux:link href="{{ route('products.create') }}" variant="subtle">Add New Product</flux:link>
            </flux:button>
        </div>
    </div>

    @if(session()->has('successMessage'))
        <flux:badge color="lime" class="mb-3 w-full">{{ session()->get('successMessage') }}</flux:badge>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal table-auto">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-xs font-semibold uppercase tracking-wider">
                    <th class="px-5 py-3 border-b-2 border-gray-200">No</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Image</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Name</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Category</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Description</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Price</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Stock</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Created At</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $key => $product)
                    <tr class="bg-white hover:bg-gray-50 transition duration-150">
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $key + 1 }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 object-cover rounded">
                            @else
                                <div class="h-10 w-10 bg-gray-200 flex items-center justify-center rounded">
                                    <span class="text-gray-500 text-sm">N/A</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $product->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $product->category ? $product->category->name : 'No Category' }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ Str::limit($product->description, 50) }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $product->stock }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $product->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down">Actions</flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" href="{{ route('products.edit', $product->id) }}">Edit</flux:menu.item>
                                    <flux:menu.item 
                                        icon="trash" 
                                        variant="danger" 
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this product?')) document.getElementById('delete-form-{{ $product->id }}').submit();">
                                        Delete
                                    </flux:menu.item>

                                    <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</x-layouts.app>
