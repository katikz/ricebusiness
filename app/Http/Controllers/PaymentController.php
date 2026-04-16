<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order.rice')->get();

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $orders = Order::with('rice')->get();

        return view('payments.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $order = Order::findOrFail($request->order_id);

        $payment = Payment::create([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'payment_status' => 'Paid',
        ]);

        $order->update(['status' => 'Completed']);

        return redirect()->route('payments.index')->with('success', 'Payment processed successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load('order.rice');

        return view('payments.show', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_status' => 'required|string|in:Paid,Unpaid',
        ]);

        $payment->update(['payment_status' => $request->payment_status]);

        return redirect()->route('payments.index')->with('success', 'Payment status updated.');
    }

    public function destroy(Payment $payment)
    {
        $payment->order->update(['status' => 'Pending']);
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}
