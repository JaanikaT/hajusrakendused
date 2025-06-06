<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubjectController;
use App\Models\Subject;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::resource('marker', MarkerController::class);    
// Route::post('marker/create', MarkerController::class)
// // {
// //     return redirect()-> to(route('dashboard'));
// // })
//     ->middleware(['auth', 'verified'])
//     ->name('marker');


//Blog

Route::resource('posts', PostController::class)->middleware('auth');
Route::post('/comments/{post}', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->middleware('auth')
    ->name('comments.destroy');



//Store & Cart

Route::get('/products', [ProductController::class, 'index'])->middleware('auth')->name('products.index');


Route::controller(CartController::class)
    ->middleware('auth')
    ->prefix('/cart')
    ->name('cart.')
    ->group(function() {
        Route::post('/add/{product}', 'add')->name('add');
        Route::get('/', 'view')->name('checkout');
        Route::post('/clear', 'clear')->name('clear');
        Route::post('/update', 'update')->name('update');
    });


//tõstetud ülespoole CartControlleri sisse
//Route::get('checkout', [CartController::class, 'view'])->middleware('auth')->name('checkout');   



Route::post('/checkout', [CheckoutController::class, 'checkout']);

Route::get('/checkout/success', function () {
    session()->forget('cart');
    return Inertia::render('CheckoutSuccess');
})->name('checkout.success');

Route::get('/checkout/cancel', function () {
    return Inertia::render('CheckoutCancel');
})->name('checkout.cancel');




//API-d

Route::get('subjects',[SubjectController::class, 'index'])->name('subjects.index');

Route::get('display-subjects', function(){

    $datasets = [
        'andrus' => [
            'href' => 'https://hajus.ta23raamat.itmajakas.ee/api/movies',
            'custom_fields' => ['director', 'release_year'],
        ],

        'kert' => [
            'href' => 'https://hajus.tak23mand.itmajakas.ee/api/favourite/07b4cc44-9042-4944-b1dc-56eac757ca4f',
            'custom_fields' => ['genres', 'developer'],
        ],
        'katrin' => [
            'href' => 'https://hajusrakendused.ta23ansper.itmajakas.ee/subjects',
            'custom_fields' => ['rating', 'ranking'],
        ]
    ];
    
    $data = match(request('type')){
        'andrus'=> Http::get($datasets['andrus']['href'])->json(),
        'kert'=> Http::get($datasets['kert']['href'])->json(),
        'katrin'=> Http::get($datasets['katrin']['href'])->json(),
        default => Subject::all()->toArray(),
    };
    
    return Inertia::render('Subjects', [
        'data'=> $data,
        'customFields' => data_get($datasets, request('type').'.custom_fields',['comfort','seats'])
    ]);
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
