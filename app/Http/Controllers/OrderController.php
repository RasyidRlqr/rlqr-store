<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // app/Http/Controllers/OrderController.php

public function updateStatusFromBot(Request $request)
    {
        // 1. Verifikasi Keamanan (WAJIB)
        // Gunakan env() untuk membaca Secret Key dari .env
        if ($request->bot_key !== env('BOT_SECRET_KEY')) {
            return response()->json(['message' => 'Unauthorized: Invalid BOT_SECRET_KEY.'], 401);
        }

        // 2. Validasi Data dari Bot
        $request->validate([
            'invoice' => 'required|string',
            'new_status' => 'required|in:paid,processing,completed,failed',
        ]);
        
        // Bersihkan string dari spasi/karakter tersembunyi
        $invoiceNumber = trim($request->invoice); 
        $newStatus = $request->new_status;

        // --- 3. Cari Pesanan (Solusi Paling Aman untuk String Encoding) ---
        
        // Lakukan pencarian standar
        $order = Order::where('invoice_number', $invoiceNumber)->first();

        // JIKA GAGAL: Lakukan pencarian fallback dengan pembersihan (whereRaw TRIM)
        // Ini mengatasi masalah karakter tersembunyi atau encoding database.
        if (!$order) {
            $order = Order::whereRaw('TRIM(invoice_number) = ?', [trim($invoiceNumber)])->first();
        }

        if (!$order) {
            // Pesanan tidak ditemukan
            return response()->json(['message' => "Error: Invoice {$invoiceNumber} not found in database."], 404);
        }

        // --- 4. Proses Update Status ---
        
        $order->status = $newStatus;
        $order->admin_notes = "Updated via Bot: Status changed to {$newStatus}."; 
        
        // Atur paid_at jika status diubah menjadi 'paid' atau 'completed'
        if (in_array($newStatus, ['paid', 'completed']) && $order->paid_at === null) {
            $order->paid_at = now();
        }

        $order->save();

        // 5. Beri Respon Sukses ke Bot
        return response()->json([
            'message' => 'Order status updated successfully', 
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
// --- FITUR BARU: KIRIM NOTIFIKASI WEBHOOK KE DISCORD ---
        
        $adminOrderUrl = route('orders.index'); // Link ke Manajemen Pesanan Admin
        
        // Buat pesan yang ringkas dan jelas
        $discordMessage = [
            'content' => "@here 🚨 **ORDER BARU MASUK (INV: {$order->invoice_number})** 🚨",
            'embeds' => [
                [
                    'title' => "Top Up Baru: {$order->product->game->name}",
                    'description' => "Order ID: `{$order->invoice_number}`",
                    'color' => 16763904, // Warna Kuning/Oranye
                    'fields' => [
                        ['name' => 'Nominal', 'value' => $order->product->name, 'inline' => true],
                        ['name' => 'Harga', 'value' => "Rp " . number_format($order->total_price, 0, ',', '.'), 'inline' => true],
                        ['name' => 'ID Game', 'value' => $order->game_user_id, 'inline' => false],
                        ['name' => 'Metode Bayar', 'value' => $order->payment_method, 'inline' => false],
                        ['name' => 'Status', 'value' => 'PENDING', 'inline' => false],
                    ],
                    'footer' => [
                        'text' => 'Verifikasi pembayaran dan proses segera.',
                    ],
                    // Tombol link ke Panel Admin (link index orders)
                    'url' => $adminOrderUrl 
                ]
            ]
        ];

        try {
            Http::post(env('DISCORD_ORDER_WEBHOOK'), $discordMessage);
        } catch (\Exception $e) {
            // Gunakan Facade Log yang sudah diimport
            Log::error('Gagal mengirim Webhook Order: ' . $e->getMessage());
        }
        
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