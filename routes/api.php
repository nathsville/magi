<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    // API untuk Z-Score Calculation (dari Python service)
    Route::post('/zscore/calculate', function (Request $request) {
        // Endpoint untuk menerima hasil perhitungan dari Python
        return response()->json([
            'status' => 'success',
            'data' => $request->all()
        ]);
    });
    
    // API untuk WhatsApp Webhook
    Route::post('/webhook/whatsapp', function (Request $request) {
        // Endpoint untuk menerima status pengiriman WhatsApp
        return response()->json([
            'status' => 'success'
        ]);
    });
});