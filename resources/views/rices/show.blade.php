<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rice Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('rices.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Back to Rice List</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Rice Product Details</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Rice Name</p>
                            <p class="text-lg font-medium">{{ $rice->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Price per kg</p>
                            <p class="text-lg font-medium">₱{{ number_format($rice->price_per_kg, 2) }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Stock Quantity</p>
                            <p class="text-lg font-medium">{{ $rice->stock_quantity }} kg</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="text-lg font-medium">
                                @if($rice->stock_quantity > 0)
                                    <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">In Stock</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Out of Stock</span>
                                @endif
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Description</p>
                            <p class="text-lg">{{ $rice->description ?? 'No description provided.' }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('rices.edit', $rice->id) }}" class="px-4 py-2 bg-blue-800 text-white rounded-md hover:bg-blue-900">
                            Edit
                        </a>
                        <form action="{{ route('rices.destroy', $rice->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>