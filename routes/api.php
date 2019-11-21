<?php

use Illuminate\Http\Request;
use App\Service\Settings;

URL::forceSchema('https');

Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {
    # Variables
    Route::post('variables/push', 'VariablesController@push');
    Route::post('variables/pull', 'VariablesController@pull');
    Route::resource('variables', 'VariablesController');
    Route::group(['prefix' => 'variables'], function() {
        Route::resource('groups', 'VariableGroupsController');
    });

    Route::post('header', function(Request $request) {
        Settings::set('header', $request->header);
    });

    Route::post('account', 'PaymentsController@account');

    # Pages
    Route::post('pages/checkExistance/{id?}', 'PagesController@checkExistance');
    Route::post('pages/search', 'PagesController@search');
    Route::post('pages/copy', 'PagesController@copy');
    Route::resource('pages', 'PagesController');
    Route::resource('pageitems', 'PageitemsController');

    # Translit
    Route::post('translit/to-url', 'TranslitController@toUrl');

    Route::resource('masters', 'MastersController');
    Route::post('prices/change', 'PricesController@change');
    Route::resource('prices', 'PricesController');
    Route::resource('prices/positions', 'PricePositionsController');


    Route::post('gallery/mass-update', 'GalleryController@massUpdate');
    Route::post('galleries/change', 'GalleryController@change');
    Route::resource('galleries', 'GalleryController');

    Route::post('tags/checkExistance/{id?}', 'TagsController@checkExistance');
    Route::get('tags/autocomplete', 'TagsController@autocomplete');
    Route::delete('tags/deleteByParams', 'TagsController@deleteByParams');
    Route::resource('tags', 'TagsController');
    Route::resource('users', 'UsersController');

    Route::post('videos/mass-update', 'VideosController@massUpdate');
    Route::resource('videos', 'VideosController');

    Route::get('folders/breadcrumbs/{id}', 'FoldersController@breadcrumbs');
    Route::post('folders/tree', 'FoldersController@tree');
    Route::resource('folders', 'FoldersController');
    Route::resource('allusers', 'AllUsersController');

    Route::post('reviews/mass-update', 'ReviewsController@massUpdate');
    Route::resource('reviews', 'ReviewsController');

    Route::resource('equipment', 'EquipmentController');

    Route::resource('logs', 'LogsController');

    # Sync
    Route::group(['prefix' => 'sync'], function() {
        Route::get('get/{table}', 'SyncController@get');
        Route::post('insert/{table}', 'SyncController@insert');
        Route::post('update/{table}', 'SyncController@update');
    });

    # Payments
    Route::post('payments/remainders', 'PaymentsController@remainders');
    Route::post('payments/stats', 'PaymentsController@stats');
    Route::post('payments/delete', 'PaymentsController@delete');

    Route::delete('photos/{id}', 'PhotosController@destroy');

    Route::group(['namespace' => 'Payments', 'prefix' => 'payments'], function() {
        Route::resource('sources', 'SourcesController');
        Route::resource('expendituregroups', 'ExpenditureGroupsController');
        Route::resource('expenditures', 'ExpendituresController');
    });

    Route::resource('payments', 'PaymentsController');

    # Search
    Route::post('search', 'SearchController@search');

    Route::resource('menu', 'MenuController');
    Route::resource('menu-sections', 'MenuSectionsController');
});
