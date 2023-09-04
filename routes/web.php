<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FibonacciController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Auth::routes();

//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', fn () => redirect('dashboard'));
Route::get('/sum-fibonacci', [FibonacciController::class, 'showForm']);
Route::post('/sum-fibonacci', [FibonacciController::class, 'sumFibonacci']);

Route::group(
    [
        'namespace' => 'App\Http\Controllers\Backend',
        //'prefix' => 'control',
        'as' => 'backend.',
        'middleware' => [
            'sidebar_backend'
        ]
    ],
    function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        Route::get('/transaksi', 'TransaksiController@index')->name('transaksi');

        Route::get('/list-transaksi', 'TransaksiController@indexDataTable')->name('list_transaksi');

        Route::get('/add-transaksi', 'TransaksiController@create')->name('add_transaksi');

        Route::get('/detail-transaksi/{id}', 'TransaksiController@edit')->name('detail_transaksi');

        Route::post('/save-transaksi', 'TransaksiController@store')->name('save_transaksi');

        Route::post('/update-transaksi/{id}', 'TransaksiController@update')->name('update_transaksi');

        Route::get('/delete-transaksi/{id}', 'TransaksiController@destroy')->name('delete_transaksi');

        Route::get('/rekap-transaksi', 'RekapTransaksiController@index')->name('rekap_transaksi');

        Route::get('/list-rekap-transaksi', 'RekapTransaksiController@indexDataTable')->name('rekap_list_transaksi');
    }
);
