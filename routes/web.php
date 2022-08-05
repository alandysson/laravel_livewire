<?php

use Illuminate\Support\Facades\Route;
use \App\Models\Expense;
use \Illuminate\Support\Facades\{Storage, File};
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
use \App\Http\Livewire\Expense\{ExpenseCreate, ExpenseEdit, ExpenseList};

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::prefix('expenses')->name('expenses.')->group(function(){
        Route::get('/', ExpenseList::class)->name('index');
        Route::get('/create', ExpenseCreate::class)->name('create');
        Route::get('/edit/{expense}', ExpenseEdit::class)->name('edit');
        Route::get('/{expense}/photo', function ($expense) {
            $expense = auth()->user()->expenses()->findOrFail($expense);
            if(!Storage::disk('public')->get($expense->photo)){
                return abort(404, 'Image not found!');
            }
            $image = Storage::disk('public')->get($expense->photo);
            $mimeType = File::mimeType(storage_path('app/public/'.$expense->photo));
            return response($image)->header('Content-type', $mimeType);

        })->name('photo');
    });
});
