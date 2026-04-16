<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Process Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('payments.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Back to Payments</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Process Payment</h2>

                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="order_id" class="block text-sm font-medium text-gray-700">Select Order</label>
                            <select name="order_id" id="order_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Select Order --</option>
                                @forelse($orders as $order)
                                    <option value="{{ $order->id }}" data-amount="{{ $order->total_price }}">
                                        Order #{{ $order->id }} - {{ $order->rice->name }} - ₱{{ number_format($order->total_price, 2) }}
                                    </option>
                                @empty
                                    <option value="">No pending orders available</option>
                                @endforelse
                            </select>
                            @error('order_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Payment Amount (₱)</label>
                            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('payments.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">CANCEL</a>
                            <button type="submit" class="px-8 py-3 bg-green-800 text-white font-bold text-lg rounded-md hover:bg-green-900 shadow-lg">
                                SAVE
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('order_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const amount = selectedOption.dataset.amount || 0;
            document.getElementById('amount').value = amount;
        });
    </script>
</x-app-layout>