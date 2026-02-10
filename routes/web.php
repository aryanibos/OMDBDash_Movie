<?php

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

Route::get('/', function() {
    return redirect()->route('movies.index');
})->name('home');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/movies', 'MovieController@index')->name('movies.index');
    Route::get('/movie/{imdbID}', 'MovieController@show')->name('movies.show');
    Route::get('/favorites', 'FavoriteController@index')->name('favorites.index');
    Route::post('/favorites', 'FavoriteController@store')->name('favorites.store');
    Route::delete('/favorites/{imdbID}', 'FavoriteController@destroy')->name('favorites.destroy');
});
Route::get('lang/{locale}', function ($locale) {
    session()->put('locale', $locale);
    return redirect()->back();
})->name('lang.switch');

Route::get('/home', function() {
    return redirect()->route('movies.index');
})->name('home');
