<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['user' => 'API\UserController']);
Route::apiResources(['sozlamalar' => 'API\SozlamalarController']);
Route::apiResources(['clients' => 'API\ClientsController']);
Route::apiResources(['money' => 'API\MoneyController']);
Route::apiResources(['expenses' => 'API\ExpensesController']);
Route::apiResources(['spendings' => 'API\SpendingsController']);
Route::apiResources(['rawmaterials' => 'API\RawMaterialsController']);
Route::apiResources(['producttypes' => 'API\ProductTypesController']);
Route::apiResources(['products' => 'API\ProductController']);
Route::apiResources(['calculation' => 'API\CalculationController']);
Route::apiResources(['productions' => 'API\ProductionsController']);


Route::post('addclientcaregory', 'API\SozlamalarController@addClientCategory');
Route::post('updateclientcategory', 'API\SozlamalarController@updateClientCategory');
Route::post('deleteclientcategory', 'API\SozlamalarController@deleteClientCategory');
Route::get('clientcategories', 'API\SozlamalarController@getClientCategory');
Route::get('productbytype/{id}', 'API\ProductController@getProductByType');
Route::get('singlerowmaterials/{id}', 'API\CalculationController@getSingleProductRawMaterials');


// Route::get('api-location', 'PrimeApiController@location')->name('primeApiLocation');
// Route::post('api-contact', 'PrimeApiController@contact')->name('primeApiContact');
// Route::get('api-contact', 'PrimeApiController@contact')->name('primeApiContact');

