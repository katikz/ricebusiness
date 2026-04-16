<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                    ← Back to Orders
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Order Information Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Order #{{ $order->id }}</h2>

                        <div class="space-y-4">
                            <!-- Status -->
                            <div class="flex justify-between items-center py-3 border-b">
                                <span class="text-gray-500">Status</span>
                                <span>
                                    @if($order->status == 'Pending')
                                        <span class="px-3 py-1 text-sm font-semibold text-orange-800 bg-orange-100 rounded-full">Pending</span>
                                    @elseif($order->status == 'Completed')
                                        <span class="px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">Completed</span>
                                    @else
                                        <span class="px-3 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">{{ $order->status }}</span>
                                    @endif
                                </span>
                            </div>

                            <!-- Date -->
                            <div class="flex justify-between items-center py-3 border-b">
                                <span class="text-gray-500">Order Date</span>
                                <span class="font-medium">{{ $order->created_at->format('M d, Y') }}</span>
                            </div>

                            <!-- Total Amount -->
                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-500">Total Amount</span>
                                <span class="text-2xl font-bold text-indigo-600">₱{{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rice Details Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4">Rice Information</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b">
                                <span class="text-gray-500">Rice Name</span>
                                <span class="font-medium">{{ $order->rice->name }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b">
                                <span class="text-gray-500">Price per kg</span>
                                <span class="font-medium">₱{{ number_format($order->rice->price_per_kg, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-500">Quantity</span>
                                <span class="font-medium">{{ $order->quantity }} kg</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Status Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Update Order Status</h3>
                    <form action="{{ route('orders.update', $order->id) }}" method="POST" class="flex items-center gap-4">
                        @csrf
                        @method('PUT')
                        <select name="status" class="flex-1 max-w-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2 border">
                            <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="px-8 py-3 bg-green-800 text-white font-bold rounded-lg hover:bg-green-900 shadow-lg">
                            SAVE
                        </button>
                    </form>
                </div>
            </div>

            <!-- Payment Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                @if(!$order->payment && $order->status != 'Cancelled')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4">Process Payment</h3>
                        <p class="text-gray-500 mb-4">Click the button below when the client has completed payment.</p>
                        <form action="{{ route('orders.markPaid', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-8 py-3 bg-blue-800 text-white font-bold text-lg rounded-lg hover:bg-blue-900 shadow-lg w-full">
                                MARK AS PAID
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                @if($order->payment)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4">Payment Information</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b">
                                <span class="text-gray-500">Payment Status</span>
                                <span>
                                    @if($order->payment->payment_status == 'Paid')
                                        <span class="px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">Paid</span>
                                    @else
                                        <span class="px-3 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">Unpaid</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-500">Amount Paid</span>
                                <span class="text-xl font-bold text-green-600">₱{{ number_format($order->payment->amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-4">Payment</h3>
                        <p class="text-gray-500 mb-4">No payment has been made for this order yet.</p>
                        <a href="{{ route('payments.create') }}" class="inline-block px-6 py-3 bg-blue-800 text-white font-bold rounded-lg hover:bg-blue-900 w-full text-center">
                            Process Payment →
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Back Button -->
            <div class="text-center mt-8">
                <a href="{{ route('orders.index') }}" class="inline-block px-8 py-3 bg-gray-700 text-white font-bold rounded-lg hover:bg-gray-800">
                    ← BACK TO ORDERS
                </a>
            </div>
        </div>
    </div>
</x-app-layout>