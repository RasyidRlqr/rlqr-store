<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        // Ambil semua pesanan, termasuk detail produk dan game terkait
        $orders = Order::with(['product', 'product.game'])
                       ->latest()
                       ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update the status of the specified order.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,completed,failed,canceled',
            'admin_notes' => 'nullable|string'
        ]);

        $order->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            // Jika status menjadi paid, catat waktunya
            'paid_at' => ($request->status === 'paid' && is_null($order->paid_at)) ? now() : $order->paid_at,
        ]);

        return redirect()->route('orders.index')
                         ->with('success', "Status Pesanan #{$order->invoice_number} berhasil diperbarui.");
    }

    
    
    // Anda bisa tambahkan method show(Order $order) untuk detail pesanan di view
}