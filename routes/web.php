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

Route::group(['middleware'=>'web'],function() {
    Auth::routes();
    Route::get('/', function () {
        return redirect('login');
    });
    /**
     * Product Categories Routes
     */
    Route::resource('product-categories','ProductCategoryController');
    Route::get('get-product-categories', 'ProductCategoryController@getProductCategories')->name('get-product-categories');
    Route::get('product-category-edit/{productCategory}','ProductCategoryController@edit');
    Route::post('product-category-update/{productCategory}','ProductCategoryController@update');
    Route::get('/product-category/delete/{productCategory}','ProductCategoryController@destroy');
    /**
     * Product Routes
     */
    Route::resource('products','ProductController');
    Route::get('get-products', 'ProductController@getProducts')->name('get-products');
    Route::get('product-edit/{product}','ProductController@edit');
    Route::post('product-update/{product}','ProductController@update');
    Route::get('/product/delete/{product}','ProductController@destroy');
    Route::get('/create-product','ProductController@create');
    /**
     * Stock Controller routes
     */
    Route::get('assign-stock','StockController@index');
    Route::get('get-agents-assign-stock','StockController@getAgents')->name('get-agents-assign-stock');
    Route::get('assign-agent-stock/{agent}','StockController@assignAgentStock');
    Route::get('get-assigned-stock/{agent}','StockController@getAgentAssignedStock');
    /**
     * User Routes
     */
    Route::resource('users', 'UsersController');
    Route::get('get-users', 'UsersController@getUsers')->name('get-users');
    Route::get('create-user','UsersController@create');
    Route::get('/update-user/{agent}','UsersController@edit');

    Route::get('/user/delete/{user}', 'UsersController@destroy');
    Route::get('account-activation/{user}', 'RegisterController@verifyEmail');
    Route::get('user-profile','UsersController@getUserProfile');
    Route::get('agent-profile','UsersController@getUserProfile');
    Route::post('profile-update/{user}','UsersController@updateProfile');

    Route::get('account-completion/{user}','PublicController@accountCompletion');
    Route::post('verify-account/{user}','PublicController@verifyAccount');
    /**
     * Locations routes
     */
    Route::resource('locations', 'LocationController');
    Route::get('get-locations', 'LocationController@getLocations')->name('get-locations');
    Route::get('/location/delete/{location}', 'LocationController@destroy');
    Route::post('/location-update/{location}','LocationController@update');
    Route::get('/home', 'HomeController@index')->name('home');
});