<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('orders.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Back to Orders</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Create New Order</h2>

                    <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="rice_id" value="Select Rice" />
                                <select name="rice_id" id="rice_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">-- Select Rice --</option>
                                    @foreach($rices as $rice)
                                        <option value="{{ $rice->id }}" data-price="{{ $rice->price_per_kg }}" data-stock="{{ $rice->stock_quantity }}">
                                            {{ $rice->name }} - ₱{{ number_format($rice->price_per_kg, 2) }}/kg (Stock: {{ $rice->stock_quantity }} kg)
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('rice_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="quantity" value="Quantity (kg)" />
                                <x-text-input id="quantity" name="quantity" type="number" step="0.1" min="0.1" class="mt-1 block w-full" value="{{ old('quantity') }}" required />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 flex flex-col justify-center">
                            <p class="text-sm text-gray-600">Total Amount</p>
                            <p class="text-3xl font-bold text-green-600" id="total-cost">₱0.00</p>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                            <a href="{{ route('orders.index') }}" class="px-6 py-2.5 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium">
                                CANCEL
                            </a>
                            <x-primary-button class="px-8 py-2.5 bg-green-800 hover:bg-green-900">
                                SAVE ORDER
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const riceSelect = document.getElementById('rice_id');
        const quantityInput = document.getElementById('quantity');
        const totalDisplay = document.getElementById('total-cost');

        function calculateTotal() {
            const selectedOption = riceSelect.options[riceSelect.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price) || 0;
            const quantity = parseFloat(quantityInput.value) || 0;
            const total = price * quantity;
            totalDisplay.textContent = '₱' + total.toFixed(2);
        }

        riceSelect.addEventListener('change', calculateTotal);
        quantityInput.addEventListener('input', calculateTotal);
    </script>
</x-app-layout>