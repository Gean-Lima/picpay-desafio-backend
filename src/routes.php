<?php

use Neo\PicpayDesafioBackend\Controller\Web\HomeController;
use Neo\PicpayDesafioBackend\Http\Middleware\AuthMiddleware;
use Neo\PicpayDesafioBackend\Http\Response;
use Neo\PicpayDesafioBackend\Http\Routing\Route;

/**
 * Web Routes
 */

Route::get('/', [HomeController::class, 'index']);

/**
 * API Routes
 */

Route::get('/api/up', function() {
    return Response::json([
        'message' => 'Successfully',
        'status' => 'success'
    ]);
}, [AuthMiddleware::class]);

Route::post('/api/login', [AuthController::class, 'login']);

Route::post('/api/register', [AuthController::class, 'register']);
