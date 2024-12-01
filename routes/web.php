<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ComunicadoController;

Route::get('/', [ComunicadoController::class, 'index']);
Route::get('/comunicados/create/{id?}', [ComunicadoController::class, 'create'])->middleware('auth');
Route::delete("/comunicados/{id}", [ComunicadoController::class, 'delete']);
Route::post("/comunicados", [ComunicadoController::class, 'store']);

Route::get('/contact', function() {
    return view('contact');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        //return view('dashboard');
        return redirect('/');
    })->name('dashboard');
});
