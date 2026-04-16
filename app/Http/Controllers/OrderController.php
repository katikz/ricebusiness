<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Rice;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('rice', 'payment')->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $rices = Rice::all();

        return view('orders.create', compact('rices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rice_id' => 'required|exists:rices,id',
            'quantity' => 'required|numeric|min:0.1',
        ]);

        $rice = Rice::findOrFail($request->rice_id);

        if ($rice->stock_quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock quantity.');
        }

        $totalPrice = $rice->price_per_kg * $request->quantity;

        $order = Order::create([
            'rice_id' => $request->rice_id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'Pending',
        ]);

        $rice->stock_quantity -= $request->quantity;
        $rice->save();

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load('rice', 'payment');

        return view('orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Completed,Cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('orders.index')->with('success', 'Order status updated.');
    }

    public function markPaid(Order $order)
    {
        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total_price,
            'payment_status' => 'Paid',
        ]);

        $order->update(['status' => 'Completed']);

        return back()->with('success', 'Payment recorded and order marked as completed.');
    }

    public function destroy(Order $order)
    {
        $rice = $order->rice;
        $rice->stock_quantity += $order->quantity;
        $rice->save();

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
