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

Route::get('articles','ArticleController@index');
Route::get('article{id}','ArticleController@show');
Route::post('article','ArticleController@store');
Route::put('article','ArticleController@store');
Route::delete('article','ArticleController@destroy');

//Route for login in priceMonitor
Route::get('login','ContractController@login');
Route::post('updateContractInfo','ContractController@updateContractInfo');
Route::get('testVariationsApi','ContractController@testVariationsApi');

// Route for filters
Route::get('getFilters','FilterController@getFilters');
Route::post('saveFilter','FilterController@saveFilter');
Route::post('preview','FilterController@preview');

//Route for attributes mappings
Route::get('getMappedAttributes','AttributesMappingController@getMappedAttributes');
Route::post('saveAttributesMapping','AttributesMappingController@saveAttributesMapping');

//Route for account
Route::get('getAccountInfo','AccountController@getAccountInfo');
Route::post('saveAccountInfo','AccountController@saveAccountInfo');

//Route for schedule
Route::get('getSchedule','ProductExportController@getSchedule');
Route::post('saveSchedule','ProductExportController@saveSchedule');

//Route for export
Route::get('runProductExport','ProductExportController@runProductExport');
Route::get('sync','SyncController@run');

//Route for transactionHistory
Route::get('getTransactionHistory','TransactionHistoryController@getTransactionHistory');

//test url
Route::get('testVariationsApi','ContractController@testVariationsApi');
