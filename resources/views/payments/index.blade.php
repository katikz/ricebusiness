<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Payments</h2>
                <a href="{{ route('payments.create') }}" class="px-4 py-2 bg-indigo-800 text-white rounded-md hover:bg-indigo-900">
                    Process Payment
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rice Item</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($payments as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">#{{ $payment->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">#{{ $payment->order_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $payment->order->rice->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">₱{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($payment->payment_status == 'Paid')
                                        <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Paid</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Unpaid</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('payments.show', $payment->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No payments found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>