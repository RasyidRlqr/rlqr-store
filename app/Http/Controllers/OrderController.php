<?php

namespace App\Http\Controllers; // <-- Perhatikan: Namespace HANYA App\Http\Controllers

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse; // Tambahkan ini
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // app/Http/Controllers/OrderController.php

public function updateStatusFromBot(Request $request)
{
    // === 1. Validasi Keamanan (Bot Key) ===
    // Kunci rahasia dari request harus SAMA dengan yang ada di .env
    if ($request->bot_key !== env('BOT_SECRET_KEY')) {
        // Jika kunci tidak cocok, tolak akses (Error 401 Unauthorized)
        return response()->json(['message' => 'Unauthorized: Invalid BOT_SECRET_KEY.'], 401);
    }

    // === 2. Validasi Data yang Dikirim Bot ===
    $request->validate([
        'invoice' => 'required|string',
        'new_status' => 'required|in:paid,processing,completed,failed',
    ]);

    $invoiceNumber = $request->invoice;
    $newStatus = $request->new_status;

    // === 3. Cari dan Update Pesanan ===
    $order = Order::where('invoice_number', $invoiceNumber)->first();

    if (!$order) {
        // Pesanan tidak ditemukan (Error 404 Not Found)
        return response()->json(['message' => "Order with invoice {$invoiceNumber} not found."], 404);
    }

    // Lakukan Pembaruan Status
    $order->status = $newStatus;
    $order->admin_notes = "Updated via Bot: Status changed to {$newStatus}."; 

    // Atur paid_at jika status diubah menjadi 'paid' atau 'completed'
    if (in_array($newStatus, ['paid', 'completed']) && $order->paid_at === null) {
        $order->paid_at = now();
    }

    $order->save();

    // === 4. Beri Respon ke Bot ===
    return response()->json([
        'message' => 'Order status updated successfully', 
        'invoice' => $order->invoice_number,
        'new_status' => $order->status
    ], 200);
}

    public function userHistory()
{
    // Ambil ID pengguna yang sedang login
    $userId = Auth::id();

    // Ambil semua pesanan user tersebut, termasuk detail produk dan game
    $orders = Order::where('user_id', $userId)
                   ->with(['product', 'product.game'])
                   ->latest() // Urutkan dari yang terbaru
                   ->paginate(15);

    return view('user.orders.history', compact('orders'));
}

    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input (gunakan kode validasi yang sudah kita sepakati)
        $request->validate([
            'game_id'          => 'required|exists:games,id',
            'product_id'       => 'required|exists:products,id',
            'game_user_id'     => 'required|string|max:255',
            'contact_whatsapp' => 'required|string|max:15',
            'payment_method'   => 'required|string', 
        ]);

        // 2. Ambil Detail Produk & Harga (Pastikan fillable di Model Order sudah benar)
        $product = Product::findOrFail($request->product_id);
        $invoiceNumber = 'INV-' . time() . '-' . rand(100, 999); 

        // 3. Simpan Pesanan
        $order = Order::create([
            'user_id'          => Auth::check() ? Auth::id() : null,
            'product_id'       => $product->id,
            'game_id'          => $product->game_id,
            'invoice_number'   => $invoiceNumber,
            'game_user_id'     => $request->game_user_id,
            'contact_whatsapp' => $request->contact_whatsapp,
            'total_price'      => $product->price,
            'payment_method'   => $request->payment_method,
            'status'           => 'pending', 
        ]);

        // 4. Redirect ke Halaman Konfirmasi Pembayaran
        return redirect()->route('order.confirmation', $order->invoice_number);
    }
    
    // Method confirmation() juga harus dipindahkan ke sini
    public function confirmation($invoiceNumber)
{
    $order = Order::where('invoice_number', $invoiceNumber)
                  ->with(['product.game']) // Penting untuk mendapatkan nama game
                  ->firstOrFail();
    
    // TIDAK ADA LOGIKA REDIRECT DI SINI

    return view('order.confirmation', compact('order')); // Pastikan nama view sudah benar
}
}