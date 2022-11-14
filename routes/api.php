<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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

Route::get('version', function () {
    return response()->json(['version' => config('app.version')]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    Log::debug('User:' . serialize($request->user()));
    return $request->user();
});


Route::namespace('App\\Http\\Controllers\\API\V1')->group(function () {
    Route::get('dashboard', 'DashboardController@index');
    Route::get('profile', 'ProfileController@profile');
    Route::put('profile', 'ProfileController@updateProfile');
    Route::post('change-password', 'ProfileController@changePassword');
    Route::get('tag/list', 'TagController@list');
    Route::get('category/list', 'CategoryController@list');
    Route::post('product/upload', 'ProductController@upload');
    Route::post('employee/add', 'EmployeeController@store');
    Route::get('workbase/list', 'WorkBaseController@list');
    Route::get('employee/list', 'EmployeeController@list');
    Route::post('purchaseorder/search', 'PurchaseOrderController@searchEmployee');
    Route::post('dashboard/purchaseOrderDetails', 'DashboardController@purchaseOrderDetails');

    Route::apiResources([
        // 'dashboard' => 'DashboardController',
        'user' => 'UserController',
        'product' => 'ProductController',
        'employee' => 'EmployeeController',
        'workbase' => 'WorkBaseController',
        'purchaseorder' => 'PurchaseOrderController',
        'category' => 'CategoryController',
        'tag' => 'TagController',
    ]);
});
