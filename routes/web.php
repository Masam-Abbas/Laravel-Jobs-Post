<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

//All listings
Route::get('/', [ListingController::class, 'index']);



//Show Create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//Store Listing Data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//Show edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Update Listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'delete'])->middleware('auth');

// Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manageListing'])->middleware('auth');


//Single listings
// Route::get('/listings/{id}', function ($id) {
//     $listing = Listing::find($id);

//     if ($listing) {
//         return view('listing', ['listing' => $listing]);
//     }else{
//         abort('404')
//     }
// });
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//Register User
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//Create New User
Route::post('/register', [UserController::class, 'store'])->middleware('guest');

//Logout User
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//Show login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// login User
Route::post('/login', [UserController::class, 'authenticate'])->middleware('guest');

