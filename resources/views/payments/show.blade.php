<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('payments.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Back to Payments</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Payment Details #{{ $payment->id }}</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Payment ID</p>
                            <p class="text-lg font-medium">#{{ $payment->id }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Payment Status</p>
                            <p class="text-lg font-medium">
                                @if($payment->payment_status == 'Paid')
                                    <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Paid</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Unpaid</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Order ID</p>
                            <p class="text-lg font-medium">#{{ $payment->order_id }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Rice Item</p>
                            <p class="text-lg font-medium">{{ $payment->order->rice->name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Order Quantity</p>
                            <p class="text-lg font-medium">{{ $payment->order->quantity ?? 'N/A' }} kg</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Total Order Amount</p>
                            <p class="text-lg font-medium">₱{{ number_format($payment->order->total_price ?? 0, 2) }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Payment Amount</p>
                            <p class="text-lg font-bold text-indigo-600">₱{{ number_format($payment->amount, 2) }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Payment Date</p>
                            <p class="text-lg">{{ $payment->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-6">
                        <h3 class="text-lg font-bold mb-4">Update Payment Status</h3>
                        <form action="{{ route('payments.update', $payment->id) }}" method="POST" class="flex items-center gap-4">
                            @csrf
                            @method('PUT')
                            <select name="payment_status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Paid" {{ $payment->payment_status == 'Paid' ? 'selected' : '' }}>Paid</option>
                                <option value="Unpaid" {{ $payment->payment_status == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                            </select>
                            <button type="submit" class="px-6 py-2 bg-green-800 text-white font-bold rounded-md hover:bg-green-900">SAVE</button>
                        </form>
                    </div>

                    <div class="mt-8 pt-6 border-t">
                        <a href="{{ route('payments.index') }}" class="px-6 py-3 bg-gray-700 text-white font-bold rounded-md hover:bg-gray-800">BACK TO PAYMENTS</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>