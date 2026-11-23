<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Marketplace\MarketplaceController@index')->name('marketplace.home');
Route::get('/marketplace/listing/{id}', 'Marketplace\MarketplaceController@show')->name('marketplace.listings.show');

Route::get('/marketplace/login', 'Marketplace\MarketplaceAuthController@showLogin')->name('marketplace.login');
Route::post('/marketplace/login', 'Marketplace\MarketplaceAuthController@login')->name('marketplace.login.submit');
Route::get('/marketplace/register', 'Marketplace\MarketplaceAuthController@showRegister')->name('marketplace.register');
Route::post('/marketplace/register', 'Marketplace\MarketplaceAuthController@register')->name('marketplace.register.submit');
Route::post('/marketplace/logout', 'Marketplace\MarketplaceAuthController@logout')->name('marketplace.logout');

Route::group(['prefix' => 'marketplace', 'middleware' => 'marketplace.auth'], function () {
    Route::get('/my-listings', 'Marketplace\MarketplaceListingController@index')->name('marketplace.my-listings');
    Route::get('/listings/create', 'Marketplace\MarketplaceListingController@create')->name('marketplace.listings.create');
    Route::post('/listings', 'Marketplace\MarketplaceListingController@store')->name('marketplace.listings.store');
    Route::get('/listings/{id}/edit', 'Marketplace\MarketplaceListingController@edit')->name('marketplace.listings.edit');
    Route::put('/listings/{id}', 'Marketplace\MarketplaceListingController@update')->name('marketplace.listings.update');
    Route::delete('/listings/{id}', 'Marketplace\MarketplaceListingController@destroy')->name('marketplace.listings.destroy');
});
