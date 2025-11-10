<?php

// routes/api.php

use App\Http\Controllers\OrderController; 

// Route khusus Bot. Menggunakan POST karena ini adalah perintah perubahan data.
Route::post('/bot/update-order-status', [OrderController::class, 'updateStatusFromBot']);