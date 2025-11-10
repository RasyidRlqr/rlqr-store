<?php
// routes/api.php
use App\Http\Controllers\OrderController; 

Route::post('/bot/update-order-status', [OrderController::class, 'updateStatusFromBot']);