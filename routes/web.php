<?php
use App\Http\Middleware\LogUrlOpen;
use App\Service\Settings;

URL::forceSchema('https');

# Login
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');


Route::group(['middleware' => ['login', LogUrlOpen::class]], function () {
    # Variables
    Route::get('/', 'VariablesController@index');
    Route::resource('variables', 'VariablesController');

    # Pages
    Route::get('pages/export', 'PagesController@export')->name('pages.export');
    Route::post('pages/import', 'PagesController@import')->name('pages.import');
    Route::resource('pages', 'PagesController');
    Route::get('search', 'PagesController@search');

    Route::get('account', 'PaymentsController@account');

    Route::resource('logs', 'LogsController');

    Route::post('uploadPageitem', 'UploadController@pageItem');
    Route::post('galleryUpload', 'UploadController@galleryOriginal');
    Route::post('upload', 'UploadController@original');
    Route::post('upload/cropped', 'UploadController@cropped');

    Route::resource('masters', 'MastersController');
    Route::resource('equipment', 'EquipmentController');
    Route::resource('tags', 'TagsController');
    Route::resource('users', 'UsersController');

    Route::get('reviews/tag/{id}', 'ReviewsController@tag')->name('reviews.tag');
    Route::resource('reviews', 'ReviewsController');

    Route::resource('videos', 'VideosController');

    Route::get('prices/tag/{id}', 'PricesController@tag')->name('prices.tag');
    Route::get('prices/{id}/create', 'PricesController@create');
    Route::resource('prices', 'PricesController');
    Route::get('prices/positions/{id}/edit', 'PricePositionsController@edit');
    Route::resource('prices/{id}/positions', 'PricePositionsController');

    Route::get('galleries/tag/{id}', 'GalleryController@tag')->name('galleries.tag');
    Route::resource('galleries', 'GalleryController');

    Route::group(['namespace' => 'Payments', 'prefix' => 'payments'], function() {
        Route::resource('expenditures', 'ExpendituresController');
        Route::resource('sources', 'SourcesController');
    });
    Route::get('payments/remainders', 'PaymentsController@remainders');
    Route::get('payments/export', 'PaymentsController@export');
    Route::post('payments/import', 'PaymentsController@import');
    Route::resource('payments', 'PaymentsController');

    Route::get('header', function() {
        return view('header.index')->with(ngInit(['header' => Settings::get('header')]));
    });

    Route::get('mobile-menu', function() {
        return view('mobile-menu.index');
    });
});

# Templates for angular directives
Route::get('directives/{directive}', function($directive) {
    return view("directives.{$directive}");
});
