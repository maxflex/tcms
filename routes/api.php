<?php
URL::forceSchema('https');

Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {
    # Variables
    Route::post('variables/push', 'VariablesController@push');
    Route::post('variables/pull', 'VariablesController@pull');
    Route::resource('variables', 'VariablesController');
    Route::group(['prefix' => 'variables'], function() {
        Route::resource('groups', 'VariableGroupsController');
    });
    Route::group(['prefix' => 'pages'], function() {
        Route::resource('groups', 'PageGroupsController');
    });

    Route::post('payments/remainders', 'PaymentsController@remainders');

    # Pages
    Route::post('pages/checkExistance/{id?}', 'PagesController@checkExistance');
    Route::post('pages/search', 'PagesController@search');
    Route::resource('pages', 'PagesController');
    Route::resource('pageitems', 'PageitemsController');

    #pr
    Route::resource('programs', 'ProgramsController');

    # Translit
    Route::post('translit/to-url', 'TranslitController@toUrl');

    Route::get('sass/{file}', 'SassController@edit')->where('file', '.*.scss$');
    Route::post('sass/{file}', 'SassController@update')->where('file', '.*.scss$');
    Route::get('sass/{current_path?}', 'SassController@index')->where('current_path', '.*');

    Route::resource('photos', 'PhotosController');
    Route::group(['prefix' => 'photos'], function() {
        Route::resource('groups', 'PhotoGroupsController');
    });


    Route::resource('photos/updateAll', 'PhotosController@updateAll');
    Route::resource('photos', 'PhotosController');
    Route::resource('masters', 'MastersController');
    Route::post('prices/change', 'PricesController@change');
    Route::resource('prices', 'PricesController');
    Route::resource('prices/positions', 'PricePositionsController');
    Route::resource('gallery/folders', 'GalleryFoldersController');
    Route::resource('gallery', 'GalleryController');

    Route::post('tags/checkExistance/{id?}', 'TagsController@checkExistance');
    Route::get('tags/autocomplete', 'TagsController@autocomplete');
    Route::resource('tags', 'TagsController');
    Route::resource('users', 'UsersController');

    Route::resource('reviews', 'ReviewsController');
    Route::resource('equipment', 'EquipmentController');

    Route::resource('logs', 'LogsController');

    Route::resource('faq', 'FaqController');

    Route::group(['prefix' => 'faq'], function() {
        Route::resource('groups', 'FaqGroupsController');
    });

    # Factory
    Route::post('factory', 'FactoryController@get');

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

    Route::group(['namespace' => 'Payments', 'prefix' => 'payments'], function() {
        Route::resource('sources', 'SourcesController');
        Route::resource('expendituregroups', 'ExpenditureGroupsController');
        Route::resource('expenditures', 'ExpendituresController');
    });

    Route::resource('payments', 'PaymentsController');

    # Search
    Route::post('search', 'SearchController@search');
});
