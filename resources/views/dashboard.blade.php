<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Rice Products</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ App\Models\Rice::count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ App\Models\Order::count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Pending Orders</p>
                    <p class="text-3xl font-bold text-orange-600">{{ App\Models\Order::where('status', 'Pending')->count() }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total Payments</p>
                    <p class="text-3xl font-bold text-green-600">{{ App\Models\Payment::count() }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Recent Orders</h3>
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase bg-gray-50">
                                <th class="px-4 py-3">Order ID</th>
                                <th class="px-4 py-3">Rice Item</th>
                                <th class="px-4 py-3">Quantity (kg)</th>
                                <th class="px-4 py-3">Total Price</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(App\Models\Order::with('rice')->latest()->take(10)->get() as $order)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">#{{ $order->id }}</td>
                                <td class="px-4 py-3">{{ $order->rice->name }}</td>
                                <td class="px-4 py-3">{{ $order->quantity }}</td>
                                <td class="px-4 py-3 font-bold text-indigo-600">₱{{ number_format($order->total_price, 2) }}</td>
                                <td class="px-4 py-3">
                                    @if($order->status == 'Pending')
                                        <span class="px-2 py-1 text-xs font-semibold text-orange-800 bg-orange-100 rounded-full">Pending</span>
                                    @elseif($order->status == 'Completed')
                                        <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Completed</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">No orders yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Recent Payments</h3>
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase bg-gray-50">
                                <th class="px-4 py-3">Payment ID</th>
                                <th class="px-4 py-3">Order ID</th>
                                <th class="px-4 py-3">Rice Item</th>
                                <th class="px-4 py-3">Amount Paid</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Date & Time Paid</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(App\Models\Payment::with('order.rice')->latest()->take(10)->get() as $payment)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">#{{ $payment->id }}</td>
                                <td class="px-4 py-3">Order #{{ $payment->order_id }}</td>
                                <td class="px-4 py-3">{{ $payment->order->rice->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 font-bold text-green-600">₱{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-4 py-3">
                                    @if($payment->payment_status == 'Paid')
                                        <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Paid</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Unpaid</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $payment->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">No payments yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>